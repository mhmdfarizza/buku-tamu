<?php
require_once('function.php');
include_once('templates/header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Buku Tamu</h1>
<?php
function tambah_tamu($data)
{
    global $koneksi; // Mengambil variabel $koneksi dari luar fungsi

    // Mengambil data dari form dan mencegah XSS dengan htmlspecialchars
    $kode        = htmlspecialchars($data["id_tamu"]);
    $tanggal     = date("Y-m-d");
    $nama_tamu   = htmlspecialchars($data["nama_tamu"]);
    $alamat      = htmlspecialchars($data["alamat"]);
    $no_hp       = htmlspecialchars($data["no_hp"]);
    $bertemu     = htmlspecialchars($data["bertemu"]);
    $kepentingan = htmlspecialchars($data["kepentingan"]);

    // Query untuk menyimpan ke tabel buku_tamu
    $query = "INSERT INTO buku_tamu VALUES ('$kode','$tanggal','$nama_tamu','$alamat','$no_hp', '$bertemu','$kepentingan')";

    mysqli_query($koneksi, $query);

    // Mengembalikan angka > 0 jika ada baris yang berhasil ditambahkan ke database
    return mysqli_affected_rows($koneksi);
}
?>
    <?php
    // Logika simpan diletakkan di atas agar Alert muncul langsung di halaman utama
    if (isset($_POST['simpan'])) {
        if (tambah_tamu($_POST) > 0) {
            echo '<div class="alert alert-success" role="alert">Data berhasil disimpan!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Data gagal disimpan!</div>';
        }
    }

    // Logika pembuatan ID Otomatis
    $query_max = mysqli_query($koneksi, "SELECT max(id_tamu) as kodeTerbesar FROM buku_tamu");
    $data_max  = mysqli_fetch_array($query_max);
    $kodeTamu  = $data_max['kodeTerbesar'];

    $urutan = (int) substr($kodeTamu, 2, 3);
    $urutan++;

    $huruf = "zt";
    $kodeTamuBaru = $huruf . sprintf("%03s", $urutan);
    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                + Tambah
            </button>
        </div>
        
        <!-- Modal (Struktur dirapikan) -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Tamu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Form dipindah agar membungkus body dan footer modal -->
                    <form method="post" action="">
                        <div class="modal-body">
                            <input type="hidden" name="id_tamu" id="id_tamu" value="<?= $kodeTamuBaru ?>">

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
                        // PERBAIKAN: Menggunakan fungsi bawaan mysqli dan fetch array (while loop)
                        $buku_tamu = mysqli_query($koneksi, "SELECT * FROM buku_tamu");
                        
                        // Cek apakah query berhasil mengembalikan data
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
                                <button class="btn btn-success" type="button">Ubah</button> 
                                <button class="btn btn-danger" type="button">Hapus</button>
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