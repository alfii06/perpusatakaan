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
}
