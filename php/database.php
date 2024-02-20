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

    public function register($data)
    {
        $username = $data['username'];
        $password = $data['password'];
        $email = $data['email'];
        $nama = $data['nama'];
        $alamat = $data['alamat'];

        $cekUsername = "SELECT * from user where username = '$username'";
        $result = $this->conn->query($cekUsername);
        if($result->num_rows > 0) {
            return 'username';
        }
        $cekEmail = "SELECT * from user where email = '$email'";
        $result = $this->conn->query($cekEmail);
        if($result->num_rows > 0) {
            return 'email';
        }
        $sql = "INSERT INTO user (Username,Password,Email,NamaLengkap,Alamat)
        values ('$username', '$password', '$email', '$nama', '$alamat')";
        
        $result = $this->conn->query($sql);
        echo "<script>alert('Pendaftaran akun berhasil');</script>";
        return 'berhasil';

    }

    public function login($data) {
        $username = $data['username'];
        $password = $data['password'];

        $cekUsername = "SELECT * from user where username = '$username' and password = '$password'";
        $result = $this->conn->query($cekUsername);
        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $_SESSION['id'] = $data['id'];
            return 'berhasil'; 
        }
        return 'gagal'; 

    }
}
