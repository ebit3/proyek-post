<?php include 'include/header.php' ?>

<?php

if (isset($_POST['simpan'])) {
    // Ambil data yang dimasukkan oleh pengguna dari formulir
    $data = array(
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password']
    );

    // Panggil fungsi registrasi dengan data yang diterima
    $hasil_registrasi = Register($data);
}

?>

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Register</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputName" type="text" name="name" placeholder="Enter your first name" />
                                <label for="inputName">First name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" />
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Create a password" />
                                <label for="inputPassword">Password</label>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid">
                                    <button class="btn btn-primary d-block" type="submit" name="simpan">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="login.php">Sudah punya akun? Silahkan login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'include/footer.php' ?>