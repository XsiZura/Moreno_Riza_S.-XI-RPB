<?php
session_start();
require '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<style>
    body {
        background: linear-gradient(45deg, red, orange,green, yellow, blue, purple, crimson) 0 0 / 1000% no-repeat;
        animation: animate 5s ease infinite;
    }

    @keyframes animate {
        0% {
            background-position: 0 30%, 0 0;
        }

        50% {
            background-position: 100% 70%, 0 0;
        }

        100% {
            background-position: 0 30%, 0 0;
        }
    }
</style>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-5 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form action="" method="post">
                                <div class="mb-md-5 mt-md-4 pb-5">

                                    <h2 class="fw-bold mb-2 mb-3 text-uppercase">Login Admin RenZ Store</h2>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" id="username" name="username" placeholder="Username" class="form-control form-control-lg" />

                                    </div>

                                    <div  class="form-outline form-white mb-4">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" id="password" name="password" placeholder="Password" class="form-control form-control-lg" />
                                    </div>
                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit" name="btnlogin">Login</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div>
        <?php
        if (isset($_POST['btnlogin'])) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
            $countdata = mysqli_num_rows($query);
            $data = mysqli_fetch_array($query);

            if ($countdata > 0) {
                if (password_verify($password, $data['password'])) {
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['login'] = true;
                    header('location: index.php');
                } else {
        ?>
                    <div class="alert alert-warning" role="alert">
                        Password Salah
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="alert alert-warning" role="alert">
                    Akun Tidak ada
                </div>
        <?php
            }
        }
        ?>
    </div>
    </div>
</body>

</html>