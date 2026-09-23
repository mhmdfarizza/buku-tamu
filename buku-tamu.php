<?php
require_once('function.php');
include_once('templates/header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Buku Tamu</h1>

    <?php
    // Logika simpan diletakkan di atas agar Alert muncul langsung di halaman utama
    if (isset($_POST['simpan'])) {
        if (tambah_tamu($_POST) > 0) {
            echo '<div class="alert alert-success" role="alert">Data berhasil disimpan!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Data gagal disimpan!</div>';
        }
    }
    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                + Tambah
            </button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Tamu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form method="post" action="">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="nama_tamu" class="col-sm-4 col-form-label">Nama Tamu</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama_tamu" name="nama_tamu" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="no_hp" class="col-sm-4 col-form-label">No. Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bertemu" class="col-sm-4 col-form-label">Bertemu dengan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="bertemu" name="bertemu" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="kepentingan" class="col-sm-4 col-form-label">Kepentingan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="kepentingan" name="kepentingan" required>
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
                            <th>Tanggal</th>
                            <th>Nama Tamu</th>
                            <th>Alamat</th>
                            <th>No. Telp/HP</th>
                            <th>Bertemu Dengan</th>
                            <th>Kepentingan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        // Query mengambil data terbaru (diurutkan berdasarkan id_tamu terbesar/terbaru)
                        $buku_tamu = mysqli_query($koneksi, "SELECT * FROM buku_tamu ORDER BY id_tamu DESC");
                        
                        if ($buku_tamu) {
                            while($tamu = mysqli_fetch_array($buku_tamu)) : 
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $tamu['tanggal'] ?></td>
                            <td><?= $tamu['nama_tamu'] ?></td>
                            <td><?= $tamu['alamat'] ?></td>
                            <td><?= $tamu['no_hp'] ?></td>
                            <td><?= $tamu['bertemu'] ?></td>
                            <td><?= $tamu['kepentingan'] ?></td>
                            <td>
                                <a class="btn btn-success btn-sm" href="edit-tamu.php?id=<?= $tamu['id_tamu']?>">Ubah</a> 
                                <button class="btn btn-danger btn-sm" type="button">Hapus</button>
                            </td>
                        </tr>
                        <?php 
                            endwhile; 
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php include_once('templates/footer.php'); ?>