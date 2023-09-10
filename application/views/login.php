<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="pixelstrap">
  <link rel="icon" href="<?= base_url() ?>assets/img/kab_bangka.png" type="image/x-icon">
  <link rel="shortcut icon" href="<?= base_url() ?>assets/img/kab_bangka.png" type="image/x-icon">
  <title>DINKES KAB.BANGKA | Login</title>
  <!-- Google font-->
  <!-- <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/font-awesome.css">
  <!-- ico-font-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/icofont.css">
  <!-- Themify icon-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/themify.css">
  <!-- Flag icon-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/flag-icon.css">
  <!-- Feather icon-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/feather-icon.css">
  <!-- Plugins css start-->
  <!-- Plugins css Ends-->
  <!-- Bootstrap css-->
  <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/sweetalert2.css"> -->

  <!-- <script src="<?= base_url() ?>sweetalert2/dist"></script> -->
  <!-- <script src="<?= base_url() ?>sweetalert2/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<?= base_url() ?>sweetalert2/dist/sweetalert2.min.css"> -->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/bootstrap.css">
  <!-- App css-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style.css?v=1.3">
  <link id="color" rel="stylesheet" href="<?= base_url() ?>assets/css/color-1.css" media="screen">
  <!-- Responsive css-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/responsive.css?v=1.2">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <!-- login page start-->
  <div class="container-fluid p-0">
    <div class="row m-0">
      <div class="col-12 p-0">
        <div class="login-card">
          <div>
            <div>
              <div class="row">

                <div class="col-lg-2">
                  <a class="logo" href="">

                    <img style="max-width: 100%; !important" class="img-fluid for-light" src="<?= base_url() ?>assets/img/kab_bangka.png" alt="looginpage">
                    <img style="max-width: 40%;" class="img-fluid for-dark" src="<?= base_url() ?>assets/img/kab_bangka.png" alt="looginpage">
                  </a>
                </div>
                <div class="col-lg-10">
                  <center>
                    <h4 style="margin-bottom : 0 ; margin-top: 1rem">SISTEM INFORMASI ADMINISTRASI DAN UMUM</h4>
                    <h2 style="margin-bottom : 0">DINAS KESEHATAN</h2>
                    <h2 style="margin-bottom : 0">KABUPATEN BANGKA</h2>
                  </center>

                </div>
              </div>
            </div>
            <div class="login-main" style="">
              <form class="theme-form" id="loginForm">
                <!-- <h7>Masukkan username & password untuk login</h7> -->
                <div class="form-group">
                  <label class="col-form-label">Username</label>
                  <input style="background-color: white !important" class="form-control" type="text" required="required" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                  <label class="col-form-label">Password</label>
                  <div class="form-input position-relative">
                    <input style="background-color: white !important" class="form-control" type="password" name="password" id="password" required="required" placeholder="*********">
                    <div class="show-hide"><span class="show"> </span></div>
                  </div>
                </div>
                <div class="form-group mb-0">
                  <div class="checkbox p-0">
                    <input id="checkbox1" type="checkbox">
                  </div><a class="link" href="forget-password.html">Lupa password?</a>
                  <div class="text-end mt-3">
                    <button style="background-color: white !important" class="btn btn-light w-100" type="submit">MASUK</button>
                  </div>
                  <!-- </div>
                <h6 class="text-muted mt-4 or">Or Sign in with</h6>
                <div class="social mt-4">
                  <div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn </a><a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i class="txt-fb" data-feather="facebook"></i>facebook</a></div>
                </div>
                <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2" href="sign-up.html">Create Account</a></p> -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?= base_url() ?>assets/js/jquery-3.5.1.min.js"></script>
    <script>
      $(document).ready(function() {
        cur_sh = 'hide';
        $('.show-hide').on('click', function() {
          if (cur_sh == 'hide') {
            console.log('go show')
            cur_sh = 'show';
            $('#password').prop('type', 'text')
          } else {
            // console.log('go show')
            cur_sh = 'hide';
            $('#password').prop('type', 'password')
          }
        })
        var loginForm = $('#loginForm');
        // var submitBtn = loginForm.find('#loginBtn');
        <?php
        // if (!empty($activator)) {
        //   echo 'swal("Succes Activation", "", "success")';
        // }
        ?>;

        loginForm.on('submit', (ev) => {
          ev.preventDefault();
          Swal.fire({
            title: 'Please Wait !',
            html: 'Loggin ..', // add html attribute if you want or remove
            allowOutsideClick: false,
          });
          Swal.showLoading()
          $.ajax({
            url: "<?= site_url() . 'login-process' ?>",
            type: "POST",
            data: loginForm.serialize(),
            success: (data) => {
              // buttonIdle(submitBtn);
              json = JSON.parse(data);
              if (json['error']) {
                Swal.fire({
                  icon: 'error',
                  title: 'Login Gagal',
                  text: json['message'],
                })
                // swal("Login Gagal", json['message'], "error");
                return;
              }
              $(location).attr('href', '<?= base_url() ?>dashboard');
            },
            error: () => {
              // buttonIdle(submitBtn);
            }
          });
        });
      });
    </script>
    <!-- latest jquery-->

    <!-- Bootstrap js-->
    <script src="<?= base_url() ?>assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- feather icon js-->
    <script src="<?= base_url() ?>assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="<?= base_url() ?>assets/js/icons/feather-icon/feather-icon.js"></script>

    <!-- <script src="<?= base_url() ?>assets/js/sweet-alert/sweetalert.min.js"></script> -->
    <!-- <script src="<?= base_url() ?>assets/js/sweet-alert/app.js"></script> -->
    <!-- scrollbar js-->
    <!-- Sidebar jquery-->
    <script src="<?= base_url() ?>assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="<?= base_url() ?>assets/js/script.js"></script>
    <?php
    // $this->load->view('myads');
    ?>
    <!-- login js-->
    <!-- Plugin used-->
  </div>
</body>

</html>