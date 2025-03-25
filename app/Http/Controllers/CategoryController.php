<?php

namespace App\Http\Controllers;

use App\Models\LeadType;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CommissionStructure;
use App\Models\CategoryQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }


    public function create()
    {
        return view('admin.categories.create');
    }


    public function store(Request $request)
    {
        // Validate the main form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required',
            'description' => 'required|string',
            'is_active' => 'boolean',
            'commission.unqualified' => 'required|numeric|between:0,100',
            'commission.qualified' => 'required|numeric|between:0,100',
            'commission.converted' => 'required|numeric|between:0,100',


            'questions' => 'sometimes|array',
            'questions.*.question' => 'required_with:questions|string|max:255',
            'questions.*.field_type' => 'required_with:questions|in:text,textarea,select,radio,checkbox,number,email,date',
            'questions.*.options' => 'required_if:questions.*.field_type,select,radio,checkbox|nullable|string',
            'questions.*.is_required' => 'sometimes|boolean',
            'questions.*.order' => 'sometimes|integer|min:0'

        ]);

        // Get lead types first to verify they exist
        $leadTypes = [
            'unqualified' => LeadType::where('slug', 'unqualified')->first(),
            'qualified' => LeadType::where('slug', 'qualified')->first(),
            'converted' => LeadType::where('slug', 'converted')->first(),
        ];

        // Verify all lead types exist
        foreach ($leadTypes as $slug => $leadType) {
            if (!$leadType) {
                return response()->json([
                    'success' => false,
                    'message' => "Lead type '{$slug}' not found in database",
                    'errors' => ['commission' => ["Missing lead type configuration for {$slug} leads"]]
                ], 422);
            }
        }

        // Start database transaction
        DB::beginTransaction();

        try {
            // Create the product category
            $category = Category::create([
                'name' => $validated['name'],
                'slug' => str_slug($validated['name']),
                'description' => $validated['description'],
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Create commission structures
            $commissionData = [
                [
                    'lead_type_id' => $leadTypes['unqualified']->id,
                    'commission_percentage' => $validated['commission']['unqualified']
                ],
                [
                    'lead_type_id' => $leadTypes['qualified']->id,
                    'commission_percentage' => $validated['commission']['qualified']
                ],
                [
                    'lead_type_id' => $leadTypes['converted']->id,
                    'commission_percentage' => $validated['commission']['converted']
                ],
            ];

            foreach ($commissionData as $data) {
                $category->commissionStructures()->create($data);
            }

            // Process questions if they exist
            // Process questions if they exist
            if ($request->has('questions')) {
                $questions = json_decode($request->input('questions'), true);

                // Validate the questions array structure first
                if (!is_array($questions)) {
                    throw new \Exception("Invalid questions format");
                }

                foreach ($questions as $index => $questionData) {
                    try {
                        $validator = Validator::make($questionData, [
                            'question' => 'required|string|max:255',
                            'field_type' => 'required|in:text,textarea,select,radio,checkbox,number,email,date',
                            'options' => 'nullable|string',
                            'is_required' => 'sometimes|boolean',
                            'order' => 'sometimes|integer|min:0'
                        ]);

                        if ($validator->fails()) {
                            throw new \Illuminate\Validation\ValidationException($validator);
                        }

                        $validatedQuestion = $validator->validated();

                        $question = new CategoryQuestion([
                            'question' => $validatedQuestion['question'],
                            'field_type' => $validatedQuestion['field_type'],
                            'is_required' => $validatedQuestion['is_required'] ?? false,
                            'order' => $validatedQuestion['order'] ?? 0,
                        ]);

                        // Process options for select/radio/checkbox fields
                        if (in_array($validatedQuestion['field_type'], ['select', 'radio', 'checkbox'])) {
                            $options = array_filter(
                                array_map('trim', explode("\n", $validatedQuestion['options'] ?? '')),
                                fn($item) => !empty($item)
                            );

                            if (empty($options)) {
                                throw new \Exception("Options are required for {$validatedQuestion['field_type']} field type");
                            }

                            $question->options = $options;
                        }

                        $category->questions()->save($question);

                    } catch (\Illuminate\Validation\ValidationException $e) {
                        // Convert validation errors to a more specific message
                        $errors = $e->validator->errors()->all();
                        throw new \Exception("Question #" . ($index + 1) . " validation failed: " . implode(' ', $errors));
                    }
                }
            }
            // Commit transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product category created successfully',
                'redirect' => route('admin.categories.index')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error creating product category: ' . $e->getMessage(),
                'errors' => ['system' => [$e->getMessage()]]
            ], 500);
        }
    }
}
