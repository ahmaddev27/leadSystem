@extends('admin.layouts.master', ['tab_title'=>'Create Product'])
@section('MainTitle', 'Product  Management')
@section('title', 'Leads System')
@section('title_link', route('admin.dashboard'))
@section('subtitle1', 'Products')
@section('subtitle1_link', route('admin.products.index'))
@section('subtitle2', 'New Product')
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
                  action="{{ route("admin.products.store") }}"
                  enctype="multipart/form-data">
                @csrf
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
                            <!--begin::Image input placeholder-->

                            <!--end::Image input placeholder-->
                            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                 data-kt-image-input="true">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-150px h-150px"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    aria-label="Change avatar" data-bs-original-title="Change avatar"
                                    data-kt-initialized="1">
                                    <i class="ki-outline ki-pencil fs-7"></i>
                                    <!--begin::Inputs-->

                                    <input type="file" id="main_image" name="main_image" accept=".png, .jpg, .jpeg" required>
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
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg
                                image files are accepted
                            </div>


                            <!--end::Description-->
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
                            <!--begin::Label-->
                            <label class="form-label">Category</label>
                            <!--end::Label-->
                            <!--begin::Select2-->
                            <select class="form-select mb-2 " required id="select2" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" name="category_id">
                                <option></option>
                               @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <!--end::Select2-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7 mb-7">Add product to a category.</div>
                            <!--end::Description-->


                            <!--end::Input group-->
                            <!--begin::Button-->
                            <a href="{{route('admin.categories.create')}}"
                               class="btn btn-light-primary btn-sm mb-10">
                                <i class="ki-outline ki-plus fs-2"></i>Create new category</a>
                            <!--end::Button-->
                            <!--begin::Input group-->
                            <!--begin::Label-->
                            <label class="form-label d-block">Tags</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input id="tags" name="tags"
                                   class="form-control mb-2 tags" value=""/>
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Add tags to a product.</div>
                            <!--end::Description-->
                            <!--end::Input group-->
                        </div>
                        <!--end::Card body-->

                        <div class="row mb-8 m-5">
                            <!--begin::Col-->
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3">Status</div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->

                            <div class="col-xl-9">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" id="is_active"
                                           name="is_active" checked="checked">
                                    <label class="form-check-label fw-semibold text-gray-400 ms-3"
                                           for="is_active">Active</label>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>

                    </div>
                    <!--end::Category & tags-->


                </div>
                <!--end::Aside column-->
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

                    <!--end:::Tabs-->
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::General options-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>General</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="required form-label">Product Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name" class="form-control mb-2" id="product_name"   placeholder="Product name" value="">
                                            <!--end::Input-->

                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div>
                                            <!--begin::Label-->
                                            <label class="form-label">Description</label>
                                            <!--end::Label-->
                                            <!--begin::Editor-->
                                            <div id="kt_docs_quill_basic"></div>
                                            <!--end::Editor-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Set a description to the product for better
                                                visibility.
                                            </div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->

                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::General options-->
                                <!--begin::Media-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Media</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <!--begin::Dropzone-->
                                    <div class="dropzone m-5" id="kt_dropzonejs_example_1">
                                        <!--begin::Message-->
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

                                            <!--begin::Info-->
                                            <div class="ms-4">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                <span class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                    </div>
                                    <!--end::Dropzone-->
                                    <!--end::Card header-->
                                </div>
                                <!--end::Media-->
                                <!--begin::Pricing-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Pricing</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="required form-label">Product Price</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="number" min="0" name="price" class="form-control mb-2"
                                                   placeholder="Product price" value="">
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Set the product price.</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->

                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::Pricing-->
                            </div>
                        </div>
                        <!--end::Tab pane-->

                    </div>
                    <!--end::Tab content-->

                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <button type="submit"  id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Button-->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('kt_ecommerce_add_product_form');
            const submitButton = document.getElementById('kt_ecommerce_add_product_submit');

            // Initialize Quill editor
            const quill = new Quill('#kt_docs_quill_basic', {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'font': [] }],
                        [{ 'align': [] }],
                        ['clean']
                    ]
                },
                placeholder: 'Type your product description here...',
                theme: 'snow'
            });



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

            // Custom validation for Quill editor
            const quillValidation = {
                validate: function() {
                    const html = quill.root.innerHTML;
                    return html.trim() !== '' && html !== '<p><br></p>';
                }
            };



            // Custom validation for main image
            const mainImageValidation = {
                validate: function() {
                    const fileInput = document.getElementById('main_image');
                    return fileInput.files.length > 0;
                }
            };

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

            // Manually validate special fields on change
            document.getElementById('main_image').addEventListener('change', function() {
                validator.revalidateField('main_image');
            });

            $('.tags').on('itemAdded itemRemoved', function() {
                validator.revalidateField('tags');
            });

            quill.on('text-change', function() {
                validator.revalidateField('description');
            });

            // Form submission handler
            submitButton.addEventListener('click', function(e) {
                e.preventDefault();

                validator.validate().then(function(status) {
                    if (status === 'Valid') {
                        // Show loading state
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        // Prepare form data
                        let formData = new FormData(form);

                        // Add Dropzone files
                        myDropzone.getAcceptedFiles().forEach((file) => {
                            formData.append('images[]', file);
                        });

                        // Add Quill editor content
                        formData.append('description', quill.root.innerHTML);

                        // Add tags
                        // formData.append('tags', $('.tags').tagsinput('items').join(','));

                        // AJAX request
                        $.ajax({
                            url: form.action || '{{ route("admin.products.store") }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Handle response
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;

                                if (response.success) {
                                    toastr.success(response.message || "Saved successfully!");
                                    if (response.redirect) {
                                        setTimeout(() => window.location.href = response.redirect, 1500);
                                    }
                                } else {
                                    toastr.error(response.message || "Error occurred");
                                    if (response.errors) {
                                        Object.values(response.errors).flat().forEach(error => toastr.error(error));
                                    }
                                }
                            },
                            error: function(xhr) {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;
                                if (xhr.responseJSON?.errors) {
                                    Object.values(xhr.responseJSON.errors).flat().forEach(error => toastr.error(error));
                                }
                            }
                        });
                    } else {
                        toastr.error("Please correct form errors");
                    }
                });
            });
        });
    </script>
@endpush
