<?php
$url = $url ?? new UrlHelpers();
$request = $request ?? new Requests();
$database = $database ?? new DatabaseOps();

$_SESSION['secretcode'] = rand(10000000000, 99999999999);
$key = $request->encodeRequestHash($_SESSION['secretcode']);
?>

<head>
  <meta charset="utf-8">
  <title>Register - Leather Plus</title>
  <meta name="description" content="Login to your Leather Plus Account">

  <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
  <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
  <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />

  <!-- Favicon and Apple Icons -->
  <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair Display">

  <!--- jQuery -->


</head>
<style>
  body,
  html {
    height: 100%;
    width: 100%;
    margin: 0;
    padding: 0;
  }

  .container {
    background-color: #fff;
    display: flex;

    max-width: 100%;
    margin-bottom: 60px;
    position: relative;
  }

  .left-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-top: 110px;
    margin-bottom: 100px;
  }

  .right-section {
    flex: 1;
    background-image: url('<?= $url->baseUrl("views/app/assets/images/login-bg-1.png") ?>');
    /* Replace with your image path */
    background-size: cover;
    background-position: center;
    padding-top: 200px;

  }

  .logo {
    font-size: 22px;
    font-weight: bold;
    color: #5B3A1D;
    padding-top: 35px;
    padding-left: 25px;
    position: absolute;
    top: 0;
  }

  .plus {
    color: #A07C4D;
  }

  h1 {
    font-size: 32px;
    margin-bottom: 10px;
  }

  .welcome {
    font-size: 16px;
    color: #777;
    margin-bottom: 30px;
  }

  .login-form {
    padding: 20px 80px 20px 80px;
  }

  .login-form label {
    display: block;
    margin: 8px 0 5px;
    font-size: 14px;
    color: #444;
  }

  .login-form input[type="text"],
  .login-form input[type="email"],
  .login-form input[type="password"],
  .login-form input[type="tel"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
  }

  .form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0px;
  }

  .remember {
    font-size: 14px;
  }

  .forgot {
    color: #5B9470;
    font-size: 14px;
    text-decoration: none;
  }

  .login-btn {
    background-color: #5B3A1D;
    color: white;
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
  }

  .signup-text {
    margin-bottom: 20px;
    padding: 10px;
    font-size: 16px;
    color: #777;
    text-align: center;
  }

  .signup-text a {
    color: #5B9470;
    text-decoration: none;
  }

  @media screen and (max-width: 1188px) {
    .login-form {
      padding: 0px 20px;
    }
  }

  @media (max-width: 768px) {
    .left-section {
      margin: 0;
    }

    .container {
      flex-direction: column;
      height: auto;
      margin: 0;
      padding: 0 !important;
    }

    .right-section {
      display: none;
    }

    .login-form {
      padding: 30px 20px 10px 20px;
      margin-top: 253px;
    }

    .logo {
      padding: 20px 10px 0;
      height: 250px;
      background-image: url('<?= $url->baseUrl("views/app/assets/images/login-bg-1.png") ?>');
      /* Replace with mobile version of bg */
      background-size: cover;
      background-position: center;
      width: 100%;
    }

    h1 {
      font-size: 24px;
    }
  }

  .desktop-logo {
    display: block;
  }

  .mobile-logo {
    display: none;
  }

  @media (max-width: 768px) {
    .desktop-logo {
      display: none;
    }

    .mobile-logo {
      display: block;
      width: 100%;
      /* Optional: adjust size */
      max-width: 200px;
    }
  }
</style>

<div class="container">
  <div class="left-section">
    <div class="logo">
      <a href="<?= $url->baseUrl("") ?>">
        <!-- Desktop Logo -->
        <img src="<?= $url->baseUrl('views/app/assets/images/leatherplus_logo.png') ?>" class="desktop-logo"
          alt="logo" />

        <!-- Mobile Logo -->
        <img src="<?= $url->baseUrl('views/app/assets/images/leatherplus_logowhite.png') ?>" class="mobile-logo"
          alt="mobile logo" />
      </a>
    </div>

    <a href="<?= $url->baseUrl('') ?>" class="apply-button back-button">Back to Home</a>
    <form class="login-form" action="<?= $url->baseUrl('models/app/register.php') ?>" method="POST">
      <input type="hidden" name="key" value="<?= $key ?>">

      <h1>Create your account</h1>
      <p class="welcome">Sign up here.</p>

      <label for="name">Name</label>
      <input type="text" name="fullname" id="name" required />

      <label for="email">Email Address</label>
      <input type="email" name="email" id="email" required />

      <label for="phone">Phone Number</label>
      <input type="tel" name="phone" id="phone" required />

      <label for="password">Create Password</label>
      <input type="password" name="password" id="password" required />

      <label for="confirm">Confirm Password</label>
      <input type="password" name="confirm_password" id="confirm" required />

      <div class="form-options">
        <label class="remember">
          <input type="checkbox" name="rememberme" />
          Remember Me
        </label>
      </div>

      <button type="submit" class="login-btn">Register</button>

      <p class="signup-text">Already have an account? <a href="<?= $url->baseUrl('login') ?>" style="color:#5c2e0f;">Log
          In</a></p>
    </form>
  </div>

  <div class="right-section">
    <!-- Toast container -->
    <div class="position-absolute top-0 end-0 p-3 d-none d-md-block" style="z-index: 9999; bottom:20px;right:20px;">
      <div id="toast-desktop" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body" id="toast-body-desktop"></div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto"
            style="background: transparent !important;border:none !important;color:white !important;"
            data-bs-dismiss="toast" aria-label="Close">X</button>
        </div>
      </div>
    </div>


  </div>
  <div class="position-absolute p-3 d-block d-md-none" style="z-index: 9999; bottom: 20px;transform: translateX(35%);">
    <div id="toast-mobile" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive"
      aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="toast-body-mobile"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto"
          style="background: transparent !important;border:none !important;color:white !important;"
          data-bs-dismiss="toast" aria-label="Close">X</button>
      </div>
    </div>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function showToast(message, isSuccess = true, delay = 5000) {
    const isMobile = window.innerWidth <= 768;

    const toastId = isMobile ? "toast-mobile" : "toast-desktop";
    const toastBodyId = isMobile ? "toast-body-mobile" : "toast-body-desktop";

    const toastElement = document.getElementById(toastId);
    const toastBody = document.getElementById(toastBodyId);

    toastBody.textContent = message;

    toastElement.classList.remove("bg-success", "bg-danger");
    toastElement.classList.add(isSuccess ? "bg-success" : "bg-danger");

    const toast = new bootstrap.Toast(toastElement, { delay });
    toast.show();
  }

  // Validate password before submit
  document.querySelector('.login-form').addEventListener('submit', function (e) {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm').value;

    if (password !== confirm) {
      e.preventDefault();
      showToast("Passwords do not match!", false, 3000);
    }
  });
</script>