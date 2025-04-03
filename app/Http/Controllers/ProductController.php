<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }


    public function list(Request $request)
    {
        $products = Product::query();


        return DataTables::of($products)
//            ->addColumn('checkbox', function ($category) {
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid">
//                <input class="form-check-input" type="checkbox" value="' . $category->id . '" />
//            </div>';
//            })
            ->addColumn('image', function ($item) {
                return '<div class="symbol symbol-50px">
                <span class="symbol-label" style="background-image:url(' . $item->getImage() . ');"></span>
            </div>';
            })
            ->addColumn('name', function ($item) {
                return '<div class="d-flex align-items-center">
                <div class="ms-5">
                    <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold view-questions" data-id="' . $item->id . '">' . $item->name . '</a>
                </div>
            </div>';
            })
            ->addColumn('details', function ($item) {
                return '<div class="badge badge-light-info"> <a href="#" class="menu-link px-3 view-questions" data-id="' . $item->id . '"><i class="bi bi-eye fs-2x"></i></i></a></div>';
            })
            ->addColumn('status', function ($item) {
                return $item->is_active
                    ? '<div class="badge badge-light-success">Active</div>'
                    : '<div class="badge badge-light-danger">Inactive</div>';
            })
            ->addColumn('created_at', function ($category) {
                return $category->created_at->format('M d, Y');
            })
            ->addColumn('actions', function ($item) {
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
                    <a href="' . route('admin.products.edit', $item->id) . '" class="menu-link px-3">Edit</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a id="delete" href="#" class="menu-link px-3 delete-category" data-action="' . route('admin.products.destroy', $item->id) . '" >Delete</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3 view-details" data-id="' . $item->id . '">View Details</a>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::Menu 3-->
        </div>
        <!--end::Menu-->
    </div>';
            })
            ->rawColumns(['image', 'name', 'status', 'actions'])
            ->make(true);
    }

    public function details( $id)
    {

        try {
            $product = Product::with(['images', 'category'])->findOrFail($id);

            // Process tags from JSON to array
            $tagsArray = json_decode($product->tags, true) ?? [];
            $formattedTags = array_map(function($tag) {
                return $tag['value'] ?? $tag;
            }, $tagsArray);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'category' => $product->category->name,
                    'tags' => implode(', ', $formattedTags),
                    'is_active' => $product->is_active,
                    'created_at' => $product->created_at->format('M d, Y'),
                    'updated_at' => $product->updated_at->format('M d, Y'),
                    'main_image' => $product->main_image,
                    'main_image_url' => $product->main_image ? $product->getImage() : null,
                    'images' => $product->images->map(function($image) {
                        return [
                            'id' => $image->id,
                            'image_url' => $image->getImage()
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch product details'
            ], 500);
        }
    }
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'main_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'is_active' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Start database transaction
        DB::beginTransaction();

        try {
            // Process the form data
            $data = $request->only(['name', 'description', 'price', 'tags', 'category_id', 'is_active']);

            // Handle main image
            if ($request->hasFile('main_image')) {
                $imagePath = $this->uploadFile($request->file('main_image'), 'products');
                $data['main_image'] = $imagePath;
            }

            // Create the product first
            $product = Product::create($data);

            // Initialize images array
            $images = [];

            // Process dropzone files if any
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $imagePath = $this->uploadFile($file, 'products');
                    $images[] = ['image' => $imagePath]; // assuming your images table has image_path column
                }

                // Save all images at once
                if (!empty($images)) {
                    $product->images()->createMany($images);
                }
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'redirect' => route('admin.products.index'),
                'message' => 'Product saved successfully'
            ]);

        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            // Log the error for debugging
            Log::error('Product store error: ' . $e->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Failed to save product. Please try again.'
            ], 500);
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        // Load the category with relationships
        $product->load(['images']);


        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        // Validate the request with more specific rules
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'required',
            'tags' => 'nullable|string|max:500',
            'is_active' => 'sometimes|boolean',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();

        try {
            // Verify product exists before updating
            if (!$product->exists) {
                throw new \Exception('Product not found');
            }

            // Prepare update data
            $updateData = [
                'name' => $validated['name'],
                'description' =>$validated['description'], // Sanitize HTML
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
                'tags' => $validated['tags'],
                'is_active' => $request->boolean('is_active')
            ];

            // Handle main image update
            if ($request->hasFile('main_image')) {
                $this->deleteImage($product->main_image); // Safe delete

                $imagePath = $this->uploadFile($request->file('main_image'), 'products');
                $updateData['main_image'] = $imagePath;
            }

            // Update product with all data
            $product->update($updateData);

            // Handle additional images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $this->uploadFile($image, 'products');
                    $product->images()->create(['image' => $path]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect' => route('admin.products.index'),
                'message' => 'Product Updated successfully'
            ]);


        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product update failed for product ' . $product->id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product. Please try again.'
            ]);

        }
    }

    public function destroy(Product $product)
    {
        try {
            // Delete questions and their images first
            $product->images->each(function ($image) {
                // Check if question has an image and delete it
                if ($image->image) {
                    $this->deleteImage($image->image);
                }
                $image->delete();
            });

            // Delete other related records
            $product->images()->delete();

            // Delete category image
            if ($product->main_image) {
                $this->deleteImage($product->main_image);
            }

            // Delete the category
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Category: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyImages($id)
    {
        $media = ProductImages::findOrFail($id);
        try {
            if ($media) {
                $this->deleteImage($media->image);
            }

            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Image: ' . $e->getMessage()
            ], 500);
        }

    }
}
