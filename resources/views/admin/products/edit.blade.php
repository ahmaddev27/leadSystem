@extends('admin.layouts.master', ['tab_title'=>$product->name])
@section('MainTitle', 'Product  Management')
@section('title', 'Leads System')
@section('title_link', route('admin.dashboard'))
@section('subtitle1', 'Products')
@section('subtitle1_link', route('admin.products.index'))
@section('subtitle2', 'Edit Product')
@push('css')
    <!-- Font Awesome for icons -->

    <style>.image-input-placeholder {
            background-image: url('{{url('dashboard/assets/media/svg/files/blank-image.svg')}}');
        }

        [data-bs-theme="dark"] .image-input-placeholder {
            background-image: url('{{url('dashboard/assets/media/svg/files/blank-image-dark.svg')}}');
        }</style>
    <style>
        #kt_docs_quill_basic .ql-editor {
            min-height: 200px; /* Adjust as needed for 5 rows */
        }

        .options-preview {
            padding: 15px;
            border: 1px dashed #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
    </style>
@endpush
@section('content')

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Form-->
            <form id="kt_ecommerce_add_product_form"
                  class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
                  method="POST"
                  action="{{ route('admin.products.update', $product->id) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!--begin::Aside column-->
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Main Image</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body text-center pt-0">
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline mb-3" data-kt-image-input="true">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-150px h-150px"
                                     style="background-image: url('{{ $product->getImage() }}')"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    aria-label="Change avatar" data-bs-original-title="Change avatar"
                                    data-kt-initialized="1">
                                    <i class="ki-outline ki-pencil fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" id="main_image" name="main_image" accept=".png, .jpg, .jpeg">
                                    <input type="hidden" name="avatar_remove">
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                    aria-label="Cancel avatar" data-bs-original-title="Cancel avatar"
                                    data-kt-initialized="1">
                        <i class="ki-outline ki-cross fs-2"></i>
                    </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                    aria-label="Remove avatar" data-bs-original-title="Remove avatar"
                                    data-kt-initialized="1">
                        <i class="ki-outline ki-cross fs-2"></i>
                    </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg
                                image files are accepted
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Thumbnail settings-->

                    <!--begin::Category & tags-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Product Details</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <label class="form-label">Category</label>
                            <select class="form-select mb-2" required id="select2" data-control="select2"
                                    data-placeholder="Select an option" data-allow-clear="true" name="category_id">
                                <option></option>
                                @foreach($categories as $category)
                                    <option
                                        value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-muted fs-7 mb-7">Add product to a category.</div>

                            <a href="{{ route('admin.categories.create') }}"
                               class="btn btn-light-primary btn-sm mb-10">
                                <i class="ki-outline ki-plus fs-2"></i>Create new category</a>

                            <label class="form-label d-block">Tags</label>
                            <input id="tags" name="tags"
                                   class="form-control mb-2 tags" value="{{ $product->tags }}"/>
                            <div class="text-muted fs-7">Add tags to a product.</div>
                        </div>
                        <!--end::Card body-->

                        <div class="row mb-8 m-5">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3">Status</div>
                            </div>
                            <div class="col-xl-9">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" id="is_active"
                                           name="is_active" {{ $product->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold text-gray-400 ms-3"
                                           for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Category & tags-->
                </div>
                <!--end::Aside column-->
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::General options-->
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>General</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="mb-10 fv-row fv-plugins-icon-container">
                                            <label class="required form-label">Product Name</label>
                                            <input type="text" name="name" class="form-control mb-2" id="product_name"
                                                   placeholder="Product name" value="{{ $product->name }}">
                                        </div>
                                        <div>
                                            <label class="form-label">Description</label>
                                            <div id="kt_docs_quill_basic">{!! $product->description !!}</div>
                                            <input type="hidden" name="description" id="description_input"
                                                   value="{{ $product->description }}">
                                            <div class="text-muted fs-7">Set a description to the product for better
                                                visibility.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::General options-->

                                <!--begin::Media-->
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Media</h2>
                                        </div>
                                    </div>
                                    <!-- Display existing media files -->
                                    @if($product->images->count() > 0)
                                        <div class="existing-media-container m-5">
                                            <h4 class="mb-3">Existing Media</h4>
                                            <div class="row">
                                                @foreach($product->images as $image)
                                                    <div class="col-md-3 mb-3 existing-media-item" data-media-id="{{ $image->id }}">
                                                        <div class="position-relative">
                                                            <img src="{{ $image->getImage() }}" class="img-thumbnail"
                                                                 style="width: 100%; height: 150px; object-fit: cover;">
                                                            <button type="button"
                                                                    class="btn btn-icon btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                                    onclick="deleteMedia({{ $image->id }})">
                                                                <i class="ki-outline ki-trash fs-2"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="existing-media-container m-5">
                                            <div class="text-muted text-center py-3">No media files found</div>
                                        </div>
                                    @endif

                                    <!-- Dropzone for new uploads -->
                                    <div class="dropzone m-5" id="kt_dropzonejs_example_1">
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                    class="path1"></span><span class="path2"></span></i>
                                            <div class="ms-4">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to
                                                    upload.</h3>
                                                <span
                                                    class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Media-->

                                <!--begin::Pricing-->
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Pricing</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="mb-10 fv-row fv-plugins-icon-container">
                                            <label class="required form-label">Product Price</label>
                                            <input type="number" min="0" name="price" class="form-control mb-2"
                                                   placeholder="Product price" value="{{ $product->price }}">
                                            <div class="text-muted fs-7">Set the product price.</div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Pricing-->
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                        </button>
                    </div>
                </div>
                <!--end::Main column-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content container-->
    </div>
@stop

@push('js')
    <!--begin::Form-->



    <script>
        // Initialize Quill editor
        var quill = new Quill('#kt_docs_quill_basic', {
            theme: 'snow'
        });

        // Update hidden input with Quill content before form submission
        document.getElementById('kt_ecommerce_add_product_form').onsubmit = function () {
            var description = document.querySelector('#kt_docs_quill_basic .ql-editor').innerHTML;
            document.getElementById('description_input').value = description;
        };

        // Function to handle media deletion
        window.deleteMedia = function(mediaId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    const deleteBtn = $(`[onclick="deleteMedia(${mediaId})"]`);
                    deleteBtn.html('<i class="fas fa-spinner fa-spin"></i>');
                    deleteBtn.prop('disabled', true);

                    $.ajax({
                        url: `{{ route('admin.products.images.destroy', '') }}/${mediaId}`,
                        type: 'DELETE', // Changed to DELETE to match Laravel conventions
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message || 'Media deleted successfully',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Correct way to remove the media element
                                $(`.existing-media-item[data-media-id="${mediaId}"]`).remove();

                                // Check if any media items remain
                                if ($('.existing-media-item').length === 0) {
                                    $('.existing-media-container').html(
                                        '<div class="text-muted text-center py-3">No media files found</div>'
                                    );
                                }
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message || 'Error deleting media',
                                    icon: 'error'
                                });
                                deleteBtn.html('<i class="ki-outline ki-trash fs-2"></i>');
                                deleteBtn.prop('disabled', false);
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Error deleting media',
                                icon: 'error'
                            });
                            deleteBtn.html('<i class="ki-outline ki-trash fs-2"></i>');
                            deleteBtn.prop('disabled', false);
                        }
                    });
                }
            });
        };    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('kt_ecommerce_add_product_form');
            const submitButton = document.getElementById('kt_ecommerce_add_product_submit');

            // Initialize Quill editor with existing content
            const quill = new Quill('#kt_docs_quill_basic', {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{'header': 1}, {'header': 2}],
                        [{'list': 'ordered'}, {'list': 'bullet'}],
                        [{'script': 'sub'}, {'script': 'super'}],
                        [{'indent': '-1'}, {'indent': '+1'}],
                        [{'direction': 'rtl'}],
                        [{'size': ['small', false, 'large', 'huge']}],
                        [{'header': [1, 2, 3, 4, 5, 6, false]}],
                        [{'color': []}, {'background': []}],
                        [{'font': []}],
                        [{'align': []}],
                        ['clean']
                    ]
                },
                placeholder: 'Type your product description here...',
                theme: 'snow'
            });

            // Set existing description if available
            const descriptionInput = document.getElementById('description_input');
            if (descriptionInput && descriptionInput.value) {
                quill.root.innerHTML = descriptionInput.value;
            }

            // Initialize Dropzone
            const myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
                url: "/l",
                autoProcessQueue: false,
                paramName: "images",
                maxFiles: 10,
                maxFilesize: 2,
                addRemoveLinks: true,
                acceptedFiles: "image/*"
            });

            // Form validation setup
            const validator = FormValidation.formValidation(
                form,
                {
                    fields: {
                        'name': {
                            validators: {
                                notEmpty: {
                                    message: 'Product name is required'
                                }
                            }
                        },
                        'price': {
                            validators: {
                                notEmpty: {
                                    message: 'Price is required'
                                },
                                numeric: {
                                    message: 'Price must be a number'
                                },
                            }
                        },

                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            // Revalidate when content changes
            quill.on('text-change', function () {
                validator.revalidateField('description');
            });

            // Form submission handler for UPDATE
            submitButton.addEventListener('click', function (e) {
                e.preventDefault();

                validator.validate().then(function (status) {
                    if (status === 'Valid') {
                        // Show loading state
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        // Prepare form data
                        let formData = new FormData(form);

                        // Add _method for Laravel to recognize as PUT request
                        formData.append('_method', 'PUT');

                        // Add Dropzone files if any
                        myDropzone.getAcceptedFiles().forEach((file) => {
                            formData.append('images[]', file);
                        });

                        // Add Quill editor content
                        formData.append('description', quill.root.innerHTML);

                        // AJAX request for UPDATE
                        $.ajax({
                            url: form.action, // This should already be the update route with product ID
                            type: 'POST', // Must be POST for FormData with _method='PUT'
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                // Handle response
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;

                                if (response.success) {
                                    toastr.success(response.message || "Product updated successfully!");
                                    if (response.redirect) {
                                        setTimeout(() => window.location.href = response.redirect, 1500);
                                    }
                                } else {
                                    toastr.error(response.message || "Error occurred while updating");
                                    if (response.errors) {
                                        Object.values(response.errors).flat().forEach(error => toastr.error(error));
                                    }
                                }
                            },
                            error: function (xhr) {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;
                                if (xhr.responseJSON?.errors) {
                                    Object.values(xhr.responseJSON.errors).flat().forEach(error => toastr.error(error));
                                } else {
                                    toastr.error("An error occurred while updating the product");
                                }
                            }
                        });
                    } else {
                        toastr.error("Please correct form errors before submitting");
                    }
                });
            });

        });
    </script>

@endpush
