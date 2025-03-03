# Simple Library untuk Tugas akhir sebelum UTS
Mwehoww, Kureichi here!
I've been created something new in this repo, its called, uhh simple library i think. in this readme, i'll show you how2use this shit library.

Bjir jijik cuk.

> [!IMPORTANT]
> Karena library ini hanya digunakan untuk mengerjakan tugas akhir, library ini tidak bisa tahan dengan serangan seperti sqlinjection dan semacamnya, harap modifikasi library ini jika digunakan untuk kebutuhan profesionalitas.
>

Ayo lanjut, Mari kita lihat contoh login.

## Login.

```
<?php
session_start();

//require "../connection/connection.php";
include $_SERVER['DOCUMENT_ROOT']."/dashboard/library/library.php";

$email = $_POST['email'];
$password = $_POST['password'];
$remember = $_POST['remember'];


$user = new User($email);

$check_user = $user->apakah_user_ada_di_database();


if ($check_user){
    $email = $user->ambil_email();
    $pass_user = $user->ambil_password();

    $check_pass = password_verify($password, $pass_user);
    if ($check_pass) {
        $_SESSION['email'] = $email;
        $_SESSION['remember'] = isset($remember)? true:false;
        $_SESSION['lock'] = false;
        
        header(header: 'Location: /dashboard/');
        die();
    } else {
        $_SESSION['info'] = 'Password salah, silahkan coba lagi.';
        header('Location: /dashboard/login/');
    }
} else {
    $_SESSION['info'] = 'Username atau password salah, silahkan coba lagi.';
    header('Location: /dashboard/login/');
    //echo '<script language = "javascript">
    //alert("Username atau Password salah, silahkan coba lagi."); document.location="index.php";</script>';
}

?>
```
- `$user` Seperti yang kita lihat, variable ini akan kita gunakan untuk membuat sebuah instance baru dari `class User`. namun dalam library, class User ini memiliki sebuah parameter tambahan yakni username/email pengguna yang harus bertipe `String`.
- `$check_user` Dalam variable ini, variable `$user` sebelumnya akan kita gunakan untuk menjalankan objek `apakah_user_ada_di_database()` yang mengembalikan `true` jika ada, dan `false` jika tidak ada.

## Sekarang apa?

Karena kita sudah melihat contoh cara penggunaannya, sekarang kita bisa harusnya sudah bisa membaca sendiri librarynya

Tenang aku akan memberi catatan sedikit.

### Bagaimana cara kita mengetahui suatu objek itu mengembalikan apa?
kita akan beri contoh dari suatu function di `class User`
```
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
```
Perhatikan pada sintaks terakhir, disitu ada dua `return` bukan? nah return itu berarti mengembalikan suatu nilai dan kemudian menghentikan seluruh operasi pada funtion.

Pada kondisi objek ini, jika tambah akun berhasil dijalankan tanpa kendala, maka objek ini akan mengembalikan `true`, sebaliknya jika tidak maka akan mengembalikan `false`.

btw niatnya aku ingin membuat dokumentasi lengkap soal ini, tapi sepertinya itu tidak perlu.

### Bagaimana cara mengetahui function itu membutuhkan parameter atau tidak?
Dalam library ku, ada function yang membutuhkan parameter, dan ada juga yang tidak membutuhkan parameter satupun.

bagaimana contoh yang menggunakan parameter? Contohnya seperti poin diatas, tapi ada juga yang lain seperti ini
```
function ubah_level($level) {
        $id = $this->ambil_id();
        $check = $GLOBALS['pdo']->prepare("UPDATE users SET level='$level' WHERE id=$id")->execute();
        if ($check) {
            return true;
        }
        return false;
    }
```
Kita lihat pada baris pertama, yaitu `ubah_level($level)`. dalam function tersebut memiliki sebuah variable yang ada didalam kurung `()` bernama `$level` bukan?, nah variable ini akan otomatis terisi disaat kita akan memanggil objek ini.

- Untuk memanggilnya kita harus melakukannya seperti ini.
```
$level_yg_kita_pengen = 'user';

$user->ubah_level($level_yg_kita_pengen);
```
Yang berarti, isi variable `$level_yg_kita_pengen` akan masuk kedalam variable `$level` yang ada didalam function `ubah_level($level)`.
*Ini diperbolehkan.*

- tapi jika kita hanya menulis seperti ini
```
//$level_yg_kita_pengen = 'user';

$user->ubah_level();
```
*Maka akan terjadi error.*


## Thatshit, hope you enjoy my lib.
Semoga uts lancar ygy.
