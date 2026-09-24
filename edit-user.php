<?php
require_once('function.php');
include_once('templates/header.php');

// Mengecek id dari URL dengan aman
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];
    
    // Memanggil data user berdasarkan ID
    $ambil_data = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_user'");
    
    if(mysqli_num_rows($ambil_data) > 0) {
        $data = mysqli_fetch_array($ambil_data);
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='user.php';</script>";
        exit;
    }
} else {
    header("Location: user.php");
    exit;
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Ubah Data User</h1>

    <?php
    // jika ada tombol simpan
    if (isset($_POST['simpan'])) {
        // Memanggil fungsi ubah_user
        if (ubah_user($_POST) > 0) {
            echo '<div class="alert alert-success" role="alert">Data berhasil diubah!</div>';
            echo "<meta http-equiv='refresh' content='1'>"; 
        } else {
            echo '<div class="alert alert-danger" role="alert">Data gagal diubah atau tidak ada perubahan!</div>';
        }
    }
    ?>

    <!-- Konten Edit Data User -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6>Data User</h6>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <!-- Menyimpan ID User -->
                <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
                
                <div class="form-group row">
                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-8">
                        <!-- Menampilkan Username lama -->
                        <input type="text" class="form-control" id="username" name="username" value="<?= $data['username'] ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user_role" class="col-sm-3 col-form-label">User Role</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="user_role" name="user_role" required>
                            <!-- Menyeleksi role lama secara otomatis -->
                            <option value="admin" <?= ($data['user_role'] == 'admin') ? 'selected' : '' ?>>Administrator</option>
                            <option value="operator" <?= ($data['user_role'] == 'operator') ? 'selected' : '' ?>>Operator</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-8 d-flex justify-content-end">
                        <div>
                            <a type="button" class="btn btn-danger btn-icon-split" href="user.php">
                                <span class="icon text-white-50">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                                <span class="text">Kembali</span>
                            </a>
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include_once('templates/footer.php');
?>