<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mazer Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('mazer/dist/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/dist/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/dist/assets/css/pages/auth.css') }}">
</head>

<body style="background: whitesmoke">
    <div id="auth">
        <div class="row  justify-content-center">
            <div class="col-lg-5 col-12 align-self-center">

                <div id="auth-left">

                    <div class="card" style="background: white">
                        <div class="card-content">
                            <div class="card-body">
                                <h1 class="auth-title text-center">Login</h1>
                                <div class="mb-2 d-flex justify-content-center">
                                    <a href="index.html">
                                        <img src="https://simawa.pnp.ac.id/image/pnp.png"
                                            style="width:150px;height:150px; alt=" Logo">
                                    </a>
                                </div>
                                <div class="text-center">
                                    <p class="auth-subtitle">Sistem Informasi Manajemen</p>
                                    <p class="auth-subtitle" style="margin-top:-15px">Pemberian Beasiswa</p>
                                </div>


                                <form action="index.html">
                                    <div class="form-group position-relative has-icon-left mb-4">
                                        <input type="text" class="form-control form-control-xl" placeholder="Username">
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                    <div class="form-group position-relative has-icon-left mb-4">
                                        <input type="password" class="form-control form-control-xl"
                                            placeholder="Password">
                                        <div class="form-control-icon">
                                            <i class="bi bi-shield-lock"></i>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</body>

</html>
