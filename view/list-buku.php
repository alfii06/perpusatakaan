<?php 
session_start();

require_once '../php/buku.php';

$database = new Database();

if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
} else {
  $listKategori = $database->listCategories();
  $listBukuPeminjaman = $database->listBookUser();
  
  if(isset($_GET['kategori'])) {
    $cariKategori = $database->searchCategories(intval($_GET['kategori']));
    $listBukuPeminjaman = $cariKategori;
  }

  if (isset($_POST['cari-buku'])) {
    $isi = $_POST['isi-pencarian'];
    if($isi != '') {
        $listBukuPeminjaman = $database->searchBook($isi);
    }
  }
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
    <title>List buku</title>
  </head>

  <style>
    .cari input {
  border: none;
  width: 300px !important;
}

.cari {
  width: 300px;
  border-bottom: 1px solid black;
}

  </style>
  <body>
    <div class="section-list">
      <div class="row">
        <div
          class="col-lg-2 col-md-1 responsif-hp"
          style="background-color: #424787; height: 100vh"
        >
          <img
            class="mt-3 ms-4 mb-1 logo1"
            src="../assets/logo-3.png"
            width="150"
            alt=""
          />
          <div class="bungkus-link">
            <img src="../assets/icon-user.png" width="25" alt="" />
            <a href="" class="link">Profil anda</a>
          </div>
          <div class="bungkus-link">
            <img src="../assets/icon-list.png" alt="" />
            <a href="" class="link">List Buku</a>
          </div>
          <div class="bungkus-link">
            <img src="../assets/icon-pinjam.png" alt="" />
            <a href="" class="link">Data peminjam</a>
          </div>
          <div class="bungkus-link">
            <img src="../assets/icon-tambah-buku.png" alt="" />
            <a href="" class="link">Tambah Buku</a>
          </div>
          <div class="bungkus-link">
            <img src="../assets/icon-tambah-peminjam.png" alt="" />
            <a href="" class="link">Tambah peminjam</a>
          </div>
          <div class="bungkus-link">
            <img src="../assets/icon-koleksi.png" alt="" />
            <a href="" class="link">Koleksi pribadi</a>
          </div>
        </div>
        <div class="col-lg-10 col-md-11 kanan-dasboard">
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
                      <a
                        class="nav-link menu me-4"
                        style="color: white"
                        aria-current="page"
                        href="#"
                        >List Buku</a
                      >
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link menu me-4"
                        style="color: white"
                        href="#"
                        >Peminjam</a
                      >
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link menu me-4"
                        style="color: white"
                        href="#"
                        >Tambah Buku</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link menu" style="color: white" href="#"
                        >Koleksi Pribadi</a
                      >
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </nav>
          <!-- end nav -->
          <div class="container">
            <div class="bungkus-link-kanan">
              <?php foreach ($listKategori as $data) : ?>
                <a href="list-buku.php?kategori=<?php echo $data['KategoriID'] ?>"><?php echo $data['NamaKategori']?></a>
                <?php endforeach ?>
                <a href="list-buku.php">Semua</a>
            </div>
            <div class="container">
              <div class="d-flex flex-row-reverse">
                <form action="" method="post">
                  <div class="p-2 me-5 cari d-flex">
                    <i class="fa-solid fa-magnifying-glass" style="margin-top:7px; margin-right:20px;color: #999999;"></i>  
                    <input autocomplete="off" name="isi-pencarian" type="text" placeholder="Cari Buku">
                    <button name="cari-buku" type="submit" style="border:none; background-color: #006FD6; padding: 5px 25px; color: white; border-radius: 25px;">Cari</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <?php foreach ($listBukuPeminjaman as $data) : ?>
                <div class="col-lg-3 col-md-6 mt-5">
                  <div class="kartu">
                    <img class="d-flex m-auto" src="../assets/buku.png" alt="" />
                    <h5 class="text-center mt-3" style="font-weight: 700">
                      <?php echo $data['Judul']?>
                    </h5>
                    <p class="text-center" style="font-size: 13px">
                    <?php echo $data['Penulis']?> | <?php echo $data['TahunTerbit']?>
                    </p>
                    <div class="lihat text-center pb-3">
                      <a
                        href="detail-buku.php?id=<?php echo $data['BukuID'] ?>"
                        style="
                          text-decoration: none;
                          color: white;
                          padding: 0.3rem 1.5rem;
                          background-color: #0098da;
                          border-radius: 30px;
                        "
                        >Lihat Buku</a
                      >
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
          </div>
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
