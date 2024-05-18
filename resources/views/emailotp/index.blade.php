<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Login Basic - Pages | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <!--? Config:  test commit.  -->
    <script src="../assets/js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card mb-4">
              <h5 class="card-header">Email OTP</h5>
                <div class="card-body">
                  <div id="defaultFormControlHelp" class="form-text mb-3 ">
                    We've sent an OTP to your email <strong>({{ $email }})</strong>. Please enter the OTP to verify your email.
                    Please check the spam folder if you don't find the email in your inbox.
                  </div>
                  <label for="defaultFormControlInput" class="form-label">OTP (One Time Password)</label>
                  <input type="text" class="form-control mb-3" id="email_otp" placeholder="" aria-describedby="defaultFormControlHelp">
                  <button class="btn btn-primary" id="submit_otp_button">Submit</button>
                </div>
            </div>
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
      $.ajaxSetup({
          headers: {  'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }
      });
      $(document).ready(function () {
        $("#submit_otp_button").click(function () {
          var email_otp = $("#email_otp").val();
          var email = "{{ $email }}";
          $.ajax({
              url: `{{ route('emailOtpVerify') }}`,
              method: 'POST',
              data: {
                email: email,
                otp: email_otp
              },
              beforeSend: function(){
                  $('#btnLogin').html("REDIRECTING...").prop("disabled", true);
              },
              success:function(response){
                console.log(response);
                if(response.status == 200) {
                    Swal.fire({
                      title: 'Success!',
                      text: `${response.message}`,
                      icon: 'success',
                      confirmButtonText: 'OK'
                    }).then((result) => {
                      window.location.href ="/home";
                    });
                }
                if (response.status == 500) {
                  Swal.fire({
                      title: 'Error!',
                      text: `${response.message}`,
                      icon: 'error',
                      confirmButtonText: 'OK'
                  });
                }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 429) {
                  Swal.fire({
                    icon: 'error',
                    title: 'Too Many Requests',
                    text: 'You have exceeded the rate limit. Please wait a moment and try again.',
                    confirmButtonText: 'Okay'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/";
                    }
                  });
                } else {
                    // handle other errors
                }
              }
          });
        });
      });
    </script>
  </body>
</html>
