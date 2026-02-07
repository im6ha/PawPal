<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/other-pages/login-signup-page.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('media/images/logo-brand.png') }}" />
</head>
<body>
    <a href="{{ url('/') }}">
        <img src="{{ asset('media/images/logo.png') }}" alt="Logo" width="70" height="70" />
    </a>

    <div class="form_container">
        <form action="{{ route('login') }}" id="login-form">
            @csrf
            <div class="the_form">
                <h2 style="font-weight: bold; margin-bottom: 0; font-family: 'Poppins', sans-serif;">
                    Welcome Back!
                </h2>
                <h5 style="color: gray; margin-top: 2%; font-family: 'Poppins', sans-serif;">
                    Enter your details:
                </h5>

                <label for="email" class="form_label">Email: </label>
                <input type="text" id="email" name="email" style="margin-bottom: 2%" />
                <p id="email_check" class="check"></p>

                <label for="password" class="form_label">Password: </label>
                <div class="password_container">
                    <input type="password" id="password" name="password" />
                    <span class="showpassword" onclick="showpassword()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#000000">
                            <g fill="#000000">
                                <path d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0Z"/>
                                <path fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20c4.182 0 7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4C7.818 4 4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12Zm10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5Z" clip-rule="evenodd"/>
                            </g>
                        </svg>
                    </span>
                </div>
                <p id="password_check" class="check"></p>

                <br /><br />
                <button type="submit" id="submit">Log In</button>                

                  <br />
                <h5 style="color: gray">
                    Don't have an account? <a href="{{ url('signup-page') }}">Sign up!</a>
                </h5>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/other-scripts/login.js') }}" type="module"></script>
</body>
</html>