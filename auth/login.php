<?php include 'include/header.php' ?>

<?php

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = login($email, $password);

    if (is_array($result)) {
        // Jika login berhasil, Anda dapat melakukan sesuatu seperti mengatur session dan mengarahkan pengguna ke halaman dashboard
        $_SESSION['status_login'] = true;
        $_SESSION['info_user'] = $result;

        header("Location: ../index.php?page=dashboard");
        exit;
    } else {
        // Jika login gagal, tampilkan pesan kesalahan
        echo "<script>alert('$result')</script>";
    }
}

?>
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" />
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" />
                                <label for="inputPassword">Password</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button class="btn btn-primary" type="submit" name="login">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="register.php">Belum punya akun? Register!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'include/footer.php' ?>