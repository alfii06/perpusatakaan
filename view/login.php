<?php 

session_start();
require_once '../php/database.php';

// Contoh penggunaan:
$database = new Database();

if(isset($_SESSION['id'])) {
  header("Location: profil.php");
  exit;
}

if(isset($_POST['masuk'])) {
  $users = $database->login($_POST);
  if($users === 'berhasil') {
    $_SESSION['notifikasiBerhasil'] = 'berhasil'; 
    header("Location: profil.php");
    exit;
  }else if($users === 'admin') { 
    header("Location: profil.php");
    exit;
  }else if($users === 'petugas') {
    header("Location: profil.php");
    exit;
  }else if($users === 'gagal') {
    $_SESSION['notifikasiBerhasil'] = 'gagal'; 
  }

  header("Location: login.php");
  exit;

}
$notifikasiBerhasil = isset($_SESSION['notifikasiBerhasil']) ? $_SESSION['notifikasiBerhasil'] : null;
unset($_SESSION['notifikasiBerhasil']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="../style/style.css" />

    <title>Halaman Login</title>
  </head>
  <body>
    <div class="section-login">
      <div class="row">
        <div
          class="col-lg-6"
          style="background-color: #424787; height: auto; padding-bottom: 5rem"
        >
          <div class="logo">
            <img
              src="../assets/logo-1.png
            "
              alt=""
            />
            <h1 style="color: white; font-weight: 700">
              Selamat Datang di perpustakaan 
            </h1>
            <img class="gambar-kiri" src="../assets/gambar-kiri.png" alt="" />
          </div>
        </div>
        <div class="col-lg-6">
          <form action="" method="post">
            <img src="../assets/logo-2.png" class="ms-5" alt="" />
            <h2 class="text-center" style="color: #424787; font-weight: 700">
              Masukan Akun Anda
            </h2>
                                  <?php if(isset( $notifikasiBerhasil) &&  $notifikasiBerhasil === 'gagal') : ?>
                                        <div class="alert alert-danger" role="alert">
                                            Gagal masuk, username atau password anda salah
                                        </div>
                                    <?php endif;?>     
            <div class="bungkus-input d-flex gap-3 align-items-center mt-5">
              <div class="icon"><i class="fa-solid fa-user"></i></div>
              <input type="text" name="username" placeholder="Masukan Username" />
            </div>
            <div class="bungkus-input d-flex gap-3 align-items-center mt-4">
              <div class="icon"><i class="fa-solid fa-lock"></i></div>
              <input type="password" name="password" placeholder="Masukan Password" />
            </div>
            <p class="mt-4 daftar" style="font-weight: 600">
              Belum memiliki akun ?<a
                href="daftar.php"
                style="color: #0098da; text-decoration: none"
              >
                Daftar Disini</a
              >
            </p>
            <div class="tombol text-center mt-3">
              <button type="submit" name="masuk" >Masuk Sekarang</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
