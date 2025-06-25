<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Forgot Password</title>

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
                            <h1>Forgot Password</h1>
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Email <span class="login-danger">*</span></label>
                                    <input class="form-control" required name="email" type="text">
                                    <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                </div>
                               
                                <div class="forgotpass">
                                    
                                    <a href="{{ url('forgot-password') }}">Login</a>
                                </div>
                                
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Forgot</button>
                                </div>
                            </form>
                            @include('_message')


                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ url('public/assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ url('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ url('public/assets/js/feather.min.js') }}"></script>

    <script src="{{ url('public/assets/js/script.js') }}"></script>
</body>

</html>