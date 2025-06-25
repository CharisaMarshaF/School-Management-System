<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Login</title>

    <link rel="shortcut icon" href="{{ url('public/assets/img/favicon.png') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ url('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ url('public/assets/plugins/feather/feather.css') }}">

    <link rel="stylesheet" href="{{ url('public/assets/plugins/icons/flags/flags.css') }}">

    <link rel="stylesheet" href="{{ url('public/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ url('public/assets/css/style.css') }}">
</head>

<body>

    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="{{ url('public/assets/img/login.png') }}" alt="Logo">
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Log In</h1>
                            <p class="account-subtitle"> <a href="register.html"></a></p>
                            <h2>Welcome user </h2>
                            <form action="{{ url('login') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Email <span class="login-danger">*</span></label>
                                    <input class="form-control" required name="email" type="text">
                                    <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                </div>
                                <div class="form-group">
                                    <label>Password <span class="login-danger">*</span></label>
                                    <input class="form-control pass-input" type="password" name="password" required>
                                    <span id="togglePassword" class="profile-views feather-eye toggle-password"></span>
                                </div>
                                
                                
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                                </div>
                            </form>
                            @include('_message')


                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function () {
        $('#togglePassword').on('click', function () {
            let input = $('.pass-input');
            let type = input.attr('type') === 'password' ? 'text' : 'password';
            input.attr('type', type);

            // Toggle icon (optional)
            $(this).toggleClass('feather-eye feather-eye-off');
        });

        // Feather icons refresh
        feather.replace();
    });
</script>



    <script src="{{ url('public/assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ url('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ url('public/assets/js/feather.min.js') }}"></script>

    <script src="{{ url('public/assets/js/script.js') }}"></script>
</body>

</html>