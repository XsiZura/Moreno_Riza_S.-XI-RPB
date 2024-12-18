<?php
session_start();
require 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>

<style>
    body {
        background: linear-gradient(45deg, red, orange, green, yellow, blue, purple, crimson) 0 0 / 1000% no-repeat;
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

                                    <h2 class="fw-bold mb-2 mb-3 text-uppercase">Register</h2>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" id="username" name="username" placeholder="Username" class="form-control form-control-lg" />

                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="password">Password</label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password" placeholder="Password" class="form-control form-control-lg" />
                                            <button type="button" onclick="togglepass()" class="btn btn-outline-secondary">show</button>
                                        </div>
                                    </div>
                                    <div class="-grid gap-2 d-md-flex justify-content-between">
                                        <a role="button" class="btn btn-outline-light btn-lg px-5" href="login.php">Kembali</a>
                                        <button class="btn btn-outline-light btn-lg px-5" type="submit" name="register">Register</button>
                                    </div>
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
        if (isset($_POST['register'])) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");

            if (mysqli_num_rows($query) > 0) {
                echo "<script>alert('Username sudah terdaftar!');</script>";
            } else {
                $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

                $queryRegist = mysqli_query($koneksi, "INSERT INTO user (username, password) VALUES ('$username','$hashed_pass')");

                if ($queryRegist) {
                    echo "<script>alert('Registrasi berhasil!'); window.location.href = 'login.php'</script>";
                } else {
                    echo "<script>alert('Terjadi kesalahan, silakan coba lagi.')</script>";
                }
            }
        }
        ?>
    </div>

    <SCript>
        function togglepass() {
            const passwordField = document.getElementById("password");
            const toggleButton = passwordField.nextElementSibling;
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "hide";
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "show";
            }
        }
    </SCript>
    </div>
</body>

</html>