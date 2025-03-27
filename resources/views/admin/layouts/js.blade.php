<script>var hostUrl = "{{url('dashboard/assets/')}}";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{url('dashboard/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{url('dashboard/assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{url('dashboard/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{url('dashboard/assets/js/custom/pages/careers/apply.js')}}"></script>
<script src="{{url('dashboard/assets/js/widgets.bundle.js')}}"></script>
<script src="{{url('dashboard/assets/js/custom/widgets.js')}}"></script>
<script src="{{url('dashboard/assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{url('dashboard/assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{url('dashboard/assets/js/custom/utilities/modals/create-campaign.js')}}"></script>
<script src="{{url('dashboard/assets/js/custom/utilities/modals/users-search.js')}}"></script>
<script src="{{url('dashboard/assets/plugins/global/plugins.bundle.js')}}"></script>


    <script>
        $(document).ready(function () {
            $('#logout-btn').on('click', function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('admin.logout') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function (response) {
                        if (response.success) {
                            toastr.success('Logged out successfully!');
                            setTimeout(function () {
                                window.location.href = response.redirect; // Redirect on success
                            }, 1500);
                        }
                    },
                    error: function () {
                        toastr.error('Logout failed. Please try again.');
                    }
                });
            });
        });

    </script>

<script>
    // Delete
    $(document).on('click', '#delete', function (e) {
        e.preventDefault();
        const url = $(this).data('action');
        const reload =  $(this).data('reload');

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
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        Swal.fire({
                            text: "Deleted successfully!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function () {
                            if(reload){
                                setTimeout(function() {
                                    location.reload();
                                }, 300);
                            }
                            $('#kt_categories_table').DataTable().ajax.reload();

                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            text: "Error deleting",
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
</script>

@stack('js')


