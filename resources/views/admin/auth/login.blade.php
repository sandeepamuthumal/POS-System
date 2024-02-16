<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<meta property="og:description" content="Circuit Galaxy" />
	<meta property="og:image" content="https://zenix.dexignzone.com/xhtml/social-image.png" />
	<meta name="format-detection" content="telephone=no">

    <title>Circuit Galaxy - Login</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/Circuit.jpg') }}">

    @include('admin.libraries.styles')

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<img src="{{ asset('logo/Circuit.jpg') }}" alt="" style="width:150px;">
									</div>
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form action="{{ url('/login_process') }}" method="post">
                                     @csrf
                                        <div class="form-group">
                                            <label class="mb-1"><strong>User Name</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                <input type="text" value="{{ old('user_name') }}"
                                                    class="form-control"
                                                    name="user_name" placeholder="Enter a username..">
                                            </div>
                                            <span class="text-danger">
                                                @error('user_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <div class="input-group transparent-append">
                                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                                <input type="password" name="login_password" class="form-control"
                                                    id="dz-password" placeholder="Enter a password..">
                                                <span class="input-group-text show-pass">
                                                    <i class="fa fa-eye-slash"></i>
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                            <span class="text-danger">
                                                @error('login_password')
                                                    {{ $message }}
                                                @enderror
                                            </span>

                                        </div>

                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-success btn-block btn-shadow  mt-4 mb-4" style="background-color:rgb(245, 172, 14)">Sign Me
                                                In</button>
                                        </div>

                                        @if (Session::has('success'))
                                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                                        @endif

                                        @if (Session::has('fail'))
                                            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                                        @endif

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    @include('admin.libraries.scripts')


</body>
</html>
