<?php 
session_start();

require_once '../php/buku.php';

$database = new Database();

if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
} else {
  if(isset($_GET['id'])) {
    $ambilBuku = $database->getBook(intval($_GET['id']));
    if($ambilBuku === 'gagal') {
      header("Location: list-buku-admin.php");
      exit;
    }

    if(isset($_POST['edit'])) {
      if(isset($_FILES['gambar']['name']) && !empty($_FILES['gambar']['name'])) {
        // Gambar telah diunggah oleh pengguna
        $gambar = 'ada';
      } else {
          // Gambar tidak diunggah oleh pengguna
          $gambar = 'tidak ada';
      }
      $editBuku = $database->editBook($_POST,$gambar);
      if($editBuku === 'berhasil') {
        $_SESSION['notifikasiBerhasil'] = 'berhasil'; 
      } else if($editBuku === 'tipe') {
        $_SESSION['notifikasiBerhasil'] = 'tipe'; 
      }
      
      header("Location: tambah-buku-edit.php?id=" . $_GET['id']);
      exit;
    }
  
  } else {
    
    header("Location: list-buku-admin.php");
    exit;
  }

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
    <link rel="stylesheet" href="../style/profil.css" />
    <link rel="stylesheet" href="../style/tambah_gambar.css" />
    <title>Tambah Buku</title>
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
        <div class="col-lg-10 col-md-11">
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
          <div class="section-kanan-profil">
            <div class="bg-kanan-profil"></div>
            <div class="container">
              <div class="row">
                <form action="" method="post" enctype="multipart/form-data">

                  <div class="col-lg-8 offset-lg-2">
                    <div
                      class="kartu-kanan-profil"
                      style="height: 540px; overflow-y: scroll"
                    >
                      <div class="judul-profil text-center">
                        <p
                          style="
                            color: white;
                            background-color: #424787;
                            font-weight: 600;
                            border-radius: 30px;
                            padding: 0.5rem 1rem;
                          "
                        >
                          Tambah Buku
                        </p>
                      </div>
                      <?php if(isset($notifikasiBerhasil) && $notifikasiBerhasil === 'tipe') : ?>
                        <div class="alert alert-danger" role="alert">
                            Gagal menambahkan buku, gambar harus jpg/jpeg/png
                        </div>
                      <?php elseif(isset($notifikasiBerhasil) && $notifikasiBerhasil === 'berhasil'): ?>
                          <div class="alert alert-success" role="alert">
                              Berhasil Mengedit Buku
                          </div>
                      <?php endif; ?>    
                      <div class="row mt-5">
                        <div class="col-lg-5">
                          <div class="kartu-upload">
                            <img
                              style="margin: auto; display: flex"
                              src="../assets/icon-up.png"
                              alt=""
                            />
                            <input type="file" name="gambar"/>
                            <p class="text-center"><b>(Opsional)</b></p>
                          </div>
                        </div>
                        <div class="col-lg-7">
                          <div class="bungkus-input">
                            <p style="font-weight: 700; font-size: 1.2rem">
                              Judul Buku
                            </p>
                            <div
                              class="kanan-input"
                              style="
                                padding: 0.5rem 1rem;
                                background-color: white;
                                border-radius: 30px;
                              "
                            >
                              <input type="hidden" name="idBuku" value="<?php echo $ambilBuku['BukuID'] ?>">
                              <input type="text" required name="judul" value="<?php echo $ambilBuku['Judul'] ?>" />
                            </div>
                          </div>
                          <div class="bungkus-input">
                            <p
                              style="font-weight: 700; font-size: 1.2rem"
                              class="mt-3"
                            >
                              Penulis
                            </p>
                            <div
                              class="kanan-input"
                              style="
                                padding: 0.5rem 1rem;
                                background-color: white;
                                border-radius: 30px;
                              "
                            >
                              <input type="text" required name="penulis" value="<?php echo $ambilBuku['Penulis'] ?>"/>
                            </div>
                          </div>
                          <div class="bungkus-input">
                            <p
                              style="font-weight: 700; font-size: 1.2rem"
                              class="mt-3"
                            >
                              Penerbit
                            </p>
                            <div
                              class="kanan-input"
                              style="
                                padding: 0.5rem 1rem;
                                background-color: white;
                                border-radius: 30px;
                              "
                            >
                              <input type="text" required name="penerbit" value="<?php echo $ambilBuku['Penerbit'] ?>"/>
                            </div>
                          </div>
                          <div class="bungkus-input">
                            <p
                              style="font-weight: 700; font-size: 1.2rem"
                              class="mt-3"
                            >
                              Tahun Terbit
                            </p>
                            <div
                              class="kanan-input"
                              style="
                                padding: 0.5rem 1rem;
                                background-color: white;
                                border-radius: 30px;
                              "
                            >
                              <input type="number" required name="tahun" value="<?php echo $ambilBuku['TahunTerbit'] ?>"/>
                            </div>
                          </div>
                          <div class="bungkus-input mt-4">
                            <p style="font-weight: 700; font-size: 1.2rem">
                              Kategori Buku
                            </p>
                            <div class="bungkus-pilih d-flex" style="gap: 1rem">
                              <div class="pilih">
                              <input type="radio" id="jenis1" name="kategori"
                              <?php if($ambilBuku['KategoriID'] === "1") : ?>
                              checked
                              <?php endif; ?>
                               value="1">
                              <label for="jenis1">Manga</label><br>
                              <input type="radio" id="jenis2" name="kategori" 
                              <?php if($ambilBuku['KategoriID'] === "2") : ?>
                              checked
                              <?php endif; ?>
                              value="2">
                              <label for="jenis2">Novel</label><br>
                              <input type="radio" id="jenis3" name="kategori" 
                              <?php if($ambilBuku['KategoriID'] === "3") : ?>
                              checked
                              <?php endif; ?>
                              value="3">
                              <label for="jenis3">Pendidikan</label><br>
                              </div>
                            </div>
                            <button type="submit" name="edit" class="mt-3" style="border:none; padding: 7px; 20px; background-color:#424787; color:white; border-radius:10px;">Tambah Buku</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
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
