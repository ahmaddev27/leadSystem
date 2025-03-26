@extends('admin.layouts.master')
@section('MainTitle', 'Product Categories Management')
@section('title', 'Leads System')
@section('title_link', route('admin.dashboard'))
@section('subtitle1', 'Categories')
@section('subtitle1_link', route('admin.categories.index'))
@section('subtitle2', 'Update Category')
@push('css')
    <!-- Font Awesome for icons -->


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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Category</h3>
        </div>

        <form id="kt_project_settings_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
              action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" novalidate="novalidate">
            @csrf
            @method('PUT')
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
                             style="background-image: url('{{ $category->image? $category->getImae(): Avatar::create($category->name)->toBase64() }}')">
                            <!--begin::Preview existing avatar-->
                            <div class="image-input-wrapper w-125px h-125px bgi-position-center"
                                 style="background-size: 75%; background-image: url('{{ $category->image ? $category->getImae(): Avatar::create($category->name)->toBase64() }}')"></div>
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
                               placeholder="Enter Category Name" value="{{ old('name', $category->name) }}" required>
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
                          placeholder="Fill here Category Description" required>{{ old('description', $category->description) }}</textarea>
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
                                   name="is_active" {{ old('is_active', $category->is_active) ? 'checked="checked"' : '' }}>
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
                                   max="100" value="{{ old('commission.unqualified', $commissions['unqualified'] ?? '') }}">
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
                                   max="100" value="{{ old('commission.qualified', $commissions['qualified'] ?? '') }}">
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
                                   max="100" value="{{ old('commission.converted', $commissions['converted'] ?? '') }}">
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
                    @foreach($initialQuestions as $index => $question)
                        <div class="question-item mb-8 p-4 border rounded">
                            <div class="row mb-5">
                                <div class="col-xl-3">
                                    <label class="fs-6 fw-semibold mt-2 mb-3">Question</label>
                                </div>
                                <div class="col-xl-9">
                                    <input type="text" class="form-control form-control-solid"
                                           name="questions[{{ $index }}][question]"
                                           value="{{ old("questions.$index.question", $question['question']) }}"
                                           placeholder="Enter question text" required>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-xl-3">
                                    <label class="fs-6 fw-semibold mt-2 mb-3">Field Type</label>
                                </div>
                                <div class="col-xl-9">
                                    <select class="form-select form-select-solid"
                                            name="questions[{{ $index }}][field_type]" required>
                                        <option value="text" {{ old("questions.$index.field_type", $question['field_type']) == 'text' ? 'selected' : '' }}>Text</option>
                                        <option value="textarea" {{ old("questions.$index.field_type", $question['field_type']) == 'textarea' ? 'selected' : '' }}>Text Area</option>
                                        <option value="select" {{ old("questions.$index.field_type", $question['field_type']) == 'select' ? 'selected' : '' }}>Dropdown</option>
                                        <option value="radio" {{ old("questions.$index.field_type", $question['field_type']) == 'radio' ? 'selected' : '' }}>Radio Buttons</option>
                                        <option value="checkbox" {{ old("questions.$index.field_type", $question['field_type']) == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                        <option value="email" {{ old("questions.$index.field_type", $question['field_type']) == 'email' ? 'selected' : '' }}>Email</option>
                                        <option value="number" {{ old("questions.$index.field_type", $question['field_type']) == 'number' ? 'selected' : '' }}>Number</option>
                                        <option value="date" {{ old("questions.$index.field_type", $question['field_type']) == 'date' ? 'selected' : '' }}>Date</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-5 options-field" style="{{ !in_array($question['field_type'], ['select', 'radio', 'checkbox']) ? 'display:none;' : '' }}">
                                <div class="col-xl-3">
                                    <label class="fs-6 fw-semibold mt-2 mb-3">Options (comma separated)</label>
                                </div>
                                <div class="col-xl-9">
                                    <input type="text" class="form-control form-control-solid"
                                           name="questions[{{ $index }}][options]"
                                           value="{{ old("questions.$index.options", is_array($question['options']) ? implode(',', $question['options']) : $question['options']) }}"
                                           placeholder="Option 1, Option 2, Option 3">
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-xl-3">
                                    <label class="fs-6 fw-semibold mt-2 mb-3">Placeholder</label>
                                </div>
                                <div class="col-xl-9">
                                    <input type="text" class="form-control form-control-solid"
                                           name="questions[{{ $index }}][placeholder]"
                                           value="{{ old("questions.$index.placeholder", $question['placeholder']) }}"
                                           placeholder="Enter placeholder text">
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-xl-3">
                                    <label class="fs-6 fw-semibold mt-2 mb-3">Required</label>
                                </div>
                                <div class="col-xl-9">
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox"
                                               name="questions[{{ $index }}][is_required]"
                                               value="1" {{ old("questions.$index.is_required", $question['is_required']) ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-xl-3">
                                    <label class="fs-6 fw-semibold mt-2 mb-3">Order</label>
                                </div>
                                <div class="col-xl-9">
                                    <input type="number" class="form-control form-control-solid"
                                           name="questions[{{ $index }}][order]"
                                           value="{{ old("questions.$index.order", $question['order']) }}"
                                           placeholder="Enter display order">
                                </div>
                            </div>

                            <button type="button" class="btn btn-sm btn-danger remove-question">Remove Question</button>
                        </div>
                    @endforeach
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
                <button type="submit" class="btn btn-primary" id="kt_project_settings_submit">Save Changes</button>
            </div>
            <!--end::Card footer-->
        </form>
    </div>

    <!--  Question Template (hidden) -->
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
                    <div class="col-md-4 fv-row">
                        <label class="fs-6 fw-semibold mb-2">Question Text <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-solid question-text"
                               name="questions[][question]" required>
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="fs-6 fw-semibold mb-2">Field Type <span class="text-danger">*</span></label>
                        <select class="form-select form-select-solid field-type" name="questions[][field_type]"
                                required>
                            <option selected disabled value="">Select Question Type</option>
                            <option value="text">Text Input</option>
                            <option value="textarea">Text Area</option>
                            <option value="select">Dropdown</option>
                            <option value="radio">Radio Buttons</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="number">Number</option>
                            <option value="email">Email</option>
                            <option value="date">Date</option>
                        </select>
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="fs-6 fw-semibold mb-2">Icon Image</label>
                        <div class="input-group">
                            <input type="file" class="form-control form-control-solid question-icon-input"
                                   name="questions[][icon]" accept="image/*">
                            <button type="button" class="btn btn-light-danger remove-icon-btn d-none">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>
                        <div class="icon-preview mt-2 d-none"></div>
                    </div>
                </div>

                <!-- Placeholder Field -->
                <div class="row mb-5 placeholder-container d-none">
                    <div class="col-12 fv-row">
                        <label class="fs-6 fw-semibold mb-2">Placeholder Text</label>
                        <input type="text" class="form-control form-control-solid question-placeholder"
                               name="questions[][placeholder]" placeholder="Enter placeholder text">
                    </div>
                </div>

                <!-- Options Field -->
                <div class="row mb-5 options-container d-none">
                    <div class="col-12">
                        <label class="fs-6 fw-semibold mb-2">Options (one per line) <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control form-control-solid options" name="questions[][options]"
                                  rows="3"></textarea>
                        <div class="form-text">Enter each option on a new line</div>
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
                            <input type="number" class="form-control form-control-solid order" name="questions[][order]"
                                   value="0" min="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Pass initial questions to JavaScript
        window.initialQuestions = @json($initialQuestions);
    </script>

    <!-- Include your JavaScript file -->
    <script src="{{ asset('js/product-category-form.js') }}"></script>
@endsection

@push('js')
    <script>
        // This script should handle adding new questions dynamically
        document.addEventListener('DOMContentLoaded', function() {
            const questionsContainer = document.getElementById('questions-container');
            const addQuestionBtn = document.getElementById('add-question-btn');
            let questionIndex = {{ count($initialQuestions) }};

            // Function to add a new question
            function addQuestion() {
                const template = `
                <div class="question-item mb-8 p-4 border rounded">
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label class="fs-6 fw-semibold mt-2 mb-3">Question</label>
                        </div>
                        <div class="col-xl-9">
                            <input type="text" class="form-control form-control-solid"
                                   name="questions[${questionIndex}][question]"
                                   placeholder="Enter question text" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label class="fs-6 fw-semibold mt-2 mb-3">Field Type</label>
                        </div>
                        <div class="col-xl-9">
                            <select class="form-select form-select-solid"
                                    name="questions[${questionIndex}][field_type]" required>
                                <option value="text">Text</option>
                                <option value="textarea">Text Area</option>
                                <option value="select">Dropdown</option>
                                <option value="radio">Radio Buttons</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="email">Email</option>
                                <option value="number">Number</option>
                                <option value="date">Date</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-5 options-field" style="display:none;">
                        <div class="col-xl-3">
                            <label class="fs-6 fw-semibold mt-2 mb-3">Options (comma separated)</label>
                        </div>
                        <div class="col-xl-9">
                            <input type="text" class="form-control form-control-solid"
                                   name="questions[${questionIndex}][options]"
                                   placeholder="Option 1, Option 2, Option 3">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label class="fs-6 fw-semibold mt-2 mb-3">Placeholder</label>
                        </div>
                        <div class="col-xl-9">
                            <input type="text" class="form-control form-control-solid"
                                   name="questions[${questionIndex}][placeholder]"
                                   placeholder="Enter placeholder text">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label class="fs-6 fw-semibold mt-2 mb-3">Required</label>
                        </div>
                        <div class="col-xl-9">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox"
                                       name="questions[${questionIndex}][is_required]" value="1" checked>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label class="fs-6 fw-semibold mt-2 mb-3">Order</label>
                        </div>
                        <div class="col-xl-9">
                            <input type="number" class="form-control form-control-solid"
                                   name="questions[${questionIndex}][order]"
                                   value="${questionIndex + 1}"
                                   placeholder="Enter display order">
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-danger remove-question">Remove Question</button>
                </div>
            `;

                questionsContainer.insertAdjacentHTML('beforeend', template);
                questionIndex++;

                // Add event listener for field type change to show/hide options field
                const lastQuestion = questionsContainer.lastElementChild;
                const fieldTypeSelect = lastQuestion.querySelector('select[name$="[field_type]"]');
                const optionsField = lastQuestion.querySelector('.options-field');

                fieldTypeSelect.addEventListener('change', function() {
                    if (['select', 'radio', 'checkbox'].includes(this.value)) {
                        optionsField.style.display = 'flex';
                    } else {
                        optionsField.style.display = 'none';
                    }
                });
            }

            // Add event listener for existing field type changes
            document.querySelectorAll('.question-item').forEach(item => {
                const fieldTypeSelect = item.querySelector('select[name$="[field_type]"]');
                const optionsField = item.querySelector('.options-field');

                if (fieldTypeSelect && optionsField) {
                    fieldTypeSelect.addEventListener('change', function() {
                        if (['select', 'radio', 'checkbox'].includes(this.value)) {
                            optionsField.style.display = 'flex';
                        } else {
                            optionsField.style.display = 'none';
                        }
                    });
                }
            });

            // Add event listener for remove question buttons
            questionsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-question')) {
                    e.target.closest('.question-item').remove();
                }
            });

            // Add event listener for add question button
            addQuestionBtn.addEventListener('click', addQuestion);
        });
    </script>
    <!-- JavaScript for dynamic form handling -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                                notEmpty: {message: 'Category name is required'}
                            }
                        },
                        'description': {
                            validators: {
                                notEmpty: {message: 'Description is required'}
                            }
                        },
                        'commission[unqualified]': {
                            validators: {
                                notEmpty: {message: 'Unqualified lead commission is required'},
                                numeric: {message: 'Must be a valid number', decimalSeparator: '.'},
                                between: {min: 0, max: 100, message: 'Must be between 0 and 100%'}
                            }
                        },
                        'commission[qualified]': {
                            validators: {
                                notEmpty: {message: 'Qualified lead commission is required'},
                                numeric: {message: 'Must be a valid number', decimalSeparator: '.'},
                                between: {min: 0, max: 100, message: 'Must be between 0 and 100%'}
                            }
                        },
                        'commission[converted]': {
                            validators: {
                                notEmpty: {message: 'Converted lead commission is required'},
                                numeric: {message: 'Must be a valid number', decimalSeparator: '.'},
                                between: {min: 0, max: 100, message: 'Must be between 0 and 100%'}
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
                } else if (fieldType === 'checkbox') {
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
                } else if (fieldType === 'select') {
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

            // Add new question with icon and placeholder support
            addQuestionBtn.addEventListener('click', function () {
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

                // Image upload for icon
                const iconInput = newQuestion.querySelector('.question-icon-input');
                const iconPreview = newQuestion.querySelector('.icon-preview');
                const iconRemoveBtn = newQuestion.querySelector('.remove-icon-btn');

                // Handle icon image selection
                iconInput.addEventListener('change', function (e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            iconPreview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">`;
                            iconPreview.classList.remove('d-none');
                            iconRemoveBtn.classList.remove('d-none');
                        }

                        reader.readAsDataURL(this.files[0]);
                    }
                });

                // Handle icon removal
                iconRemoveBtn.addEventListener('click', function () {
                    iconInput.value = '';
                    iconPreview.innerHTML = '';
                    iconPreview.classList.add('d-none');
                    this.classList.add('d-none');
                });

                // Remove question functionality
                const removeBtn = newQuestion.querySelector('.remove-question');
                removeBtn.addEventListener('click', function () {
                    newQuestion.remove();
                    reindexQuestions();
                });

                // Field type change handler
                const fieldTypeSelect = newQuestion.querySelector('.field-type');
                const optionsContainer = newQuestion.querySelector('.options-container');
                const placeholderContainer = newQuestion.querySelector('.placeholder-container');

                fieldTypeSelect.addEventListener('change', function () {
                    const showOptions = ['select', 'radio', 'checkbox'].includes(this.value);
                    const showPlaceholder = ['text', 'textarea', 'email', 'number', 'date'].includes(this.value);

                    optionsContainer.classList.toggle('d-none', !showOptions);
                    placeholderContainer.classList.toggle('d-none', !showPlaceholder);
                });

                questionsContainer.appendChild(newQuestion);
            });


            // Form submission handler
            // Form submission handler
            submitButton.addEventListener('click', function (e) {
                e.preventDefault();

                validator.validate().then(function (status) {
                    if (status === 'Valid') {
                        // Show loading state
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        // Prepare form data
                        let formData = new FormData(form);

                        // Handle dynamic questions
                        let questionIndex = 0;
                        document.querySelectorAll('.question-item').forEach((questionEl) => {
                            const questionText = questionEl.querySelector('.question-text')?.value.trim();

                            if (questionText) {
                                // Add question data to formData
                                formData.append(`questions[${questionIndex}][question]`, questionText);
                                formData.append(`questions[${questionIndex}][field_type]`, questionEl.querySelector('.field-type')?.value);
                                formData.append(`questions[${questionIndex}][is_required]`, questionEl.querySelector('.is-required')?.checked ? 1 : 0);
                                formData.append(`questions[${questionIndex}][order]`, questionEl.querySelector('.order')?.value || 0);

                                const placeholder = questionEl.querySelector('.question-placeholder')?.value;
                                if (placeholder) {
                                    formData.append(`questions[${questionIndex}][placeholder]`, placeholder);
                                }

                                // Handle options
                                const options = questionEl.querySelector('.options')?.value;
                                if (options?.trim()) {
                                    formData.append(`questions[${questionIndex}][options]`, options);
                                }

                                // Handle icon file
                                const iconInput = questionEl.querySelector('.question-icon-input');
                                if (iconInput?.files[0]) {
                                    formData.append(`questions[${questionIndex}][icon]`, iconInput.files[0]);
                                }

                                questionIndex++;
                            }
                        });

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
                            success: function (response) {
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
                            error: function (xhr) {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;

                                const errorMessage = xhr.responseJSON?.message || "Request failed";
                                toastr.error(errorMessage);

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
