<?php
// Koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "app_bukutamu"); 

// Fungsi untuk menambah data tamu baru
function tambah_tamu($data)
{
    global $koneksi;

    // Generate ID otomatis (contoh: zt001, zt002)
    $query_max = mysqli_query($koneksi, "SELECT max(id_tamu) as kodeTerbesar FROM buku_tamu");
    $data_max  = mysqli_fetch_array($query_max);
    $kodeTamu  = $data_max['kodeTerbesar'];

    $urutan = $kodeTamu ? (int) substr($kodeTamu, 2, 3) : 0;
    $urutan++;
    
    $huruf = "zt";
    $kode_baru = $huruf . sprintf("%03s", $urutan);

    // Persiapan data dari form
    $tanggal     = date("Y-m-d");
    $nama_tamu   = htmlspecialchars($data["nama_tamu"]);
    $alamat      = htmlspecialchars($data["alamat"]);
    $no_hp       = htmlspecialchars($data["no_hp"]);
    $bertemu     = htmlspecialchars($data["bertemu"]);
    $kepentingan = htmlspecialchars($data["kepentingan"]);

    // Proses simpan ke database
    $query = "INSERT INTO buku_tamu VALUES ('$kode_baru','$tanggal','$nama_tamu','$alamat','$no_hp', '$bertemu','$kepentingan')";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// Fungsi untuk mengubah data tamu
function ubah_tamu($data)
{
    global $koneksi;

    // Persiapan data dari form
    $id          = htmlspecialchars($data["id_tamu"]);
    $nama_tamu   = htmlspecialchars($data["nama_tamu"]);
    $alamat      = htmlspecialchars($data["alamat"]);
    $no_hp       = htmlspecialchars($data["no_hp"]);
    $bertemu     = htmlspecialchars($data["bertemu"]);
    $kepentingan = htmlspecialchars($data["kepentingan"]);

    // Proses update ke database
    $query = "UPDATE buku_tamu SET 
                nama_tamu    = '$nama_tamu',
                alamat       = '$alamat',
                no_hp        = '$no_hp',
                bertemu      = '$bertemu',
                kepentingan  = '$kepentingan'
              WHERE id_tamu = '$id'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// Fungsi untuk mempermudah pemanggilan query SELECT
function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_array($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// function hapus data tamu
function hapus_tamu($id) {
    global $koneksi;

    $query = "DELETE FROM buku_tamu WHERE id_tamu = '$id'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// PERBAIKAN: function tambah data user
function tambah_user($data){
    global $koneksi;

    // Generate ID otomatis (contoh: ur001, ur002)
    $query_max = mysqli_query($koneksi, "SELECT max(id_user) as kodeTerbesar FROM users");
    $data_max  = mysqli_fetch_array($query_max);
    $kodeUserDB = $data_max['kodeTerbesar'];

    $urutan = $kodeUserDB ? (int) substr($kodeUserDB, 2, 3) : 0;
    $urutan++;

    $huruf = "ur";
    $kode_baru = $huruf . sprintf("%03s", $urutan);

    // Ambil data dari form
    $username    = htmlspecialchars($data["username"]);
    $password    = htmlspecialchars($data["password"]);
    $user_role   = htmlspecialchars($data["user_role"]);

    // Enkripsi password dengan password_hash
    $password_hash = password_hash($password,PASSWORD_DEFAULT);

    // Proses simpan ke database menggunakan $kode_baru
    $query = "INSERT INTO users VALUES ('$kode_baru','$username','$password_hash','$user_role')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// function ubah data user
function ubah_user($data)
{
    global $koneksi;

    $kode       = htmlspecialchars($data["id_user"]);
    $username   = htmlspecialchars($data["username"]);
    $user_role  = htmlspecialchars($data["user_role"]);

    $query = "UPDATE users SET 
                username    = '$username',
                user_role   = '$user_role'
              WHERE id_user = '$kode'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// function hapus data user
function hapus_user($id) {
    global $koneksi;

    $query = "DELETE FROM users WHERE id_user = '$id'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// function ganti password user
function ganti_password($data) {
    global $koneksi;

    $kode          = htmlspecialchars($data["id_user"]);
    $password      = htmlspecialchars($data["password"]);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET 
                password    = '$password_hash'
              WHERE id_user = '$kode'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}
?>