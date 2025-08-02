<?php
$url = $url ?? new UrlHelpers();
$request = $request ?? new Requests();
$database = $database ?? new DatabaseOps();

$_SESSION['secretcode'] = rand(10000000000, 99999999999);
$key = $request->encodeRequestHash($_SESSION['secretcode']);
$loginError = "";
if (isset($_SESSION['login_error'])) {
  $loginError = $_SESSION['login_error'];
  unset($_SESSION['login_error']);
}
?>

<head>
  <meta charset="utf-8">
  <title>Login - Leather Plus</title>
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
    max-width: 100% !important;
    margin-bottom: 60px;
    position: relative;
  }

  .left-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-top: 50px !important;
  }

  .right-section {
    flex: 1;
    background-image: url('<?= $url->baseUrl("views/app/assets/images/login-bg-1.png") ?>');
    /* Replace with your image path */
    background-size: cover;
    background-position: center;
    /* padding-top: 200px; */
    height: 100vh;
    position: relative;
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
    padding: 0px 80px;
  }

  .login-form label {
    display: block;
    margin: 15px 0 5px;
    font-size: 14px;
    color: #444;
  }

  .login-form input[type="email"],
  .login-form input[type="password"] {
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
    margin: 15px 0;
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
    margin-top: 20px;
    font-size: 16px;
    color: #777;
    text-align: center;
  }

  .signup-text a {
    color: #5B9470;
    text-decoration: none;
  }

  .desktop-logo {
    display: block;
  }

  .mobile-logo {
    display: none;
  }

  @media screen and (max-width: 1188px) {
    .login-form {
      padding: 0px 20px;
    }
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


  /* 🔁 Responsive Design */
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
      padding: 30px 20px;
      margin-top: 210px;
    }

    .logo {
      padding: 20px 10px 0;
      height: 250px;
      background-image: url('<?= $url->baseUrl("views/app/assets/images/login-bg-1.png") ?>');
      /* Replace with your image path */
      background-repeat: no-repeat;
      background-size: cover;
      width: 100%;
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
    <form class="login-form" action="<?= $url->baseUrl('models/app/login.php') ?>" method="POST">
      <input type="hidden" name="key" value="<?= $key ?>">

      <h1>Log In</h1>
      <p class="welcome">Welcome Back ! Please enter your credentials.</p>

      <label for="email">Email Address</label>
      <input type="email" name="email" id="email" required />

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required />

      <div class="form-options">
        <label class="remember">
          <input type="checkbox" name="rememberme" value="rememberme" />
          Remember Me
        </label>
        <!-- <a href="#" class="forgot" style="color:#5c2e0f;">Forgot Password?</a> -->
      </div>

      <button type="submit" class="login-btn">Login</button>

      <p class="signup-text">Don't have an account? <a href="<?= $url->baseUrl('register') ?>"
          style="color:#5c2e0f;">Create Now</a></p>
    </form>
  </div>

  <div class="right-section">
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;bottom:20px;right:20px;">
      <div id="toast-message-desktop" class="toast align-items-center text-white border-0" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body" id="toast-body-desktop"></div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
            aria-label="Close" style="background: transparent !important;border:none !important;color:white !important;">X</button>
        </div>
      </div>
    </div>

  </div>
  <div class="position-absolute p-3" style="z-index: 9999;top: 30%; transform: translateX(50%);">
    <div id="toast-message-mobile" class="toast align-items-center text-white border-0" role="alert"
      aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="toast-body-mobile"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
          aria-label="Close" style="background: transparent !important;border:none !important;color:white !important;">X</button>
      </div>
    </div>
  </div>

</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function showToast(message, isSuccess = true, delay = null) {
    const isMobile = window.innerWidth <= 768;

    const toastElement = document.getElementById(isMobile ? "toast-message-mobile" : "toast-message-desktop");
    const toastBody = document.getElementById(isMobile ? "toast-body-mobile" : "toast-body-desktop");

    toastBody.textContent = message;

    toastElement.classList.remove("bg-success", "bg-danger");
    toastElement.classList.add(isSuccess ? "bg-success" : "bg-danger");

    const toast = new bootstrap.Toast(toastElement, {
      delay: delay ?? 5000
    });
    toast.show();
  }
</script>

<?php if (!empty($loginError)): ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const loginError = "<?= addslashes($loginError) ?>";
      console.log(loginError);

      showToast(loginError, false, 2000);
      console.log("Login error displayed:", loginError);

    });
  </script>
<?php endif; ?>