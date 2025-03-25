@extends('admin.layouts.master')
@section('MainTitle', 'Product Categories Management')
@section('title', 'Leads System')
@section('title_link', route('admin.dashboard'))
@section('subtitle1', 'Categories')
@section('subtitle1_link', route('admin.categories.index'))
@section('subtitle2', 'New Category')
@push('css')
    <style>
        .options-preview {
            padding: 15px;
            border: 1px dashed #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
    </style>
@endpush
@section('content')

    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title fs-3 fw-bold">New Category</div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Form-->
            <form id="kt_project_settings_form" method="Post" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                  action="{{route('admin.categories.store')}}" novalidate="novalidate">
                @csrf
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <div class="row mb-5">
                        <!--begin::Col-->
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Project Logo</div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                 style="background-image: url('{{ Avatar::create('N C')->toBase64() }}')">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-125px h-125px bgi-position-center"
                                     style="background-size: 75%; background-image: url('{{ Avatar::create('N C')->toBase64() }}')"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    aria-label="Change avatar" data-bs-original-title="Change avatar"
                                    data-kt-initialized="1">
                                    <i class="ki-outline ki-pencil fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg">
                                    <input type="hidden" name="avatar_remove">
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                    aria-label="Cancel avatar" data-bs-original-title="Cancel avatar"
                                    data-kt-initialized="1">
                                    <i class="ki-outline ki-cross fs-2"></i>
															</span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                    aria-label="Remove avatar" data-bs-original-title="Remove avatar"
                                    data-kt-initialized="1">
                                    <i class="ki-outline ki-cross fs-2"></i>
															</span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="row mb-8">
                        <!--begin::Col-->
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Category Name <span class="text-danger">*</span>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-xl-9 fv-row fv-plugins-icon-container">
                            <input type="text" class="form-control form-control-solid" name="name"
                                   placeholder="Enter Category Name" required>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                        </div>
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-8">
                        <!--begin::Col-->
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Category Description <span
                                    class="text-danger">*</span></div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-xl-9 fv-row fv-plugins-icon-container">
                            <textarea name="description" class="form-control form-control-solid h-100px"
                                      placeholder="Fill here Category Description" required></textarea>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                        </div>
                        <!--begin::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-8">
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
                    <!--end::Row-->

                    <!-- Commission Structures Section -->
                    <div class="separator separator-dashed my-5"></div>

                    <!--begin::Row-->
                    <div class="row mb-8">
                        <div class="col-12">
                            <h4 class="fw-bold">Commission Structures</h4>
                            <p class="text-muted">Set commission percentages for each lead type</p>
                        </div>
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Unqualified Lead (Campaign Lead)</div>
                        </div>
                        <div class="col-xl-9 fv-row fv-plugins-icon-container">
                            <div class="input-group">
                                <input type="number" class="form-control form-control-solid"
                                       name="commission[unqualified]" placeholder="Enter percentage" step="0.01" min="0"
                                       max="100">
                                <span class="input-group-text">%</span>
                            </div>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                        </div>
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Qualified Lead (Call Centre Verified)</div>
                        </div>
                        <div class="col-xl-9 fv-row fv-plugins-icon-container">
                            <div class="input-group">
                                <input type="number" class="form-control form-control-solid"
                                       name="commission[qualified]" placeholder="Enter percentage" step="0.01" min="0"
                                       max="100">
                                <span class="input-group-text">%</span>
                            </div>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                        </div>
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Converted Lead (Contract Signed)</div>
                        </div>
                        <div class="col-xl-9 fv-row fv-plugins-icon-container">
                            <div class="input-group">
                                <input type="number" class="form-control form-control-solid"
                                       name="commission[converted]" placeholder="Enter percentage" step="0.01" min="0"
                                       max="100">
                                <span class="input-group-text">%</span>
                            </div>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                        </div>
                    </div>
                    <!--end::Row-->

                    <!-- Form Questions Section -->
                    <div class="separator separator-dashed my-5"></div>

                    <!--begin::Row-->
                    <div class="row mb-8">
                        <div class="col-12">
                            <h4 class="fw-bold">Category-Specific Form Questions</h4>
                            <p class="text-muted">Define questions that will appear in forms for this category</p>
                        </div>
                    </div>
                    <!--end::Row-->

                    <!-- Questions Container -->
                    <div id="questions-container">
                        <!-- Questions will be added here dynamically -->
                    </div>

                    <!-- Add Question Button -->
                    <div class="row mb-8">
                        <div class="col-12">
                            <button type="button" class="btn btn-light-primary" id="add-question-btn">
                                <i class="ki-outline ki-plus fs-2"></i> Add Question
                            </button>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->

                <!--begin::Card footer-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                    <button type="submit" class="btn btn-primary" id="kt_project_settings_submit">Save Changes</button>
                </div>
                <!--end::Card footer-->
            </form>


            <!-- Updated Question Template (hidden) -->
            <div id="question-template" class="d-none">
                <div class="question-item card mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Question #<span class="question-number"></span></h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-icon btn-active-light-danger remove-question">
                                <i class="ki-outline ki-trash fs-1"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Question Text <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-solid question-text"
                                       name="questions[][question]" required>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Field Type <span
                                        class="text-danger">*</span></label>
                                <select class="form-select form-select-solid field-type" name="questions[][field_type]"
                                        required>
                                    <option value="text">Text Input</option>
                                    <option value="textarea">Text Area</option>
                                    <option value="select">Dropdown</option>
                                    <option value="radio">Radio Buttons</option>
                                    <option value="checkbox">Checkboxes</option>
                                    <option value="number">Number</option>
                                    <option value="email">Email</option>
                                    <option value="date">Date</option>
                                </select>
                            </div>
                        </div>

                        <!-- Options Container - Updated for better radio/checkbox handling -->
                        <div class="row mb-5 options-container d-none">
                            <div class="col-12">
                                <label class="fs-6 fw-semibold mb-2">Options (one per line) <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control form-control-solid options" name="questions[][options]"
                                          rows="3" placeholder="Enter each option on a new line"></textarea>
                                <div class="form-text">Enter each option on a new line. These will be displayed as radio
                                    buttons or checkboxes.
                                </div>

                                <!-- Preview Section -->
                                <div class="mt-3 options-preview d-none">
                                    <label class="fs-6 fw-semibold mb-2">Preview:</label>
                                    <div class="preview-content"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input is-required" type="checkbox" value="1"
                                           name="questions[][is_required]" id="is_required_template" checked>
                                    <label class="form-check-label" for="is_required_template">Required Question</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fs-6 fw-semibold mb-2">Display Order</label>
                                    <input type="number" class="form-control form-control-solid order"
                                           name="questions[][order]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end:Form-->
        </div>


    </div>

@stop

@push('js')

    <!-- JavaScript for dynamic form handling -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form elements
            const form = document.getElementById('kt_project_settings_form');
            const submitButton = document.getElementById('kt_project_settings_submit');
            const addQuestionBtn = document.getElementById('add-question-btn');
            const questionsContainer = document.getElementById('questions-container');
            const questionTemplate = document.getElementById('question-template');
            let questionCount = 0;


            // Form validation setup
            let validator = FormValidation.formValidation(
                form,
                {
                    fields: {
                        'name': {
                            validators: {
                                notEmpty: { message: 'Category name is required' }
                            }
                        },
                        'description': {
                            validators: {
                                notEmpty: { message: 'Description is required' }
                            }
                        },
                        'commission[unqualified]': {
                            validators: {
                                notEmpty: { message: 'Unqualified lead commission is required' },
                                numeric: { message: 'Must be a valid number', decimalSeparator: '.' },
                                between: { min: 0, max: 100, message: 'Must be between 0 and 100%' }
                            }
                        },
                        'commission[qualified]': {
                            validators: {
                                notEmpty: { message: 'Qualified lead commission is required' },
                                numeric: { message: 'Must be a valid number', decimalSeparator: '.' },
                                between: { min: 0, max: 100, message: 'Must be between 0 and 100%' }
                            }
                        },
                        'commission[converted]': {
                            validators: {
                                notEmpty: { message: 'Converted lead commission is required' },
                                numeric: { message: 'Must be a valid number', decimalSeparator: '.' },
                                between: { min: 0, max: 100, message: 'Must be between 0 and 100%' }
                            }
                        }
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

            // Update options preview
            function updateOptionsPreview(container, fieldType, optionsText) {
                const previewContainer = container.querySelector('.options-preview');
                const previewContent = container.querySelector('.preview-content');

                if (!optionsText.trim()) {
                    previewContainer.classList.add('d-none');
                    return;
                }

                const options = optionsText.split('\n').filter(option => option.trim() !== '');

                if (options.length === 0) {
                    previewContainer.classList.add('d-none');
                    return;
                }

                previewContent.innerHTML = '';

                if (fieldType === 'radio') {
                    options.forEach((option, index) => {
                        const div = document.createElement('div');
                        div.className = 'form-check form-check-custom form-check-solid my-2';

                        const input = document.createElement('input');
                        input.className = 'form-check-input';
                        input.type = 'radio';
                        input.name = `preview_radio_${Date.now()}`;
                        input.id = `preview_radio_${Date.now()}_${index}`;
                        input.disabled = true;

                        const label = document.createElement('label');
                        label.className = 'form-check-label';
                        label.htmlFor = input.id;
                        label.textContent = option.trim();

                        div.appendChild(input);
                        div.appendChild(label);
                        previewContent.appendChild(div);
                    });
                }
                else if (fieldType === 'checkbox') {
                    options.forEach((option, index) => {
                        const div = document.createElement('div');
                        div.className = 'form-check form-check-custom form-check-solid my-2';

                        const input = document.createElement('input');
                        input.className = 'form-check-input';
                        input.type = 'checkbox';
                        input.id = `preview_checkbox_${Date.now()}_${index}`;
                        input.disabled = true;

                        const label = document.createElement('label');
                        label.className = 'form-check-label';
                        label.htmlFor = input.id;
                        label.textContent = option.trim();

                        div.appendChild(input);
                        div.appendChild(label);
                        previewContent.appendChild(div);
                    });
                }
                else if (fieldType === 'select') {
                    const select = document.createElement('select');
                    select.className = 'form-select form-select-solid';
                    select.disabled = true;

                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = '-- Select an option --';
                    select.appendChild(defaultOption);

                    options.forEach(option => {
                        const opt = document.createElement('option');
                        opt.value = option.trim();
                        opt.textContent = option.trim();
                        select.appendChild(opt);
                    });

                    previewContent.appendChild(select);
                }

                previewContainer.classList.remove('d-none');
            }

            // Reindex questions after deletion
            function reindexQuestions() {
                const questions = document.querySelectorAll('.question-item');
                questions.forEach((questionEl, index) => {
                    // Update question number display
                    questionEl.querySelector('.question-number').textContent = index + 1;

                    // Update all input names
                    const inputs = questionEl.querySelectorAll('[name^="questions["]');
                    inputs.forEach(input => {
                        const name = input.getAttribute('name').replace(/questions\[\d+\]/, `questions[${index}]`);
                        input.setAttribute('name', name);

                        // Update IDs for labels
                        if (input.id) {
                            const newId = input.id.replace(/_(\d+)_/, `_${index}_`);
                            input.id = newId;

                            const label = questionEl.querySelector(`label[for="${input.id.replace(newId, input.id.replace(/_(\d+)_/, `_${index}_`))}"]`);
                            if (label) {
                                label.setAttribute('for', newId);
                            }
                        }
                    });
                });

                // Update the question count
                questionCount = questions.length;
            }

            // Add new question
            addQuestionBtn.addEventListener('click', function() {
                questionCount++;
                const newQuestion = questionTemplate.cloneNode(true);
                newQuestion.classList.remove('d-none');
                newQuestion.id = '';

                // Update question number
                newQuestion.querySelector('.question-number').textContent = questionCount;

                // Make field names unique
                const inputs = newQuestion.querySelectorAll('[name]');
                inputs.forEach(input => {
                    const name = input.getAttribute('name').replace('[]', `[${questionCount}]`);
                    input.setAttribute('name', name);

                    // Update IDs for labels
                    if (input.id) {
                        const newId = input.id.replace('_template', `_${questionCount}`);
                        input.id = newId;

                        const label = newQuestion.querySelector(`label[for="${input.id.replace(newId, input.id.replace('_template', '_' + questionCount))}"]`);
                        if (label) {
                            label.setAttribute('for', newId);
                        }
                    }
                });

                // Remove question functionality
                const removeBtn = newQuestion.querySelector('.remove-question');
                removeBtn.addEventListener('click', function() {
                    newQuestion.remove();
                    reindexQuestions();
                });

                // Field type change handler
                const fieldTypeSelect = newQuestion.querySelector('.field-type');
                const optionsContainer = newQuestion.querySelector('.options-container');
                const optionsTextarea = newQuestion.querySelector('.options');

                fieldTypeSelect.addEventListener('change', function() {
                    const showOptions = ['select', 'radio', 'checkbox'].includes(this.value);
                    optionsContainer.classList.toggle('d-none', !showOptions);

                    // Update preview immediately
                    if (showOptions) {
                        updateOptionsPreview(newQuestion, this.value, optionsTextarea.value);
                    } else {
                        newQuestion.querySelector('.options-preview').classList.add('d-none');
                    }
                });

                // Options textarea change handler
                optionsTextarea.addEventListener('input', function() {
                    updateOptionsPreview(newQuestion, fieldTypeSelect.value, this.value);
                });

                questionsContainer.appendChild(newQuestion);
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

                        // Handle dynamic questions - only include valid questions
                        let questions = [];
                        document.querySelectorAll('.question-item').forEach((questionEl) => {
                            const questionText = questionEl.querySelector('.question-text').value.trim();

                            // Only include questions that have text
                            if (questionText) {
                                const questionData = {
                                    question: questionText,
                                    field_type: questionEl.querySelector('.field-type').value,
                                    is_required: questionEl.querySelector('.is-required').checked ? 1 : 0,
                                    order: questionEl.querySelector('.order').value || 0
                                };

                                // Include options if field type requires it
                                const options = questionEl.querySelector('.options').value;
                                if (['select', 'radio', 'checkbox'].includes(questionData.field_type) && options.trim()) {
                                    questionData.options = options;
                                }

                                questions.push(questionData);
                            }
                        });

                        // Only add questions to form data if there are any
                        if (questions.length > 0) {
                            formData.append('questions', JSON.stringify(questions));
                        }

                        // AJAX request
                        $.ajax({
                            url: form.action || window.location.href,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            success: function(response) {
                                // Hide loading state
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;

                                if (response.success) {
                                    toastr.success(response.message || "Category saved successfully!");

                                    // Redirect if needed
                                    if (response.redirect) {
                                        setTimeout(() => {
                                            window.location.href = response.redirect;
                                        }, 1500);
                                    }
                                } else {
                                    toastr.error(response.message || "Error saving category");

                                    // Handle validation errors
                                    if (response.errors) {
                                        for (const [field, errors] of Object.entries(response.errors)) {
                                            errors.forEach(error => {
                                                toastr.error(error);
                                            });
                                        }
                                    }
                                }
                            },
                            error: function(xhr) {
                                // Hide loading state
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;

                                let errorMessage = "An error occurred while saving";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                toastr.error(errorMessage);

                                // Handle validation errors
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    for (const [field, errors] of Object.entries(xhr.responseJSON.errors)) {
                                        errors.forEach(error => {
                                            toastr.error(error);
                                        });
                                    }
                                }
                            }
                        });
                    } else {
                        toastr.error("Please correct the form errors and try again");
                    }
                });
            });
        });
    </script>

@endpush
