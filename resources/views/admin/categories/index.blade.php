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
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_categories_table .form-check-input" value="1" />
                                    </div>
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


@stop

@push('js')
    <link href="{{url('dashboard/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{url('dashboard/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

    <script>
        $(document).ready(function() {
            // Datatable initialization
            const table = $('#kt_categories_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.categories.list') }}",
                    type: "GET"
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'products_count', name: 'products_count', className: 'text-end' },
                    { data: 'status', name: 'is_active', className: 'text-end' },
                    { data: 'created_at', name: 'created_at', className: 'text-end' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end' }
                ],
                columnDefs: [
                    { targets: [0, 1, 6], width: '50px' },
                    { targets: 3, width: '100px' },
                    { targets: 4, width: '100px' },
                    { targets: 5, width: '150px' }
                ],
                order: [[2, 'asc']],
                dom:
                    "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +
                    "<'table-responsive'tr>" +
                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });

            // Delete category
            $(document).on('click', '.delete-category', function(e) {
                e.preventDefault();
                const id = $(this).data('id');

                Swal.fire({
                    text: "Are you sure you want to delete this category?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: "{{ url('admin/categories') }}/" + id,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    text: "Category deleted successfully!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function() {
                                    table.ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    text: "Error deleting category",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
