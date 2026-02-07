<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up | PawPal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/other-pages/login-signup-page.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('media/images/logo-brand.png') }}">
    <style>
        .check { color: red; font-size: 0.8em; margin: 5px 0; min-height: 1em; }
        .file-input-container { margin: 15px 0; text-align: left; }
        .file-input-container label { display: block; margin-bottom: 5px; color: gray; font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body>
    <a href="{{ url('/') }}">
        <img src="{{ asset('media/images/logo.png') }}" alt="Logo" width="70" height="70">
    </a>

    <div class="form_container">
        <form id="signup-form" enctype="multipart/form-data">
            @csrf
            <div class="the_form">
                <h2 style="font-weight: bold; margin-bottom: 0; font-family: 'Poppins', sans-serif;">Welcome!</h2>
                <h5 style="color: gray; margin-top: 2%; font-family: 'Poppins', sans-serif;">Enter your details:</h5>

                <input type="text" id="full-name" name="full_name" placeholder="Full Name">
                <p class="check" id="full-name-ch"></p>

                <input type="email" id="email" name="email" placeholder="Email">
                <p class="check" id="email-ch"></p>

                <input type="tel" id="phone-name" name="phone_number" placeholder="Phone Number">
                <p class="check" id="phone-ch"></p>

               

                <input type="password" id="password" name="password" placeholder="Password">
                <p class="check" id="password-ch"></p>

                <input type="password" id="confirm-password" name="password_confirmation" placeholder="Confirm Password">
                <p class="check" id="confirm-password-ch"></p>

                 <div class="file-input-container">
                    <label for="user_pic">Profile Picture (Optional):</label>
                    <input type="file" id="user_pic" name="user_pic" accept="image/*">
                </div>

                <button type="submit" id="submit">Sign Up</button>
                
                <h5 style="color:gray;">
                    Already Have An Account? <a href="{{ url('login-page') }}">Log In!</a>
                </h5>
            </div>
        </form>
    </div>

    <script>
        window.SIGNUP_URL = "{{ route('signup.store') }}";
    </script>
    <script src="{{ asset('js/other-scripts/signup-check.js') }}" type="module"></script>
</body>
</html>