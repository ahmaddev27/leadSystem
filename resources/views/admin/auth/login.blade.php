<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.2.0
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->
<head>
    <base href="{{url('/')}}"/>
    <title>Metronic - The World's #1 Selling Bootstrap Admin Template by Keenthemes</title>
    <meta charset="utf-8"/>
    <meta name="description"
          content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free."/>
    <meta name="keywords"
          content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    {{--    <meta property="og:locale" content="en_US" />--}}
    {{--    <meta property="og:type" content="article" />--}}
    {{--    <meta property="og:title" content="Metronic - Bootstrap Admin Template, HTML, VueJS, React, Angular. Laravel, Asp.Net Core, Ruby on Rails, Spring Boot, Blazor, Django, Express.js, Node.js, Flask Admin Dashboard Theme & Template" />--}}
    {{--    <meta property="og:url" content="https://keenthemes.com/metronic" />--}}
    {{--    <meta property="og:site_name" content="Keenthemes | Metronic" />--}}
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8"/>
    <link rel="shortcut icon" href="{{url('dashboard/assets/media/logos/favicon.ico')}}"/>
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{url('dashboard/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('dashboard/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('dashboard/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>


    <!--end::Global Stylesheets Bundle-->
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>
        body {
            background-image: url('{{ url('dashboard/assets/media/auth/bg10.jpeg') }}');
        }

        [data-bs-theme="dark"] body {
            background-image: url('{{ url('dashboard/assets/media/auth/bg10-dark.jpeg') }}');
        }
    </style>

    <!--end::Page bg image-->
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">

        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <!--begin::Wrapper-->
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">Welcome Back Admin</div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->

                            <!--end::Login options-->
                            <!--begin::Separator-->
                            <div class="separator separator-content my-14">
                                <span class="w-125px text-gray-500 fw-semibold fs-7">Sing IN</span>
                            </div>
                            <!--end::Separator-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Email" name="email" autocomplete="off"
                                       class="form-control bg-transparent"/>
                                <!--end::Email-->
                            </div>
                            <!--end::Input group=-->
                            <div class="fv-row mb-3">

                                <!--begin::Main wrapper-->
                                <div class="fv-row" data-kt-password-meter="true">
                                    <!--begin::Wrapper-->
                                    <div class="mb-1">

                                        <!--begin::Input wrapper-->
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-lg form-control-solid"
                                                   type="password" placeholder="Password" name="password"
                                                   autocomplete="off"/>

                                            <!--begin::Visibility toggle-->
                                            <span
                                                class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                <i class="ki-duotone ki-eye-slash fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                                <i class="ki-duotone ki-eye d-none fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                            <!--end::Visibility toggle-->
                                        </div>
                                        <!--end::Input wrapper-->


                                    </div>
                                    <!--end::Wrapper-->

                                </div>
                            </div>
                            <!--end::Main wrapper-->


                            <div class="fv-row mb-3 m-2">

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" name="remember"
                                           id="remember_me"/>
                                    <label class="form-check-label" for="remember_me">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>

                            </div>
                            <!--end::Input group=-->
                            <!--begin::Wrapper-->
                            {{--                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">--}}
                            {{--                                <div></div>--}}
                            {{--                                <!--begin::Link-->--}}
                            {{--                                <a href="../../demo55/dist/authentication/layouts/overlay/reset-password.html" class="link-primary">Forgot Password ?</a>--}}
                            {{--                                <!--end::Link-->--}}
                            {{--                            </div>--}}
                            <!--end::Wrapper-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Sign In</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
											<span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                            <!--begin::Sign up-->
                            {{--                            <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?--}}
                            {{--                                <a href="../../demo55/dist/authentication/layouts/overlay/sign-up.html" class="link-primary">Sign up</a></div>--}}
                            {{--                            <!--end::Sign up-->--}}
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->

                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "{{url('dashboard/assets/')}}";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{url('dashboard/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{url('dashboard/assets/js/scripts.bundle.js')}}"></script>

<!--end::Global Javascript Bundle-->
<!--end::Javascript-->
<script>
    $(document).ready(function () {
        $('#kt_sign_in_form').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            let form = $(this);
            let submitButton = $('#kt_sign_in_submit');
            let formData = form.serialize(); // Serialize form data

            // Show loading indicator
            submitButton.prop('disabled', true);
            submitButton.find('.indicator-label').hide();
            submitButton.find('.indicator-progress').show();

            $.ajax({
                url: "{{ route('admin.login') }}", // Laravel login route
                type: "POST",
                data: formData,
                success: function (response) {
                    if (response.success) {
                        toastr.success('Login successful! Redirecting...');
                        setTimeout(function () {
                            window.location.href = response.redirect; // Redirect on success
                        }, 1500);

                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr) {
                    let errorMessage = 'An error occurred. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    toastr.error(errorMessage);
                },
                complete: function () {
                    // Re-enable button and hide loading indicator
                    submitButton.prop('disabled', false);
                    submitButton.find('.indicator-label').show();
                    submitButton.find('.indicator-progress').hide();
                }
            });
        });
    });
</script>
</body>
<!--end::Body-->
</html>

