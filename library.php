<?php
// Gk tau pak saya bikin ini buat ngemudahin aja.

$host = "localhost";
$user = "root";
$pass = "";

$database = 'assets-metik';

$connection_string = "mysql:host=$host;dbname=$database";

try {
    $pdo = new PDO(dsn: $connection_string, username: $user, password: $pass);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch (\Exception $e){
    die("Terjadi kesalahan : $e");
}


class User {
    public $user;

    function __construct($user){
        $this->user = $user;
    }

    // CRUD USER
    function apakah_user_ada_di_database(){
        $user = $GLOBALS['pdo']->query("SELECT * FROM users WHERE email='$this->user'")->fetch();

        if ($user) {
            return true;
        }
        return false;
    }

    function tambah_akun($password){
        if ($this->apakah_user_ada_di_database()) {
            return false;
        }

        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $user = $this->user;

        $check = $GLOBALS['pdo']->prepare("INSERT INTO users(email, password, level) VALUES ('$user', '$password_hashed', 'User')")->execute();

        if ($check) {
            return true;
        }
        return false;
    }

    function ambil_semua_item() {
        return $GLOBALS['pdo']->query("SELECT * FROM users")->fetchAll();
    }

    function ambil_data_user() {
        $data = $GLOBALS['pdo']->query("SELECT * FROM users WHERE email='$this->user'")->fetch();
        $obj = array("id" => $data['id'], "email" => $data['email'], "level" => $data['level'], "password" => $data['password']);
        return $obj;
    }

    function ambil_id(){
        $data = $this->ambil_data_user();
        return $data['id'];
    }

    function ambil_email() {
        $data = $this->ambil_data_user();
        return $data['email'];
    }

    function ambil_password() {
        $data = $this->ambil_data_user();
        return $data['password'];
    }

    function ambil_level() {
        $data = $this->ambil_data_user();
        return $data['level'];
    }

    function total_akun() {
        $data = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM users")->fetch();
        return $data[0];
    }

    function ubah_level($level) {
        $id = $this->ambil_id();
        $check = $GLOBALS['pdo']->prepare("UPDATE users SET level='$level' WHERE id=$id")->execute();
        if ($check) {
            return true;
        }
        return false;
    }

    function hapus_akun() {
        $id = $this->ambil_id();
        $check = $GLOBALS['pdo']->prepare("DELETE FROM users WHERE id=$id")->execute();

        if ($check) {
            return true;
        }
        return false;
    }
}


class Database {
    // CRUD ITEM YG ADA DI DATABASE
    function total_item() {
        return $GLOBALS['pdo']->query("SELECT COUNT(*) from asset")->fetch()[0];
    }

    function ambil_semua_item() {
        return $GLOBALS['pdo']->query("SELECT * from asset")->fetchAll();
    }

    function ambil_item_dari_id($id) {
        return $GLOBALS['pdo']->query("SELECT * FROM asset WHERE id = $id")->fetch();
    }

    function hapus_item_dari_id($id) {
        $check = $GLOBALS['pdo']->prepare("DELETE FROM asset WHERE id=$id")->execute();
        if ($check) {
            return true;
        }

        return false;
    }

    function tambah_item($nama_item, $kategori, $tanggal_pengadaan, $harga, $status){
        $query = "INSERT INTO asset(nama_asset, kategori, tanggal_pengadaan, harga, status) VALUES('$nama_item', '$kategori', '$tanggal_pengadaan', $harga, '$status')";

        $check = $GLOBALS['pdo']->prepare($query)->execute();
        if ($check) {
            return true;
        }

        return false;
    }

    function update_item_dari_id($id, $nama_item, $kategori, $tanggal_pengadaan, $harga, $status){
        $query = "UPDATE asset SET nama_asset='$nama_item', kategori='$kategori', tanggal_pengadaan='$tanggal_pengadaan', harga='$harga', status='$status' WHERE id=$id";
        
        $check = $GLOBALS['pdo']->prepare($query)->execute();
        if ($check) {
            return true;
        }

        return false;
    }
}


?>