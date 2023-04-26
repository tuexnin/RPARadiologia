<!doctype html>
<html lang="en" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

        <title>SRA - Login</title>

        <meta name="description" content="RPARadiologia es un sistema de registro de atencion a usuarios">
        <meta name="author" content="Tuexnin">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="RPARadiologia">
        <meta property="og:site_name" content="RPARadiologia">
        <meta property="og:description" content="RPARadiologia es un sistema de registro de atencion a usuarios">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="pages/assets/img/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="pages/assets/img/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="pages/assets/img/favicons/apple-touch-icon-180x180.png">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="pages/assets/js/plugins/swta2/sweetalert2.min.css">
        <!-- Codebase framework -->
        <link rel="stylesheet" id="css-main" href="pages/assets/css/codebase.min.css">
        <!-- END Stylesheets -->
    </head>
    <body>
        <div id="page-container" class="main-content-boxed">
            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="bg-gd-dusk">
                    <div class="hero-static content content-full bg-white invisible" data-toggle="appear">
                        <!-- Header -->
                        <div class="py-30 px-5 text-center">
                            <a class="link-effect font-w700" href="index.html">
                                <i class="si si-fire"></i>
                                <span class="font-size-xl text-primary-dark">RPA</span><span class="font-size-xl">Radiologia</span>
                            </a>
                            <div class="col mt-10">
                            <img src="files/img/logoEsSalud.png" class="" alt="logo EsSalud" width="150px">
                            </div>
                            
                            <h1 class="h2 font-w400 mt-10 mb-10">Bienvenidos al panel de administracion</h1>
                            <h2 class="h4 font-w300 text-muted mb-0">Por favor ingrese</h2>
                        </div>
                        <!-- END Header -->

                        <!-- Sign In Form -->
                        <div class="row justify-content-center px-5">
                            <div class="col-sm-8 col-md-6 col-xl-4">
                                <form class="js-validation-signin" id="formulario" method="post">
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="form-material floating">
                                                <input type="text" class="form-control" id="login-username" name="login-username">
                                                <label for="login-username">Usuario</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="form-material floating">
                                                <input type="password" class="form-control" id="login-password" name="login-password">
                                                <label for="login-password">Contraseña</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row gutters-tiny">
                                        <div class="col-12 mb-10">
                                            <button type="submit" class="btn btn-block btn-hero btn-noborder btn-rounded btn-alt-primary" id="btnIngresar">
                                                <i class="si si-login mr-10"></i> Ingresar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END Sign In Form -->
                    </div>
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

        <!-- Codebase Core JS -->
        <script src="pages/assets/js/core/jquery.min.js"></script>
        <script src="pages/assets/js/core/popper.min.js"></script>
        <script src="pages/assets/js/core/bootstrap.min.js"></script>
        <script src="pages/assets/js/core/jquery.slimscroll.min.js"></script>
        <script src="pages/assets/js/core/jquery.scrollLock.min.js"></script>
        <script src="pages/assets/js/core/jquery.appear.min.js"></script>
        <script src="pages/assets/js/core/jquery.countTo.min.js"></script>
        <script src="pages/assets/js/core/js.cookie.min.js"></script>
        <script src="pages/assets/js/codebase.js"></script>

        <!-- Page JS Plugins -->
        <script src="pages/assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="pages/assets/js/plugins/swta2/sweetalert2.all.min.js"></script>

        <!-- Page JS Code -->
        <!--<script src="pages/assets/js/pages/op_auth_signin.js"></script>-->
        <script src="login/scripts/login.js"></script>
    </body>
</html>