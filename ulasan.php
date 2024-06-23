<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["pengguna"])) {
    echo "<script> alert('Anda belum login');</script>";
    echo "<script> location ='login.php';</script>";
}
?>

<?php include 'header.php'; ?>
<div class="container-fluid page-header py-6 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center pt-5 pb-3">
        <h1 class="display-4 text-white animated slideInDown mb-3">Ulasan</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Ulasan</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-xxl py-6">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <p class="text-primary text-uppercase mb-2">Ulasan</p>
            <h1 class="display-6 mb-4">Ulasan</h1>
        </div>
        <div class="row g-0 justify-content-center">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                <table class="table">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No.</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Ulasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        <?php $ambil = $koneksi->query("SELECT * FROM penjualan WHERE idpenjualan='$_GET[id]'") or die(mysqli_error($koneksi)); ?>
                        <?php while ($datahasil = $ambil->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td><?php echo $datahasil['nama']; ?></td>
                                <td>Rp. <?php echo number_format($datahasil['harga']); ?></td>
                                <td><?php echo $datahasil['jumlah']; ?></td>
                                <td>Rp. <?php echo number_format($datahasil['subharga']); ?></td>
                                <td>
                                    <?php if ($datahasil['statusulasan'] == "Sudah") { ?>
                                        <a data-bs-toggle="modal" data-bs-target="#editulasan<?= $nomor ?>" class="btn btn-warning text-white">Edit Ulasan</a>
                                    <?php } else { ?>
                                        <a data-bs-toggle="modal" data-bs-target="#exampleModal<?= $nomor ?>" class="btn btn-success text-white">Berikan Ulasan Produk Ini</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php $nomor++; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $no = 1;
$id = $_SESSION["pengguna"]['id'];
$ambil = $koneksi->query("SELECT * FROM penjualan WHERE idpenjualan='$_GET[id]'") or die(mysqli_error($koneksi));
while ($datahasil = $ambil->fetch_assoc()) { ?>
    <div class="modal fade" id="exampleModal<?= $no ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?= $no ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel<?= $no ?>">Berikan Ulasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="idproduk" value="<?= $datahasil['idproduk'] ?>">
                            <input type="hidden" name="idpelanggan" value="<?= $id ?>">
                            <input type="hidden" name="idpenjualan" value="<?= $datahasil['idpenjualan'] ?>">
                            <label for="kritik">Rating</label> <br>
                            <div class="bintang" id="bintang1<?= $no ?>">
                                <input type="radio" id="star5<?= $no ?>" name="bintang" value="5" required />
                                <label for="star5<?= $no ?>" title="text">5 Bintang</label>
                                <input type="radio" id="star4<?= $no ?>" name="bintang" value="4" required />
                                <label for="star4<?= $no ?>" title="text">4 Bintang</label>
                                <input type="radio" id="star3<?= $no ?>" name="bintang" value="3" required />
                                <label for="star3<?= $no ?>" title="text">3 Bintang</label>
                                <input type="radio" id="star2<?= $no ?>" name="bintang" value="2" required />
                                <label for="star2<?= $no ?>" title="text">2 Bintang</label>
                                <input type="radio" id="star1<?= $no ?>" name="bintang" value="1" required />
                                <label for="star1<?= $no ?>" title="text">1 Bintang</label>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label for="ulasan" class="mb-2">Ulasan</label>
                            <textarea class="form-control mb-2" name="ulasan" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ulasan" class="mb-2">Foto</label>
                            <input type="file" class="form-control mb-2" name="foto" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-2 mt-2">Tampilkan Nama Ulasan</label>
                            <select name="tampilannama" class="form-control" required>
                                <option value="Tampilkan Nama">Tampilkan Nama</option>
                                <option value="Anonim">Anonim</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="simpan" value="simpan" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if ($datahasil['statusulasan'] == "Sudah") { ?>
        <div class="modal fade" id="editulasan<?= $no ?>" tabindex="-1" aria-labelledby="editulasanLabel<?= $no ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editulasanLabel<?= $no ?>">Edit Ulasan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php
                            $ambilulasan = $koneksi->query("SELECT * FROM ulasan WHERE idpenjualan='$datahasil[idpenjualan]' and idproduk='$datahasil[idproduk]'");
                            $ulasan = $ambilulasan->fetch_assoc();
                            ?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="idulasan" value="<?= $ulasan['idulasan'] ?>">
                                <input type="hidden" name="idproduk" value="<?= $datahasil['idproduk'] ?>">
                                <input type="hidden" name="idpelanggan" value="<?= $id ?>">
                                <input type="hidden" name="idpenjualan" value="<?= $datahasil['idpenjualan'] ?>">
                                <label for="kritik">Rating</label><br>
                                <div class="bintang" id="bintang2<?= $no ?>">
                                    <input <?php if ($ulasan['bintang'] == '5') echo 'checked'; ?> type="radio" id="stara<?= $no ?>" name="rate" value="5" required />
                                    <label for="stara<?= $no ?>" title="text">5 Bintang</label>
                                    <input <?php if ($ulasan['bintang'] == '4') echo 'checked'; ?> type="radio" id="starb<?= $no ?>" name="rate" value="4" required />
                                    <label for="starb<?= $no ?>" title="text">4 Bintang</label>
                                    <input <?php if ($ulasan['bintang'] == '3') echo 'checked'; ?> type="radio" id="starc<?= $no ?>" name="rate" value="3" required />
                                    <label for="starc<?= $no ?>" title="text">3 Bintang</label>
                                    <input <?php if ($ulasan['bintang'] == '2') echo 'checked'; ?> type="radio" id="stard<?= $no ?>" name="rate" value="2" required />
                                    <label for="stard<?= $no ?>" title="text">2 Bintang</label>
                                    <input <?php if ($ulasan['bintang'] == '1') echo 'checked'; ?>type="radio" id="stare<?= $no ?>" name="rate" value="1" required />
                                    <label for="stare<?= $no ?>" title="text">1 Bintang</label>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label for="ulasan">Ulasan</label>
                                <textarea class="form-control" name="ulasan" rows="3" required><?= $ulasan['ulasan'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="ulasan">Foto</label>
                                <input type="file" class="form-control" name="foto">
                                <input type="hidden" class="form-control" name="fotolama" value="<?= $ulasan['foto'] ?>" required>
                            </div>
                            <?php if ($ulasan['foto'] != "") { ?>
                                <img src="foto/<?= $ulasan['foto'] ?>" width="100%">
                                <br>
                            <?php } ?>
                            <div class="form-group">
                                <label>Tampilkan Nama Ulasan</label>
                                <select name="tampilannama" class="form-control" required>
                                    <option <?php if ($ulasan['tampilannama'] == 'Tampilkan Nama') echo 'selected'; ?> value="Tampilkan Nama">Tampilkan Nama</option>
                                    <option <?php if ($ulasan['tampilannama'] == 'Anonim') echo 'selected'; ?> value="Anonim">Anonim</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" name="edit" value="edit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php $no++; ?>
<?php  } ?>
<?php
if (isset($_POST["simpan"])) {
    $idproduk = $_POST['idproduk'];
    $idpelanggan = $_POST['idpelanggan'];
    $bintang = $_POST['bintang'];
    $ulasan = $_POST['ulasan'];
    $tampilannama = $_POST['tampilannama'];
    $idpenjualan = $_POST['idpenjualan'];
    $namafoto = $_FILES['foto']['name'];
    $lokasifoto = $_FILES['foto']['tmp_name'];
    if (!empty($lokasifoto)) {
        move_uploaded_file($lokasifoto, "foto/$namafoto");
        $foto = $namafoto;
    } else {
        $foto = "";
    }
    $koneksi->query("INSERT INTO ulasan	(idproduk, idpenjualan, idpengguna,  bintang, ulasan, tampilannama,foto)
								VALUES('$idproduk','$idpenjualan','$idpelanggan','$bintang','$ulasan', '$tampilannama','$foto')") or die(mysqli_error($koneksi));
    $koneksi->query("UPDATE penjualan SET statusulasan='Sudah' WHERE idpenjualan='$idpenjualan' and idproduk='$idproduk'") or die(mysqli_error($koneksi));
    echo "<script>alert('Ulasan Berhasil Di Kirim')</script>";
    echo "<script>location='ulasan.php?id=$_GET[id]';</script>";
}
if (isset($_POST["edit"])) {
    $idulasan = $_POST['idulasan'];
    $idproduk = $_POST['idproduk'];
    $idpelanggan = $_POST['idpelanggan'];
    $rate = $_POST['rate'];
    $ulasan = $_POST['ulasan'];
    $tampilannama = $_POST['tampilannama'];
    $idpenjualan = $_POST['idpenjualan'];
    $namafoto = $_FILES['foto']['name'];
    $lokasifoto = $_FILES['foto']['tmp_name'];
    if (!empty($lokasifoto)) {
        move_uploaded_file($lokasifoto, "foto/$namafoto");
        $foto = $namafoto;
    } else {
        $foto = $_POST['fotolama'];
    }
    $koneksi->query("UPDATE ulasan SET bintang='$rate', ulasan='$ulasan', tampilannama='$tampilannama' WHERE idulasan='$idulasan'") or die(mysqli_error($koneksi));
    echo "<script>alert('Ulasan Berhasil Di Diedit')</script>";
    echo "<script>location='ulasan.php?id=$_GET[id]';</script>";
}
?>
<div style="padding-top:250px"></div>
<?php
include 'footer.php';
?>