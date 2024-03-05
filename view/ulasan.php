<?php 
session_start();

require_once '../php/buku.php';

$database = new Database();

if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
} else {
  if(isset($_GET['id'])) {
    $gambarBuku = $database->imageBook(intval($_GET['id']));

    if(isset($_POST['tambah-ulasan'])) {
      $tambahUlasan = $database->addComment($_POST);
      if($tambahUlasan === 'berhasil') {
        $_SESSION['notifikasiBerhasil'] = 'berhasil'; 
      } else if($tambahUlasan === 'gagal') {
        $_SESSION['notifikasiBerhasil'] = 'gagal'; 
      }

      header("Location: ulasan.php?id=" . $_GET['id']);
      exit;
    }
  } else {
    header("Location: login.php");
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
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../style/detail_buku.css" />
    <link rel="stylesheet" href="../style/ulasan.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <title>Detail buku</title>
  </head>
  <body>
    <div class="container">
      <div class="kembali mt-5">
        <a href="detail-buku.php?id=<?php echo $_GET['id'] ?>"><i class="fa-solid fa-angle-left me-3"></i>Kembali</a>
      </div>
      <div class="row">
        <div class="col-lg-5 mb-4">
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
        <div class="col-lg-5 offset-lg-1">
          <div class="kartu-kanan-ulasan">
            <form action="" method="post">
              <input type="hidden" name="idBuku" value="<?php echo $_GET['id'] ?>">
              <?php if(isset($notifikasiBerhasil) && $notifikasiBerhasil === 'gagal') : ?>
                        <div class="alert alert-danger" role="alert">
                            Gagal Menambahkan Ulasan
                        </div>
                      <?php elseif(isset($notifikasiBerhasil) && $notifikasiBerhasil === 'berhasil'): ?>
                          <div class="alert alert-success" role="alert">
                              Berhasil Menambahkan Ulasan
                          </div>
                      <?php endif; ?>    
              <h5 class="mt-4">Rating</h5>
              <div class="input-ulasan">
                <input type="number" min="1" max="5" name="rating" />
              </div>
              <h5 class="mt-4">Ulasan anda</h5>
  
              <textarea name="ulasan" id="" style="width: 100%;  padding:10px;" rows="7"></textarea>
              <div class="tombol text-end">
                <button class="mt-3" type="submit" name="tambah-ulasan">Kirim Ulasan</button>
              </div>

            </form>
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
