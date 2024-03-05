<?php
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "perpustakaan";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }

    public function closeConnection()
    {
        $this->conn->close();
    }

    public function listBook() {
        $sql = "SELECT * FROM peminjaman p, user u, buku b where p.UserID = u.userID and p.BukuID = b.BukuID";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }

    public function listPeminjamanUser() {
        $idUser = intval($_SESSION['id']);
        $sql = "SELECT * FROM peminjaman p, user u, buku b where p.UserID = u.userID and p.BukuID = b.BukuID and p.UserID = '$idUser' and p.StatusPeminjaman = 'Dipinjam'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }

    public function listBookUser() {
        $sql = "SELECT * FROM buku";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }

    public function listBookAdmin() {
        $sql = "SELECT * FROM buku b, kategoribuku kb, kategoribuku_relasi kbr where b.BukuID = kbr.BukuID and kbr.KategoriID = kb.KategoriID";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }

    public function searchBook($isi) {
        $sql = "SELECT * FROM buku where judul LIKE '%$isi%'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }

    public function hapusPeminjaman($id) {
        $cekData = "SELECT * FROM peminjaman where PeminjamanID = '$id'"; 
        $result = $this->conn->query($cekData);
        if ($result->num_rows > 0) {
            $sql = "DELETE FROM peminjaman where PeminjamanID = '$id'"; 
            $result = $this->conn->query($sql);
            if($result) {
                return 'berhasil';

            } else {
                return 'gagal';
            }
        } else {
            return 'gagal';
        }
    }

    public function deleteBook($id) {
        $cekData = "SELECT * FROM buku where BukuID = '$id'"; 
        $result = $this->conn->query($cekData);
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            unlink($data['gambar']);
            $sql = "DELETE FROM koleksipribadi where BukuID = '$id'"; 
            $result = $this->conn->query($sql);
            $sql = "DELETE FROM peminjaman where BukuID = '$id'"; 
            $result = $this->conn->query($sql);
            $sql = "DELETE FROM kategoribuku_relasi where BukuID = '$id'"; 
            $result = $this->conn->query($sql);
            $sql = "DELETE FROM buku where BukuID = '$id'"; 
            $result = $this->conn->query($sql);
            if($result) {
                return 'berhasil';

            } else {
                return 'gagal';
            }
        } else {
            return 'gagal';
        }
    }

    public function listCategories() {
        $sql = "SELECT * FROM kategoribuku";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }

    public function searchCategories($id) {
        $sql = "SELECT * FROM buku b, kategoribuku_relasi kb where b.BukuID = kb.BukuID and kb.KategoriID = '$id'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }

    public function addBook($data) {
        $judul = $data['judul'];
        $penulis = $data['penulis'];
        $penerbit = $data['penerbit'];
        $tahun = $data['tahun'];
        $kategori = intval($data['kategori']);
        $file_name = $_FILES['gambar']['name'];
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $file_type = $_FILES['gambar']['type'];
    
        // Mendapatkan ekstensi file
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
        // Array ekstensi yang diizinkan
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'jfif');
    
        // Cek apakah ekstensi file diizinkan
        if(in_array($file_extension, $allowed_extensions)) {
            // Mendapatkan timestamp saat ini
            $timestamp = date('YmdHis');
    
            // Menggabungkan timestamp dengan nama file asli
            $new_file_name = $timestamp . '_' . $file_name;
    
            $file_destination = '../upload_foto/' . $new_file_name; // Ganti 'folder_tujuan/' dengan path folder tujuan Anda
    
            // Pindahkan file yang diunggah ke folder tujuan
            if(move_uploaded_file($file_tmp, $file_destination)) {
                $sql = "INSERT into buku (judul,penulis,penerbit,TahunTerbit,gambar) values ('$judul','$penulis','$penerbit','$tahun','$file_destination')";
                $result = $this->conn->query($sql);
                $sql = "SELECT BukuID from buku where gambar = '$file_destination'";
                $result = $this->conn->query($sql);
                $data = $result->fetch_assoc();
                $bukuID = $data['BukuID'];
                $sql = "INSERT into kategoribuku_relasi (BukuID,KategoriID) values ('$bukuID','$kategori')";
                $result = $this->conn->query($sql);
                return 'berhasil';
            } 
        } else {
            return 'tipe';
        }
    }

    public function editBook($data, $gambar) {
        $idBuku = $data['idBuku'];
        $judul = $data['judul'];
        $penulis = $data['penulis'];
        $penerbit = $data['penerbit'];
        $tahun = $data['tahun'];
        $kategori = intval($data['kategori']);

        if($gambar === 'ada') {
            $sql = "SELECT gambar from buku where BukuID = '$idBuku'";
            $result = $this->conn->query($sql);
            $data = $result->fetch_assoc();
            $bukuGambar = $data['gambar'];
            unlink($bukuGambar);

            
        $file_name = $_FILES['gambar']['name'];
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $file_type = $_FILES['gambar']['type'];
    
        // Mendapatkan ekstensi file
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
        // Array ekstensi yang diizinkan
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'jfif');
    
        // Cek apakah ekstensi file diizinkan
        if(in_array($file_extension, $allowed_extensions)) {
            // Mendapatkan timestamp saat ini
            $timestamp = date('YmdHis');
    
            // Menggabungkan timestamp dengan nama file asli
            $new_file_name = $timestamp . '_' . $file_name;
    
            $file_destination = '../upload_foto/' . $new_file_name; // Ganti 'folder_tujuan/' dengan path folder tujuan Anda
    
            // Pindahkan file yang diunggah ke folder tujuan
            if(move_uploaded_file($file_tmp, $file_destination)) {
                $sql = "UPDATE buku set judul = '$judul', penulis = '$penulis', penerbit = '$penerbit', TahunTerbit = '$tahun', gambar = '$file_destination' where BukuID = '$idBuku'";
                $result = $this->conn->query($sql);
                $sql = "UPDATE kategoribuku_relasi set KategoriID = '$kategori' where BukuID = '$idBuku'";
                $result = $this->conn->query($sql);
                return 'berhasil';
            } 
        } else {
            return 'tipe';
        }
    } else {
            $sql = "UPDATE buku set judul = '$judul', penulis = '$penulis', penerbit = '$penerbit', TahunTerbit = '$tahun' where BukuID = '$idBuku'";
            $result = $this->conn->query($sql);
            $sql = "UPDATE kategoribuku_relasi set KategoriID = '$kategori' where BukuID = '$idBuku'";
            $result = $this->conn->query($sql);
            return 'berhasil';
    }
}


    public function imageBook($id) {
        $sql = "SELECT gambar from buku where BukuID = '$id'";
        $result = $this->conn->query($sql);
        $data = $result->fetch_assoc();
        return $data['gambar'];
    }

    public function getBook($id) {
        $sql = "SELECT * FROM buku b, kategoribuku kb, kategoribuku_relasi kbr where b.BukuID = kbr.BukuID and kbr.KategoriID = kb.KategoriID and b.BukuID = '$id'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return 'gagal';
        }
    }

    public function detailBook($id) {
        $sql = "SELECT * FROM buku b, kategoribuku kb, kategoribuku_relasi kbr where b.BukuID = kbr.BukuID and kbr.KategoriID = kb.KategoriID and b.BukuID = '$id'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return 'gagal';
        }
    }

    public function ulasanBook($id) {
        $sql = "SELECT * FROM ulasanbuku ub, user u where ub.UserID = u.userID and BukuID = '$id'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }

    public function checkBook($idUser,$idBuku) {
        $sql = "SELECT * from peminjaman where BukuID = '$idBuku' and StatusPeminjaman = 'Dipinjam'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return 'true';
        } else {
            return 'false';
        }
    }
    public function checkCollection($idUser,$idBuku) {
        $sql = "SELECT * from koleksipribadi where UserID = '$idUser' and BukuID = '$idBuku'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function addBorrow($data) {
        $idUser = $data['idUser'];
        $idBuku = $data['idBuku'];
        $tanggalPeminjaman = $data['tanggalPeminjaman'];
        $tanggalPengembalian = $data['tanggalPengembalian'];
        $status = "Dipinjam";
        $sql = "INSERT INTO peminjaman (UserID, BukuID, TanggalPeminjaman, TanggalPengembalian, StatusPeminjaman) values ('$idUser','$idBuku','$tanggalPeminjaman', '$tanggalPengembalian', '$status')";
        $result = $this->conn->query($sql);
        if($result) {
            return 'berhasil';
        } else {
            return 'gagal';

        }
    }

    public function addCollection($data) {
        $idUser = $data['idUser'];
        $idBuku = $data['idBuku'];
        $sql = "INSERT INTO koleksipribadi (UserID, BukuID) values ('$idUser','$idBuku')";
        $result = $this->conn->query($sql);
        if($result) {
            return 'berhasil';
        } else {
            return 'gagal';

        }
    }

    public function addComment($data) {
        $idUser = intval($_SESSION['id']);
        $idBuku = intval($data['idBuku']);
        $rating = $data['rating'];
        $ulasan = $data['ulasan'];

        $sql = "INSERT INTO ulasanbuku (UserID, BukuID, rating, ulasan) values ('$idUser','$idBuku','$rating','$ulasan')";
        $result = $this->conn->query($sql);
        if($result) {
            return 'berhasil';
        } else {
            return 'gagal';

        }
    }
    
    public function listCollection($id) {
        $sql = "SELECT * FROM koleksipribadi kb, buku b where kb.BukuID = b.BukuID and kb.UserID = '$id'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }

    public function hapusKoleksi($id) {
        $sql = "DELETE FROM koleksipribadi where KoleksiID = '$id'";
        $result = $this->conn->query($sql);
        if($result) {
            return 'berhasil';
        } else {
            return 'gagal';

        }
    }

    public function kembalikanPeminjaman($id) {
        $idUser = intval($_SESSION['id']);
        $sql = "UPDATE peminjaman set StatusPeminjaman = 'Dikembalikan' where PeminjamanID = '$id' and UserID = '$idUser'";
        $result = $this->conn->query($sql);
        if($result) {
            return 'berhasil';
        } else {
            return 'gagal';

        }
    }
}
