<?php 
session_start();

require_once '../php/buku.php';

$database = new Database();

if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
} else {
  if(isset($_GET['id'])) {
    $detailBuku = $database->detailBook(intval($_GET['id']));
    
    $gambarBuku = $database->imageBook(intval($_GET['id']));
    if($detailBuku === 'gagal') {
      header("Location: list-buku.php");
      exit;
    }
    $ulasanBuku = $database->ulasanBook(intval($_GET['id']));
    $cekPinjamBuku = $database->checkBook(intval($_SESSION['id']),intval($_GET['id']));
    $cekKoleksiBuku = $database->checkCollection(intval($_SESSION['id']),intval($_GET['id']));

    if(isset($_POST['pinjam'])) {
      $tambahPeminjaman = $database->addBorrow($_POST);
      if($tambahPeminjaman === 'berhasil') {
        $_SESSION['notifikasiBerhasil'] = 'berhasil'; 
      } else if($tambahPeminjaman === 'gagal') {
        $_SESSION['notifikasiBerhasil'] = 'gagal'; 
      }

      header("Location: detail-buku.php?id=" . $_GET['id']);
      exit;
    }

    if(isset($_POST['tambahKoleksi'])) {
      $tambahKoleksi = $database->addCollection($_POST);
      if($tambahKoleksi === 'berhasil') {
        $_SESSION['notifikasiBerhasil'] = 'berhasil koleksi'; 
      } else if($tambahKoleksi === 'gagal') {
        $_SESSION['notifikasiBerhasil'] = 'gagal koleksi'; 
      }

      header("Location: detail-buku.php?id=" . $_GET['id']);
      exit;
    }
  } else {
    header("Location: list-buku.php");
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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="../style/detail_buku.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Detail buku</title>
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Form Peminjaman</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="idBuku" value="<?php echo $_GET['id'] ?>">
                    <input type="hidden" name="idUser" value="<?php echo $_SESSION['id'] ?>">
                    <div class="mb-3">
                        <label for="tanggalPeminjaman" class="form-label">Tanggal Peminjaman</label>
                        <input type="date" name="tanggalPeminjaman" class="form-control" id="tanggalPeminjaman" aria-describedby="emailHelp" value="<?= date('Y-m-d', strtotime('+7 hours')) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tanggalPengembalian" class="form-label">Tanggal Pengembalian</label>
                        <input type="date" name="tanggalPengembalian" class="form-control" id="tanggalPengembalian" min="" onchange="setMinDate()">
                    </div>
                    <button type="submit" class="btn btn-primary" name="pinjam">Pinjam Buku</button>
                </form>

                <script>
                    // Fungsi untuk mengatur nilai minimal tanggal pengembalian sesuai dengan tanggal peminjaman
                    function setMinDate() {
                        var tanggalPeminjaman = new Date(document.getElementById('tanggalPeminjaman').value);
                        document.getElementById('tanggalPengembalian').min = tanggalPeminjaman.toISOString().split('T')[0];
                    }

                    // Set nilai minimal tanggal pengembalian saat ini
                    setMinDate();
                </script>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="kembali mt-5">
        <a href="list-buku.php"><i class="fa-solid fa-angle-left me-3"></i>Kembali</a>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <div
                    class="gambar-detail"
                    style="
              width: 450px;
              height: 500px;
              background-image: url('<?php  echo $gambarBuku ?>');
              background-position: center;
              background-size: cover;
            "
            ></div>
        </div>
        <div class="col-lg-7 pb-4">
            <h1 style="font-weight: 700"><?php echo $detailBuku['Judul'] ?></h1>
            <?php if(isset($notifikasiBerhasil) && $notifikasiBerhasil === 'gagal') : ?>
                <div class="alert alert-danger" role="alert">
                    Gagal meminjam buku
                </div>
            <?php elseif(isset($notifikasiBerhasil) && $notifikasiBerhasil === 'gagal koleksi') : ?>
                <div class="alert alert-danger" role="alert">
                    Gagal Ditambahkan di koleksi pribadi
                </div>
            <?php elseif(isset($notifikasiBerhasil) && $notifikasiBerhasil === 'berhasil'): ?>
                <div class="alert alert-success" role="alert">
                    Berhasil Meminjam Buku
                </div>
            <?php elseif(isset($notifikasiBerhasil) && $notifikasiBerhasil === 'berhasil koleksi'): ?>
                <div class="alert alert-success" role="alert">
                    Berhasil Ditambahkan di koleksi pribadi
                </div>
            <?php endif; ?>
            <div class="des-kanan d-flex gap-3">
                <p>Penulis : <?php echo $detailBuku['Penulis'] ?></p>
                <p>Penerbit : <?php echo $detailBuku['Penerbit'] ?></p>
                <p>Kategori : <?php echo $detailBuku['NamaKategori'] ?></p>
            </div>
            <div class="des-kanan d-flex gap-5">
                <p
                        style="
                padding: 0.3rem 1rem;
                border-radius: 30px;
                background-color: #424787;
                color: white;
                font-weight: 600;
                width: 150px;
                text-align: center;
              "
                >
                    Novel
                </p>
                <p class="ms-2">Tahun Terbit : <?php echo $detailBuku['TahunTerbit'] ?></p>
            </div>
            <p style="font-weight: 700">Ulasan & rating buku :</p>
            <div class="mb-4">
                <a href="ulasan.php?id=<?php echo $_GET['id'] ?>" style="text-decoration:none; padding : 7px 20px; border-radius:25px; background-color:#00b56a; color:white;">Berikan Ulasan</a>
            </div>
            <div class="bungkus-kartu-ulasan">
                <?php if($ulasanBuku === []) :?>
                    <p>Belum ada ulasan</p>
                <?php else :?>
                    <?php foreach ($ulasanBuku as $data) : ?>
                        <div class="pb-4 pt-4">
                            <div class="kartu-ulasan">
                                <h6 style="font-weight: 700"><?php echo $data['NamaLengkap'] ?></h6>
                                <div class="rating">
                                    <p>
                                        <img src="../assets/icon-star.png" class="me-1" alt="" /><?php echo $data['Rating'] ?>
                                    </p>
                                </div>
                                <p style="font-size: 14px" class="mt-2">
                                    <?php echo $data['Ulasan'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif;?>
            </div>
            <?php if($_SESSION['user'] === 'user') : ?>
                <div class="pinjam mt-4 d-flex">
                    <?php if($cekPinjamBuku === 'false') : ?>
                        <button class="me-4 mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Pinjam buku</button>
                    <?php else : ?>
                        <button style="background-color:#c4c4c4; color:black;" class="me-4 mb-4">Sudah Meminjam</button>
                    <?php endif; ?>
                    <?php if($cekKoleksiBuku === 'false') : ?>
                        <form action="" method="post">
                            <input type="hidden" name="idBuku" value="<?php echo $_GET['id'] ?>">
                            <input type="hidden" name="idUser" value="<?php echo $_SESSION['id'] ?>">
                            <button class="me-4 mb-4" style="background-color:#00afdb;" type="submit" name="tambahKoleksi">Masukkan ke koleksi</button>
                        </form>
                    <?php else : ?>
                        <button style="background-color:#c4c4c4; color:black;" class="me-4 mb-4">Sudah Memasukkan ke koleksi</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
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
