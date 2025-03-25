<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar pt-2 pt-lg-10">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container"
                 class="app-container container-fluid d-flex align-items-stretch">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">@yield('MainTitle')</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="@yield('title_link')"
                                   class="text-muted text-hover-primary">@yield('title')</a>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->

                            <li class="breadcrumb-item text-muted">
                                <a href="@yield('subtitle1_link')"
                                   class="text-muted text-hover-primary">@yield('subtitle1')</a>
                            </li>


                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">@yield('subtitle2')</li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    {{--                    <div class="d-flex align-items-center gap-2 gap-lg-3">--}}
                    {{--                        <a href="#"--}}
                    {{--                           class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold"--}}
                    {{--                           data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">Add Member</a>--}}
                    {{--                        <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"--}}
                    {{--                           data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">New--}}
                    {{--                            Campaign</a>--}}
                    {{--                    </div>--}}
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->

            @yield('content')
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->

    @include('admin.layouts.footer')

</div>
<!--end:::Main-->
