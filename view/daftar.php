<?php 
session_start();

require_once '../php/database.php';

$database = new Database();
if(isset($_POST['daftar'])) {
  $users = $database->register($_POST);
  if($users === 'berhasil') {
    $_SESSION['notifikasiBerhasil'] = 'berhasil'; 
  }else if($users === 'email') {
    $_SESSION['notifikasiBerhasil'] = 'email'; 
  }else if($users === 'username') {
    $_SESSION['notifikasiBerhasil'] = 'username'; 
  }
  
  header("Location: daftar.php");
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
            <h1 class="welcome" style="color: white; font-weight: 700">
              Selamat Datang di perpustakaan
            </h1>
            <img class="gambar-kiri" src="../assets/gambar-kiri.png" alt="" />
          </div>
        </div>
        <div class="col-lg-6 pb-5">
          <form action="" method="post">
            <img src="../assets/logo-2.png" class="ms-5" alt="" />
            <h2 class="text-center" style="color: #424787; font-weight: 700">
              Daftarkan Akun Anda
            </h2>
                                    <?php if(isset( $notifikasiBerhasil) &&  $notifikasiBerhasil === 'email') : ?>
                                        <div class="alert alert-danger" role="alert">
                                          Daftar akun gagal, email sudah digunakan
                                        </div>
                                    <?php elseif(isset( $notifikasiBerhasil) &&  $notifikasiBerhasil === 'username'):?>
                                        <div class="alert alert-danger" role="alert">
                                          Daftar akun gagal, username sudah digunakan
                                        </div>
                                    <?php elseif(isset( $notifikasiBerhasil) &&  $notifikasiBerhasil === 'berhasil'):?>
                                        <div class="alert alert-success" role="alert">
                                          Daftar akun berhasil
                                        </div>
                                    <?php endif;?>      
            <div class="bungkus-input d-flex gap-3 align-items-center mt-5">
              <div class="icon"><i class="fa-solid fa-user"></i></div>
              <input type="text" name="username" required placeholder="Masukan Username" />
            </div>
            <div class="bungkus-input d-flex gap-3 align-items-center mt-4">
              <div class="icon"><i class="fa-solid fa-envelope"></i></div>
              <input type="text" name="email" required placeholder="Masukan Email" />
            </div>
            <div class="bungkus-input d-flex gap-3 align-items-center mt-4">
              <div class="icon"><i class="fa-solid fa-id-card-clip"></i></div>
              <input type="text" name="nama" required placeholder="Masukan Nama lengkap" />
            </div>
            <div class="bungkus-input d-flex gap-3 align-items-center mt-4">
              <div class="icon"><i class="fa-solid fa-address-book"></i></div>
              <input type="text" name="alamat" required placeholder="Masukan Alamat" />
            </div>
            <div class="bungkus-input d-flex gap-3 align-items-center mt-4">
              <div class="icon"><i class="fa-solid fa-lock"></i></div>
              <input type="password" name="password" placeholder="Konfirmasi Password" />
            </div>
            <p class="mt-4 daftar" style="font-weight: 600">
              Sudah memiliki akun ?<a
                href="login.php"
                style="color: #0098da; text-decoration: none"
              >
                Masuk Disini</a
              >
            </p>
            <div class="tombol text-center mt-3">
              <button type="submit" name="daftar">Daftar Sekarang</button>
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
