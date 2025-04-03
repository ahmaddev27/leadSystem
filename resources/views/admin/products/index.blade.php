@extends('admin.layouts.master', ['tab_title'=>'Products'])
@section('MainTitle', 'Product  Management')
@section('title', 'Leads System')
@section('title_link', route('admin.dashboard'))
@section('subtitle1', 'Products')
@section('subtitle1_link', route('admin.products.index'))
@section('subtitle2', 'All Products')
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
                            <h2>Products</h2>
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <!--begin::Add customer-->
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                    <i class="ki-outline ki-plus fs-2"></i>Add Product
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
{{--                                <th class="w-10px pe-2">--}}
{{--                                    --}}{{--                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">--}}
{{--                                    --}}{{--                                        <input class="form-check-input" type="checkbox" data-kt-check="true"--}}
{{--                                    --}}{{--                                               data-kt-check-target="#kt_categories_table .form-check-input" value="1"/>--}}
{{--                                    --}}{{--                                    </div>--}}
{{--                                </th>--}}
                                <th class="min-w-100px">Image</th>
                                <th class="min-w-200px">Name</th>
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


    <!-- Product Details Modal -->
    <div class="modal fade" id="productDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-5">
                                <img id="productMainImage" src="" class="img-fluid rounded" style="max-height: 300px;">
                            </div>
                            <div class="row" id="productGallery"></div>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th width="30%">Name</th>
                                    <td id="productName"></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td id="productDescription"></td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td id="productPrice"></td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td id="productCategory"></td>
                                </tr>
                                <tr>
                                    <th>Tags</th>
                                    <td id="productTags"></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td id="productStatus"></td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td id="productCreatedAt"></td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td id="productUpdatedAt"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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
                    url: "{{ route('admin.products.list') }}",
                    type: "GET"
                },
                columns: [
                    // {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'image', name: 'image', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'is_active', className: 'text-end'},
                    {data: 'created_at', name: 'created_at', className: 'text-end'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end'}
                ],
                // columnDefs: [
                //     {targets: [0, 1, 6], width: '50px'},
                //     {targets: 2, width: '100px'},
                //     {targets:2 , width: '100px'},
                //     {targets: 5, width: '150px'}
                // ],
                order: [[4, 'asc']],
                drawCallback: function () {
                    // Reinitialize dropdown menus after table reload
                    KTMenu.createInstances();
                }
            });


            // Handle click on "View Questions"

            $(document).ready(function() {
                // Initialize DataTable if you haven't already
                $('#productsTable').DataTable();

                // Handle view details click
                $(document).on('click', '.view-details', function(e) {
                    e.preventDefault();
                    const productId = $(this).data('id');
                    const modal = $('#productDetailsModal');

                    // Show loading state
                    modal.modal('show');
                    modal.find('.modal-body').html(`
        <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);

                    $.ajax({
                        url: `/admin/products/details/${productId}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log('Response received:', response);

                            if (response.success && response.data) {
                                const product = response.data;
                                let html = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4 text-center">
                                <img src="${product.main_image_url}"
                                     class="img-fluid rounded border"
                                     style="max-height: 300px; width: auto;">
                            </div>
                            <div class="row g-2" id="productGallery">
                `;

                                // Add gallery images
                                if (product.images && product.images.length > 0) {
                                    product.images.forEach(img => {
                                        html += `
                            <div class="col-4">
                                <img src="${img.image_url}"
                                     class="img-thumbnail"
                                     style="height: 100px; width: 100%; object-fit: cover;">
                            </div>
                   `;
                                    });
                                } else {
                                    html += `<div class="col-12 text-muted">No additional images</div>`;
                                }

                                html += `
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr><th>Name</th><td>${product.name}</td></tr>
                                    <tr><th>Price</th><td>$${product.price}</td></tr>
                                    <tr><th>Category</th><td>${product.category}</td></tr>
                                    <tr><th>Tags</th><td>${product.tags}</td></tr>
                                    <tr><th>Status</th><td>
                                        <span class="badge ${product.is_active ? 'bg-success' : 'bg-danger'}">
                                            ${product.is_active ? 'Active' : 'Inactive'}
                                        </span>
                                    </td></tr>
                                    <tr><th>Created</th><td>${product.created_at}</td></tr>
                                    <tr><th>Updated</th><td>${product.updated_at}</td></tr>
                                </tbody>
                            </table>

                            <!-- Description Section Below Table -->
                            <div class="mt-4">
                                <h5>Description</h5>
                                <div class="border p-3 rounded bg-light">
                                    ${product.description || '<span class="text-muted">No description provided</span>'}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                                modal.find('.modal-body').html(html);
                            } else {
                                modal.find('.modal-body').html(`
                    <div class="alert alert-danger">
                        ${response.message || 'Failed to load product details'}
                    </div>
                `);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                            modal.find('.modal-body').html(`
                <div class="alert alert-danger">
                    Error loading product details. Please try again.
                    <div class="small text-muted mt-1">${error}</div>
                </div>
            `);
                        }
                    });
                });
                // Helper functions
                function formatCurrency(amount) {
                    return '$' + parseFloat(amount).toFixed(2);
                }

                function formatDate(dateString) {
                    return new Date(dateString).toLocaleString();
                }
            });
            // Ensure action buttons work even after AJAX reload
            $('#kt_categories_table').on('draw.dt', function () {
                KTMenu.createInstances();
            });
        });

    </script>
@endpush
