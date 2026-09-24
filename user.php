<?php
require_once('function.php');
include_once('templates/header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Data User</h1>

    <?php
    // Logika simpan diletakkan di atas agar Alert muncul langsung di halaman utama
    if (isset($_POST['simpan'])) {
        if (tambah_user($_POST) > 0) {
            echo '<div class="alert alert-success" role="alert">Data berhasil disimpan!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Data gagal disimpan!</div>';
        }
    }

    // Logika Pembuatan ID Otomatis untuk User (Misal format: ur001, ur002, dst)
    // Jika id_user di database Anda diset Auto Increment, Anda bisa mengabaikan logika ini
    $query_max = mysqli_query($koneksi, "SELECT max(id_user) as kodeTerbesar FROM users");
    $data_max  = mysqli_fetch_array($query_max);
    $kodeUserDB = $data_max['kodeTerbesar'];

    $urutan = $kodeUserDB ? (int) substr($kodeUserDB, 2, 3) : 0;
    $urutan++;

    $huruf = "ur"; // Awalan ID User (bisa disesuaikan, misalnya 'us' atau 'ur')
    $kodeuser = $huruf . sprintf("%03s", $urutan);
    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                + Tambah user
            </button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <!-- Form diperbaiki, hanya 1 form yang membungkus body dan footer -->
                    <form method="post" action="">
                        <div class="modal-body">
                            <!-- Input Hidden untuk mengirim ID Otomatis -->
                            <input type="hidden" name="id_user" id="id_user" value="<?= $kodeuser ?>">
                            
                            <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="user_role" class="col-sm-3 col-form-label">User Role</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="user_role" name="user_role" required>
                                        <option value="admin">Administrator</option>
                                        <option value="operator">Operator</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>User Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $users = query("SELECT * FROM users");
                        foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['user_role'] ?></td>
                            <td>
                                <a class="btn btn-success btn-sm" href="edit-user.php?id=<?= $user['id_user'] ?>">Ubah</a>
                                <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm" href="hapus-user.php?id=<?= $user['id_user'] ?>">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php include_once('templates/footer.php'); ?>