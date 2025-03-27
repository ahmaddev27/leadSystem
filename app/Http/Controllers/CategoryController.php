<?php

namespace App\Http\Controllers;

use App\Models\LeadType;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function list(Request $request)
    {
        $categories = Category::query()
            ->withCount(['products','questions']);


        return DataTables::of($categories)
            ->addColumn('checkbox', function ($category) {
                return '<div class="form-check form-check-sm form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" value="' . $category->id . '" />
            </div>';
            })
            ->addColumn('image', function ($category) {
                return '<div class="symbol symbol-50px">
                <span class="symbol-label" style="background-image:url(' . $category->getImage() . ');"></span>
            </div>';
            })
            ->addColumn('name', function ($category) {
                return '<div class="d-flex align-items-center">
                <div class="ms-5">
                    <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold view-questions" data-id="' . $category->id . '">' . $category->name . '</a>
                </div>
            </div>';
            })
            ->addColumn('details', function ($category) {
                return '<div class="badge badge-light-info"> <a href="#" class="menu-link px-3 view-questions" data-id="' . $category->id . '"><i class="bi bi-eye fs-2x"></i></i></a></div>';
            })
            ->addColumn('status', function ($category) {
                return $category->is_active
                    ? '<div class="badge badge-light-success">Active</div>'
                    : '<div class="badge badge-light-danger">Inactive</div>';
            })
            ->addColumn('created_at', function ($category) {
                return $category->created_at->format('M d, Y');
            })
            ->addColumn('actions', function($category) {
                return '<div class="d-flex justify-content-end">
        <!--begin::Menu-->
        <div class="me-0">
            <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <i class="ki-outline ki-dots-vertical fs-2"></i>
            </button>
            <!--begin::Menu 3-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="'.route('admin.categories.edit', $category->id).'" class="menu-link px-3">Edit</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a id="delete" href="#" class="menu-link px-3 delete-category" data-action="'.route('admin.categories.destroy',$category->id).'" >Delete</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3 view-questions" data-id="'.$category->id.'">View Questions</a>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::Menu 3-->
        </div>
        <!--end::Menu-->
    </div>';
            })
            ->rawColumns(['checkbox', 'image', 'name', 'status', 'actions', 'details'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.categories.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'commission.unqualified' => 'required|numeric|between:0,100',
            'commission.qualified' => 'required|numeric|between:0,100',
            'commission.converted' => 'required|numeric|between:0,100',
        ]);

        DB::beginTransaction();

        try {
            // Create category
            $category = Category::create([
                'name' => $validated['name'],
                'slug' => str_slug($validated['name']),
                'description' => $validated['description'],
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Handle category image
            if ($request->hasFile('image')) {
                $category->image = $this->uploadFile($request->file('image'), 'categories');
                $category->save();
            }

            // Save commissions
            $this->saveCommissions($category, $validated['commission']);

            // Save questions if present
            if ($request->has('questions')) {
                $this->saveQuestions($category, $request);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'redirect' => route('admin.categories.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'errors' => ['system' => [$e->getMessage()]]
            ], 500);
        }
    }

    protected function saveQuestions($category, $request)
    {
        foreach ($request->questions as $index => $questionData) {
            try {
                $validator = Validator::make($questionData, [
                    'question' => 'required|string|max:255',
                    'field_type' => 'required|in:text,textarea,select,radio,checkbox,number,email,date',
                    'options' => 'nullable|string',
                    'placeholder' => 'nullable|string|max:255',
                    'is_required' => 'sometimes|boolean',
                    'order' => 'sometimes|integer|min:0'
                ]);

                if ($validator->fails()) {
                    throw new \Exception("Question #" . ($index + 1) . " validation failed: " . implode(' ', $validator->errors()->all()));
                }

                $validated = $validator->validated();

                // Handle question icon
                $iconPath = null;
                if ($request->hasFile("questions.{$index}.icon")) {
                    $iconPath = $this->uploadFile($request->file("questions.{$index}.icon"), 'question-icons');
                }

                // Create question
                $question = new CategoryQuestion([
                    'question' => $validated['question'],
                    'field_type' => $validated['field_type'],
                    'icon' => $iconPath,
                    'placeholder' => $validated['placeholder'] ?? null,
                    'is_required' => $validated['is_required'] ?? false,
                    'order' => $validated['order'] ?? 0,
                ]);

                // Handle options
                if (in_array($validated['field_type'], ['select', 'radio', 'checkbox']) && !empty($validated['options'])) {
                    $options = array_filter(
                        array_map('trim', explode("\n", $validated['options'])),
                        fn($item) => !empty($item)
                    );
                    $question->options = $options;
                }

                $category->questions()->save($question);

            } catch (\Exception $e) {
                throw new \Exception("Error processing question #" . ($index + 1) . ": " . $e->getMessage());
            }
        }
    }

    protected function saveCommissions($category, $commissions)
    {
        $leadTypes = [
            'unqualified' => LeadType::where('slug', 'unqualified')->firstOrFail()->id,
            'qualified' => LeadType::where('slug', 'qualified')->firstOrFail()->id,
            'converted' => LeadType::where('slug', 'converted')->firstOrFail()->id,
        ];

        foreach ($leadTypes as $type => $leadTypeId) {
            $category->commissionStructures()->create([
                'lead_type_id' => $leadTypeId,
                'commission_percentage' => $commissions[$type]
            ]);
        }
    }


// Edit Method
    public function edit($id)
    {
        $productCategory = Category::findOrFail($id);

        // Load the category with relationships
        $productCategory->load([
            'commissionStructures.leadType',
            'questions'
        ]);

        // Format commissions
        $commissions = [];
        foreach ($productCategory->commissionStructures as $commission) {
            $commissions[$commission->leadType->slug] = $commission->commission_percentage;
        }

        // Prepare questions data for JS
        $questions = $productCategory->questions->map(function ($question) {
            return [
                'question' => $question->question,
                'field_type' => $question->field_type,
                'options' => $question->options,
                'placeholder' => $question->placeholder,
                'is_required' => $question->is_required,
                'order' => $question->order,
                'icon_url' => $question->icon_url
            ];
        });

        return view('admin.categories.edit', [
            'category' => $productCategory,
            'commissions' => $commissions,
            'initialQuestions' => $questions
        ]);
    }

// Update Method
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'commission.unqualified' => 'required|numeric|between:0,100',
            'commission.qualified' => 'required|numeric|between:0,100',
            'commission.converted' => 'required|numeric|between:0,100',
        ]);

        DB::beginTransaction();

        $productCategory = Category::findOrFail($id);
        try {
            // Update category
            $productCategory->update([
                'name' => $validated['name'],
                'slug' => str_slug($validated['name']),
                'description' => $validated['description'],
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Handle category image update
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($productCategory->image) {
                    Storage::disk('public')->delete($productCategory->image);
                }
                $productCategory->image = $this->uploadFile($request->file('image'), 'categories');
                $productCategory->save();
            }

            // Update commissions
            $this->updateCommissions($productCategory, $validated['commission']);

            // Handle questions update
            if ($request->has('questions')) {
                $this->updateQuestions($productCategory, $request);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'redirect' => route('admin.categories.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'errors' => ['system' => [$e->getMessage()]]
            ], 500);
        }
    }

    protected function updateCommissions($category, $commissions)
    {
        $leadTypes = [
            'unqualified' => LeadType::where('slug', 'unqualified')->firstOrFail()->id,
            'qualified' => LeadType::where('slug', 'qualified')->firstOrFail()->id,
            'converted' => LeadType::where('slug', 'converted')->firstOrFail()->id,
        ];

        foreach ($leadTypes as $type => $leadTypeId) {
            $category->commissionStructures()
                ->where('lead_type_id', $leadTypeId)
                ->update(['commission_percentage' => $commissions[$type]]);
        }
    }

    protected function updateQuestions($category, $request)
    {
        $existingQuestionIds = $category->questions->pluck('id')->toArray();
        $updatedQuestionIds = [];

        foreach ($request->questions as $index => $questionData) {
            try {
                $validator = Validator::make($questionData, [
                    'question' => 'required|string|max:255',
                    'field_type' => 'required|in:text,textarea,select,radio,checkbox,number,email,date',
                    'options' => 'nullable|string',
                    'placeholder' => 'nullable|string|max:255',
                    'is_required' => 'sometimes|boolean',
                    'order' => 'sometimes|integer|min:0',
                    'id' => 'sometimes|integer|exists:category_questions,id' // For existing questions
                ]);

                if ($validator->fails()) {
                    throw new \Exception("Question #" . ($index + 1) . " validation failed: " . implode(' ', $validator->errors()->all()));
                }

                $validated = $validator->validated();

                // Handle question icon
                $iconPath = null;
                if ($request->hasFile("questions.{$index}.icon")) {
                    // Delete old icon if exists
                    if (isset($validated['id'])) {
                        $oldQuestion = CategoryQuestion::find($validated['id']);
                        if ($oldQuestion->icon) {
                            Storage::disk('public')->delete($oldQuestion->icon);
                        }
                    }
                    $iconPath = $this->uploadFile($request->file("questions.{$index}.icon"), 'question-icons');
                }

                // Update or create question
                $questionData = [
                    'question' => $validated['question'],
                    'field_type' => $validated['field_type'],
                    'placeholder' => $validated['placeholder'] ?? null,
                    'is_required' => $validated['is_required'] ?? false,
                    'order' => $validated['order'] ?? 0,
                ];

                if ($iconPath) {
                    $questionData['icon'] = $iconPath;
                }

                // Handle options
                if (in_array($validated['field_type'], ['select', 'radio', 'checkbox']) && !empty($validated['options'])) {
                    $options = array_filter(
                        array_map('trim', explode("\n", $validated['options'])),
                        fn($item) => !empty($item)
                    );
                    $questionData['options'] = $options;
                } else {
                    $questionData['options'] = null;
                }

                if (isset($validated['id'])) {
                    // Update existing question
                    $category->questions()->where('id', $validated['id'])->update($questionData);
                    $updatedQuestionIds[] = $validated['id'];
                } else {
                    // Create new question
                    $newQuestion = $category->questions()->create($questionData);
                    $updatedQuestionIds[] = $newQuestion->id;
                }

            } catch (\Exception $e) {
                throw new \Exception("Error processing question #" . ($index + 1) . ": " . $e->getMessage());
            }
        }

        // Delete questions that were removed
        $questionsToDelete = array_diff($existingQuestionIds, $updatedQuestionIds);
        if (!empty($questionsToDelete)) {
            // Delete associated icons first
            $questionsWithIcons = $category->questions()
                ->whereIn('id', $questionsToDelete)
                ->whereNotNull('icon')
                ->get();

            foreach ($questionsWithIcons as $question) {
                Storage::disk('public')->delete($question->icon);
            }

            // Delete the questions
            $category->questions()->whereIn('id', $questionsToDelete)->delete();
        }
    }

    public function details($id)
    {
        $category = Category::with(['questions', 'commissionStructures.leadType'])->findOrFail($id);

        // Format commissions
        $commissions = [];
        foreach ($category->commissionStructures as $commission) {
            $commissions[$commission->leadType->slug] = $commission->commission_percentage;
        }

        $category->image = $category->getImage();
        return response()->json([
            'questions' => $category->questions->map(function ($question) {
                return [
                    'question' => $question->question,
                    'field_type' => $question->field_type,
                    'is_required' => $question->is_required,
                    'options' => $question->options,
                    'order' => $question->order,

                ];
            }),
            'commissions' => $commissions,
            'category' => $category
        ]);
    }

    public function destroy(Category $category)
    {
        try {
            // Delete questions and their images first
            $category->questions->each(function($question) {
                // Check if question has an image and delete it
                if ($question->icon) {
                    $this->deleteImage($question->icon);
                }
                $question->delete();
            });

            // Delete other related records
            $category->products()->delete();
            $category->commissionStructures()->delete();
            $category->leadTypes()->delete();

            // Delete category image
            if ($category->image) {
                $this->deleteImage($category->image);
            }

            // Delete the category
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Category: ' . $e->getMessage()
            ], 500);
        }
    }
}
