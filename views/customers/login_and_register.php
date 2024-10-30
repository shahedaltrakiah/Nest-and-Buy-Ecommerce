<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/public/images/Logo (2).png">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0-alpha1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/loginstyle.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

    <!-- Include SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

</head>
<body>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form id="registerForm" action="/customers/login_and_register" method="POST" onsubmit="return validateRegisterForm()">
            <h1>Create Account</h1>
            <input type="hidden" name="form_type" value="signup">
            <input type="text" id="firstName" name="first_name" placeholder="First Name">
            <input class="m-3" type="text" id="lastName" name="last_name" placeholder="Last Name">
            <input type="email" id="email" name="email" placeholder="Email">
            <input class="m-3" type="tel" id="phone" name="phone_number" placeholder="Phone Number">
            <input type="password" id="password" name="password" placeholder="Password">
            <input class="m-3" type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm Password">
            <button type="submit" style="margin-top: 10px;">Sign Up</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form id="loginForm" action="/customers/login_and_register" method="POST" onsubmit="return validateLoginForm()">
            <h1>Sign in</h1>
            <input type="hidden" name="form_type" value="signin">
            <input type="email" id="loginEmail" name="email" placeholder="Email"/>
            <input type="password" id="loginPassword" name="password" placeholder="Password"/>
            <a href="#">Forgot your password?</a>
            <button>Sign In</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start your journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle Sign In and Sign Up panels
    document.addEventListener('DOMContentLoaded', function () {
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    });

</script>
<script src="/public/js/main.js"></script>
</body>
</html>
