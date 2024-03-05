<?php 
session_start();

require_once '../php/database.php';

$database = new Database();

if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
} else {
    $dataProfil = $database->profile();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../style/list.css" />
    <link rel="stylesheet" href="../style/profil.css">
    <title>List buku</title>
  </head>
  <body>
    <div class="section-list">
      <div class="row">
        <div
          class="col-lg-2 col-md-1 responsif-hp"
          style="background-color: #424787; height: 100vh"
        >
          <img
            class="mt-3 ms-4 mb-1 logo1"
            src="../assets/"
            width="150"
            alt=""
          />
          <div class="bungkus-link">
            <img src="../assets/icon-user.png" width="25" alt="" />
            <a href="profil.php" class="link">Profil anda</a>
          </div>
          <div class="bungkus-link">
            <img src="../assets/icon-list.png" alt="" />
            <a href="list-buku.php" class="link">List Buku</a>
          </div>
          
          <?php if($_SESSION['user'] === 'admin' || $_SESSION['user'] === 'petugas') :?>
          <div class="bungkus-link">
            <img src="../assets/icon-pinjam.png" alt="" />
            <a href="data-peminjaman-admin.php" class="link">Peminjaman Buku</a>
          </div>
          <?php endif; ?>
          
          <?php if($_SESSION['user'] === 'user') :?>
          <div class="bungkus-link">
            <img src="../assets/icon-tambah-buku.png" alt="" />
            <a href="data-peminjaman-user.php" class="link">Peminjaman Saya</a>
          </div>
          <?php endif; ?>

          <?php if($_SESSION['user'] === 'user') :?>
          <div class="bungkus-link">
            <img src="../assets/icon-tambah-peminjam.png" alt="" />
            <a href="koleksi.php" class="link">Koleksi Saya</a>
          </div>
          <?php endif;?>

          
          <?php if($_SESSION['user'] === 'admin' || $_SESSION['user'] === 'petugas') :?>
          <div class="bungkus-link">
            <img src="../assets/icon-koleksi.png" alt="" />
            <a href="list-buku-admin.php" class="link">Tambah Buku</a>
          </div>
          
          <?php endif; ?>

        </div>
        <div class="col-lg-10 col-md-11 ">
          <nav
            class="navbar navbar-expand-lg navbar-light pt-4"
            style="background-color: #424787"
          >
            <div class="container">
              <a class="navbar-brand" href="#"
                ><img src="../assets/logo-3.png" width="100" alt=""
              /></a>
              <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <span class="" style="border: none; cursor: pointer"
                  ><i class="fa-solid fa-bars" style="color: white"></i
                ></span>
              </button>
              <div
                class="collapse navbar-collapse justify-content-end"
                id="navbarNav"
              >
                <div style="margin-right: 25%">
                  <ul class="navbar-nav">
                  <li class="nav-item">
                                        <a class="nav-link menu me-4" style="color: white" aria-current="page" href="profil.php">Profil</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link menu me-4" style="color: white" aria-current="page" href="list-buku.php">List Buku</a>
                                    </li>
                                    <?php if($_SESSION['user'] === 'admin' || $_SESSION['user'] === 'petugas') :?>
                                    <li class="nav-item">
                                        <a class="nav-link menu me-4" style="color: white" href="data-peminjaman-admin.php">Daftar Peminjaman Buku</a>
                                    </li>
                                    <?php endif;?>
                                    
                                    <?php if($_SESSION['user'] === 'user') :?>
                                    <li class="nav-item">
                                        <a class="nav-link menu me-4" style="color: white" href="data-peminjaman-user.php">Peminjaman Saya</a>
                                    </li>
                                    <?php endif;?>
                                    
                                    <?php if($_SESSION['user'] === 'user') :?>
                                    <li class="nav-item">
                                        <a class="nav-link menu me-4" style="color: white" href="koleksi.php">Koleksi Saya</a>
                                    </li>
                                    <?php endif;?>
                                    
                                    <?php if($_SESSION['user'] === 'admin' || $_SESSION['user'] === 'petugas') :?>
                                    <li class="nav-item">
                                        <a class="nav-link menu me-4" style="color: white" href="list-buku-admin.php">Tambah Buku</a>
                                    </li>
                                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </nav>
          <!-- end nav -->
         <div class="section-kanan-profil">
<div class="bg-kanan-profil">
    
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="kartu-kanan-profil">
              <div class="judul-profil text-center">

                <p style="color: white;background-color: #424787;font-weight: 600;border-radius: 30px;padding: 0.5rem 1rem;">Halaman Profil</p>
              </div>
              <div class="gambar-user" style="width: 100px;height: 100px;border-radius: 50%;background-image:url('../assets/user.jpg');
              background-repeat:no-repeat;
              background-size:cover;
              background-position:center;display: flex;margin: auto;margin-top: 2rem;"></div>
              <div class="row">
                <div class="col-lg-6">

                  <div class="isi-bio-user mt-4">
                    <p>Nama Lengkap</p>
                    <h5 style="padding: 0.5rem 1rem;border-radius: 30px;background-color: white;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;font-weight: 700;"><?php echo $dataProfil['NamaLengkap'] ?></h5>
                  </div>
                  <div class="isi-bio-user mt-4">
                    <p>Username</p>
                    <h5 style="padding: 0.5rem 1rem;border-radius: 30px;background-color: white;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;font-weight: 700;"><?php echo $dataProfil['Username'] ?></h5>
                  </div>
                </div>
                <div class="col-lg-6">

                  <div class="isi-bio-user mt-4">
                    <p>Alamat</p>
                    <h5 style="padding: 0.5rem 1rem;border-radius: 30px;background-color: white;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;font-weight: 700;color: black;"><?php echo $dataProfil['alamat'] ?></h5>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">

                  <div class="isi-bio-user mt-2">
                    <p>Emal</p>
                    <h5 style="padding: 0.5rem 1rem;border-radius: 30px;background-color: white;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;font-weight: 700;"><?php echo $dataProfil['Email'] ?></h5>
                  </div>
                </div>
                <div class="col-lg-6">

                  <div class="isi-bio-user text-end" style="margin-top: 4rem;">
                    <a href="#" onclick="confirmLogout()" style="text-decoration: none;color: white;font-weight: 500;padding: 0.5rem 1rem;border-radius: 30px;background-color: red;">Keluar Akun</a>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
         </div>
          </div>
        </div>
      </div>
    </div>
    <script>
        function confirmLogout() {
            if(confirm("Apakah Anda yakin ingin keluar dari akun?")) {
                window.location.href = "keluar.php";
            }
        }
    </script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
