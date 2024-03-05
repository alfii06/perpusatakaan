<?php 
session_start();

require_once '../php/buku.php';

$database = new Database();

if(!isset($_SESSION['id']) || $_SESSION['user'] === 'user') {
    header("Location: login.php");
    exit;
} else {
    $listbuku = $database->listBookAdmin();
    $data = $listbuku;

    // Filter for reading status
    $readingStatusFilter = isset($_GET['status']) ? $_GET['status'] : null;
    if ($readingStatusFilter !== null) {
        $data = $database->filterBooksByStatus($data, $readingStatusFilter);
    }

    if(isset($_GET['hapus'])) {
        $hapusBuku = $database->deleteBook(intval($_GET['hapus']));
        if($hapusBuku === 'berhasil') {
            $_SESSION['notifikasiBerhasil'] = 'berhasil'; 
        } else if($hapusBuku === 'gagal') {
            $_SESSION['notifikasiBerhasil'] = 'gagal'; 
        }
        
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="../style/list.css" />
    <title>List buku</title>
</head>
<body>
    <div class="section-list">
        <div class="row">
            <div class="col-lg-2 col-md-1 responsif-hp" style="background-color: #424787; height: 100vh">
                <img class="mt-3 ms-4 mb-1 logo1" src="../assets/logo-3.png" width="150" alt="" />
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
            <div class="col-lg-10 col-md-11 kanan-dasboard">
                <nav class="navbar navbar-expand-lg navbar-light pt-4" style="background-color: #424787">
                    <div class="container">
                        <a class="navbar-brand" href="#"><img src="../assets/logo-3.png" width="100" alt="" /></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="" style="border: none; cursor: pointer"><i class="fa-solid fa-bars" style="color: white"></i></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
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
                <div class="container">
                    <div class="judul text-center mt-5 mb-5"><h3>Daftar Buku</h3></div>
                    
                    <!-- Filter for reading status -->
                    <div class="mb-3">
                        <a href="?status=all" class="<?= ($readingStatusFilter === 'all' || $readingStatusFilter === null) ? 'active' : '' ?>">All</a>
                        <a href="?status=unread" class="<?= ($readingStatusFilter === 'unread') ? 'active' : '' ?>">Unread</a>
                        <a href="?status=read" class="<?= ($readingStatusFilter === 'read') ? 'active' : '' ?>">Read</a>
                    </div>
                        
                    <?php if(isset($notifikasiBerhasil) && $notifikasiBerhasil === 'gagal') : ?>
                        <div class="alert alert-danger" role="alert">
                            Gagal menghapus data buku
                        </div>
                    <?php elseif(isset($notifikasiBerhasil) && $notifikasiBerhasil === 'berhasil'): ?>
                        <div class="alert alert-success" role="alert">
                            Berhasil menghapus data buku
                        </div>
                    <?php endif; ?>    
                    <table id="table-to-print">
                        <thead>
                            <tr>
                                <th scope="col">Nomor</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Penulis</th>
                                <th scope="col">Penerbit</th>
                                <th scope="col">Tahun Terbit</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach($data as $row): ?>
                                <tr>
                                    <td data-label="Peminjaman ID"><?= $i?></td>
                                    <td data-label="User ID"><?= $row['Judul'] ?></td>
                                    <td data-label="Buku ID"><?= $row['Penulis'] ?></td>
                                    <td data-label="Tanggal Peminjaman"><?= $row['Penerbit'] ?></td>
                                    <td data-label="Tanggal Pengembalian"><?= $row['TahunTerbit'] ?></td>
                                    <td data-label="Tanggal Pengembalian"><?= $row['NamaKategori'] ?></td>
                                    <td data-label="Aksi">
                                        <a class="me-1" href="#" onclick="return confirmDelete(<?= $row['BukuID'] ?>)"><i class="fa-solid fa-trash" style="color:red;"></i></a> 
                                        <a class="me-1" href="tambah-buku-edit.php?id=<?= $row['BukuID'] ?>"><i class="fa-solid fa-edit" style="color:green;"></i></a> 
                                        <a class="me-1" href="detail-buku.php?id=<?= $row['BukuID'] ?>"><i class="fa-solid fa-eye" style="color:blue;"></i></a>
                                    </td>
                                </tr>
                                <?php $i += 1; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(id) {
            if (confirm("Apakah Anda yakin ingin menghapus buku ini?")) {
                // Jika pengguna menekan tombol OK, lanjutkan dengan penghapusan
                window.location.href = "list-buku-admin.php?hapus=" + id;
                return true;
            } else {
                // Jika pengguna menekan tombol Cancel, batalkan penghapusan
                return false;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
