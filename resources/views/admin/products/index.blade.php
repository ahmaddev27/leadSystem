@extends('admin.layouts.master')
@section('MainTitle', 'Product Categories Management')
@section('title', 'Leads System')
@section('title_link', route('admin.dashboard'))
@section('subtitle1', 'Categories')
@section('subtitle1_link', route('admin.categories.index'))
@section('subtitle2', 'All Categories')
@section('content')

    <div id="kt_app_content_container" class="app-container container-fluid">

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Products-->
                <div class="card ">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Categories</h2>
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <!--begin::Add customer-->
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                    <i class="ki-outline ki-plus fs-2"></i>Add Category
                                </a>
                                <!--end::Add customer-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_categories_table">
                            <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
{{--                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">--}}
{{--                                        <input class="form-check-input" type="checkbox" data-kt-check="true"--}}
{{--                                               data-kt-check-target="#kt_categories_table .form-check-input" value="1"/>--}}
{{--                                    </div>--}}
                                </th>
                                <th class="min-w-100px">Image</th>
                                <th class="min-w-200px">Name</th>
                                <th class="text-end min-w-100px">Products</th>
                                <th class="text-end min-w-100px">Status</th>
                                <th class="text-end min-w-100px">Created At</th>
                                <th class="text-end min-w-70px">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Products-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>


    <!--begin::Modal - Questions-->
    <!--begin::Modal - Category Details-->
    <div class="modal fade" id="kt_modal_category_details" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <h2 class="fw-bold" id="category-modal-title">Category Name</h2>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->




                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Tabs-->
                    <div class="float-end m-3" data-kt-customer-table-toolbar="base">
                        <!--begin::Add customer-->
                        <a id="edit_category_id" href="#"
                           class="btn-sm btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary">
                            <i class="bi bi-pencil-square">

                            </i></a>
                        <!--end::Add customer-->
                    </div>

                    <p id="category_details"></p>
                        <div class="symbol symbol-70px m-3  float-end">
                        <span id="category_image" class="symbol-label" style=""></span>
                    </div>

                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6" id="category-details-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_questions">Questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_commissions">Commission
                                Structures</a>
                        </li>
                    </ul>
                    <!--end::Tabs-->

                    <!--begin::Tab content-->
                    <div class="tab-content" id="category-details-content">
                        <!--begin::Tab panel-->
                        <div class="tab-pane fade show active" id="kt_tab_questions" role="tabpanel">
                            <div id="questions-content">
                                <div class="text-center py-10">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Tab panel-->

                        <!--begin::Tab panel-->
                        <div class="tab-pane fade" id="kt_tab_commissions" role="tabpanel">
                            <div id="commissions-content">
                                <div class="text-center py-10">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Tab panel-->
                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Modal body-->
            </div>
        </div>
    </div>
    <!--end::Modal - Category Details-->    <!--end::Modal - Questions-->

@stop

@push('js')
    <link href="{{url('dashboard/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
    <script src="{{url('dashboard/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>



    {{--Datatable adn detatils--}}
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            const table = $('#kt_categories_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.categories.list') }}",
                    type: "GET"
                },
                columns: [
                    // {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'image', name: 'image', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'products_count', name: 'products_count', className: 'text-end'},
                    {data: 'status', name: 'is_active', className: 'text-end'},
                    {data: 'created_at', name: 'created_at', className: 'text-end'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end'}
                ],
                // columnDefs: [
                //     {targets: [0, 1, 6], width: '50px'},
                //     {targets: 2, width: '100px'},
                //     {targets: , width: '100px'},
                //     {targets: 5, width: '150px'}
                // ],
                order: [[4, 'asc']],
                drawCallback: function () {
                    // Reinitialize dropdown menus after table reload
                    KTMenu.createInstances();
                }
            });


            // Handle click on "View Questions"

            $(document).on('click', '.view-questions', function (e) {
                e.preventDefault();
                const categoryId = $(this).data('id');
                const modal = $('#kt_modal_category_details');

                // Reset tabs to questions tab
                $('#category-details-tabs .nav-link').removeClass('active');
                $('#category-details-tabs .nav-link:first').addClass('active');
                $('.tab-pane').removeClass('show active');
                $('#kt_tab_questions').addClass('show active');

                // Set category name in title
                const categoryName = $(this).closest('tr').find('td:nth-child(3)').text().trim();
                $('#category-modal-title').text('Details: ' + categoryName);

                // Show loading states
                $('#questions-content').html(`
        <div class="text-center py-10">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);

                $('#commissions-content').html(`
        <div class="text-center py-10">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);

                const baseEditUrl = "{{ route('admin.categories.edit', ['category' => 'CATEGORY_ID']) }}";

                // Show modal
                modal.modal('show');

                // Load data via AJAX
                $.ajax({
                    url: "{{ route('admin.categories.details', '') }}/" + categoryId,
                    type: "GET",
                    success: function (response) {
                        $('#edit_category_id').attr('href', baseEditUrl.replace('CATEGORY_ID', categoryId));
                        $('#category_details').html(response.category.description);
                        $('#category_image').css('background-image', 'url(' + response.category.image + ')');
                        // Render Questions
                        if (response.questions && response.questions.length > 0) {
                            let html = '<div class="table-responsive">';
                            html += '<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">';
                            html += '<thead><tr><th>#</th><th>Question</th><th>Type</th><th>Required</th><th>Options</th></tr></thead>';
                            html += '<tbody>';

                            response.questions.forEach(function (question, index) {
                                html += '<tr>';
                                html += '<td>' + (index + 1) + '</td>';
                                html += '<td>' + question.question + '</td>';
                                html += '<td><span class="badge badge-light-primary">' + question.field_type + '</span></td>';
                                html += '<td>' + (question.is_required ? '<span class="badge badge-light-success">Yes</span>' : '<span class="badge badge-light-danger">No</span>') + '</td>';
                                html += '<td>' + (question.options ? question.options : 'N/A') + '</td>';
                                html += '</tr>';
                            });

                            html += '</tbody></table></div>';
                            $('#questions-content').html(html);
                        } else {
                            $('#questions-content').html('<div class="text-center py-10"><p>No questions found for this category.</p></div>');
                        }

                        // Render Commissions
                        if (response.commissions) {
                            let html = '<div class="table-responsive">';
                            html += '<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">';
                            html += '<thead><tr><th>Lead Type</th><th>Commission Percentage</th></tr></thead>';
                            html += '<tbody>';

                            const commissionTypes = {
                                'unqualified': 'Unqualified Lead (Campaign Lead)',
                                'qualified': 'Qualified Lead (Call Centre Verified)',
                                'converted': 'Converted Lead (Contract Signed)'
                            };

                            for (const [type, percentage] of Object.entries(response.commissions)) {
                                if (commissionTypes[type]) {
                                    html += '<tr>';
                                    html += '<td>' + commissionTypes[type] + '</td>';
                                    html += '<td>' + percentage + '%</td>';
                                    html += '</tr>';
                                }
                            }

                            html += '</tbody></table></div>';
                            $('#commissions-content').html(html);
                        } else {
                            $('#commissions-content').html('<div class="text-center py-10"><p>No commission structure defined for this category.</p></div>');
                        }
                    },
                    error: function () {
                        $('#questions-content').html('<div class="text-center py-10"><p>Error loading category details.</p></div>');
                        $('#commissions-content').html('<div class="text-center py-10"><p>Error loading commission details.</p></div>');
                    }
                });
            });

            // Ensure action buttons work even after AJAX reload
            $('#kt_categories_table').on('draw.dt', function () {
                KTMenu.createInstances();
            });
        });

    </script>
@endpush
