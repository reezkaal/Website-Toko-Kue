<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["pengguna"])) {
    echo "<script> alert('Harap login terlebih dahulu');</script>";
    echo "<script> location ='login.php';</script>";
}
$id = $_SESSION["pengguna"]["id"];
?>
<?php
$id = $_SESSION["pengguna"]['id'];
$ambil = $koneksi->query("SELECT *FROM pengguna WHERE id='$id'");
$pecah = $ambil->fetch_assoc(); ?>
<?php include 'header.php'; ?>
<div class="container-fluid page-header py-6 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center pt-5 pb-3">
        <h1 class="display-4 text-white animated slideInDown mb-3">Akun</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Akun</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-xxl py-6">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <p class="text-primary text-uppercase mb-2">Profil Akun</p>
            <h1 class="display-6 mb-4">Profil Akun</h1>
        </div>
        <div class="row g-0 justify-content-center">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                <form method="post">
                    <div class="row g-3">
                        <div class="form-group">
                            <label class="mb-2">Nama</label>
                            <input value="<?php echo $pecah['nama']; ?>" type="text" value="" class="form-control mb-2" name="nama">
                        </div>
                        <div class="form-group">
                            <label class="mb-2">Email</label>
                            <input value="<?php echo $pecah['email']; ?>" type="email" class="form-control mb-2" name="email">
                        </div>
                        <div class="form-group">
                            <label class="mb-2">Telepon</label>
                            <input value="<?php echo $pecah['telepon']; ?>" type="number" class="form-control mb-2" name="telepon">
                        </div>
                        <div class="form-group">
                            <label class="mb-2">Alamat</label>
                            <textarea value="<?php echo $pecah['alamat']; ?>" class="form-control mb-2" name="alamat" id="alamat" rows="5"><?php echo $pecah['alamat']; ?></textarea>
                            <script>
                                CKEDITOR.replace('alamat');
                            </script>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Provinsi</label>
                                        <select class="form-control" value="<?php echo $pecah['nama_provinsi']; ?>" name="nama_provinsi">

                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Kota</label>
                                        <select class="form-control" value="<?php echo $pecah['nama_distrik']; ?>" name="nama_distrik">

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mb-2">Password</label>
                            <input type="text" class="form-control" name="password">
                            <input type="hidden" class="form-control" name="passwordlama" value="<?php echo $pecah['password']; ?>">
                            <span class="text-danger">Kosongkan Password jika tidak ingin mengganti</span>
                        </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-primary rounded-pill py-3 px-5 w-100" name="ubah" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['ubah'])) {
    if ($_POST['password'] == "") {
        $password = $_POST['passwordlama'];
    } else {
        $password = $_POST['password'];
    }

    $koneksi->query("UPDATE pengguna SET password='$password',nama='$_POST[nama]', email='$_POST[email]',telepon='$_POST[telepon]', alamat='$_POST[alamat]' WHERE id='$id'") or die(mysqli_error($koneksi));
    echo "<script>alert('Profil Berhasil Di Ubah');</script>";
    echo "<script>location='akun.php';</script>";
}
include 'footer.php';
?>

<script>
    $(document).ready(function() {
        $.ajax({
            type: 'post',
            url: 'dataprovinsi.php',
            success: function(hasil_provinsi) {
                $("select[name=nama_provinsi]").html(hasil_provinsi);
            }
        });

        $("select[name=nama_provinsi]").on("change", function() {
            var id_provinsi_terpilih = $("option:selected", this).attr("id_provinsi");
            $.ajax({
                type: 'post',
                url: 'datadistrik.php',
                data: 'id_provinsi=' + id_provinsi_terpilih,
                success: function(hasil_distrik) {
                    $("select[name=nama_distrik]").html(hasil_distrik);
                }
            });
        });
    });
</script>