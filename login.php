<?php
require 'functions.php';

if (isset($_POST["login"])){

    if(login($_POST)>0){
        echo "
        <script>
        document.location.href= 'index.php';
        </script>
        ";
    }else{
        echo "
        <script>
        alert('Username atau password yang dimasukkan salah');
        document.location.href= 'login.php';
        </script>
        ";
    };

};

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sakinah - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-success">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center mt-5">

            <div class="col-lg-5 mt-2">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="p-5">
                                    <div class="text-center mr-5 ml-5">
                                        <div class="d-flex flex-row align-items-center justify-content-center rounded-pill bg-success mr-4 ml-4">
                                            <div class="sidebar-brand-icon">
                                                <img id="logoimg" src="./img/sakinahlogo.png" width="35dp" alt="">
                                            </div>
                                            <h1 class="h4 text-white mt-2 p-1"><b>SAKINAH</b></h1>
                                        </div>
                                        <!-- <h5 class="text-gray-900 mb-4">Welcome Back!</h5> -->
                                    </div>
                                    <form class="user pt-3" method="POST">
                                        <div class="form-group m-4">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Username" name="username" required>
                                        </div>
                                        <div class="form-group m-4">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="password" required>
                                        </div>
                                        <div class="mr-5 ml-5 mt-5 mb-3">
                                            <button class="btn btn-success btn-user btn-block" type="submit"
                                                name="login">
                                                Login
                                            </button>
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>