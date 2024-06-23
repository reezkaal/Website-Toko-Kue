<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["pengguna"])) {
	echo "<script> alert('Anda belum login');</script>";
	echo "<script> location ='login.php';</script>";
	exit();
}
$idpem = $_GET["id"];
$ambil = $koneksi->query("SELECT*FROM pemesanan WHERE idpenjualan='$idpem'");
$detpem = $ambil->fetch_assoc();

$id_beli = $detpem["id"];
$id_login = $_SESSION["pengguna"]["id"];
if ($id_login !== $id_beli) {
	echo "<script> alert('Gagal');</script>";
	echo "<script> location ='riwayat.php';</script>";
}
$deadline = date('Y-m-d H:i', strtotime($detpem['waktu'] . ' +1 day'));
$harideadline = date('Y-m-d', strtotime($detpem['waktu'] . ' +1 day'));
$jamdeadline = date('H:i', strtotime($detpem['waktu'] . ' +1 day'));
if (date('Y-m-d H:i') >= $deadline) {
	echo "<script> alert('Waktu pembayaran telah habis');</script>";
	echo "<script> location ='riwayat.php';</script>";
}

?>
<?php include 'header.php'; ?>
<div class="container-fluid page-header py-6 wow fadeIn" data-wow-delay="0.1s">
	<div class="container text-center pt-5 pb-3">
		<h1 class="display-4 text-white animated slideInDown mb-3">Pembayaran</h1>
		<nav aria-label="breadcrumb animated slideInDown">
			<ol class="breadcrumb justify-content-center mb-0">
				<li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
				<li class="breadcrumb-item text-primary active" aria-current="page">Pembayaran</li>
			</ol>
		</nav>
	</div>
</div>
<section id="home-section" class="ftco-section">
	<div class="container mt-4">
		<?php
		$ambil = $koneksi->query("SELECT*FROM pemesanan JOIN pengguna
		ON pemesanan.id=pengguna.id
		WHERE pemesanan.idpenjualan='$_GET[id]'");
		$detail = $ambil->fetch_assoc();
		?>
		<h4 class="text-danger">Upload Bukti Pembayaran Sebelum <?= tanggal($harideadline) . ' - Jam ' . $jamdeadline ?></h4>
		<br>
		<div class="row">
			<div class="col-md-6">
				<strong>NO PEMESANAN: <?php echo $detail['idpenjualan']; ?></strong><br>
				Status Barang : <?php echo $detail['statusbeli']; ?><br>
				Total Pemesanan : Rp. <?php echo number_format($detail['totalbeli']); ?><br>
				Ongkir : Rp. <?php echo number_format($detail['ongkir']); ?><br>
				Total Bayar : Rp. <?php echo number_format($detail['ongkir'] + $detail['totalbeli']); ?><br>
				Ekspedisi : <?php echo $detail['ekspedisi']; ?><br>
				Layanan : <?php echo $detail['layanan']; ?><br>
			</div>
			<div class="col-md-6">
				<strong>NAMA : <?php echo $detail['nama']; ?></strong><br>
				Telepon : <?php echo $detail['telepon']; ?><br>
				Email : <?php echo $detail['email']; ?><br>
				Alamat Pengiriman : <?php echo $detail['alamatpengiriman']; ?><br>
				Provinsi : <?php echo $detail['provinsi']; ?><br>
				Kota : <?php echo $detail['kota']; ?><br>

			</div>
		</div>
		<br>
		<table class="table table-bordered">
			<thead class="bg-primary text-white">
				<tr>
					<th>No</th>
					<th>Nama Produk</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Total Harga</th>
				</tr>
			</thead>
			<tbody>
				<?php $nomor = 1; ?>
				<?php $ambil = $koneksi->query("SELECT * FROM penjualan WHERE idpenjualan='$_GET[id]'"); ?>
				<?php while ($pecah = $ambil->fetch_assoc()) { ?>
					<tr>
						<td><?php echo $nomor; ?></td>
						<td><?php echo $pecah['nama']; ?></td>
						<td>Rp. <?php echo number_format($pecah['harga']); ?></td>
						<td><?php echo $pecah['jumlah']; ?></td>
						<td>Rp. <?php echo number_format($pecah['subharga']); ?></td>
					</tr>
					<?php $nomor++; ?>
				<?php } ?>
			</tbody>
		</table>
		<div class="row justify-content-center mb-5 mt-5">
			<div class="col-md-5">
				<img width="100%" src="foto/bayar.webp">
			</div>
			<div class="col-md-7">
				<div class="table-responsive">
					<table class="table ">
						<thead class="bg-primary text-white">
							<tr>
								<th>No</th>
								<th>Nama Pembayaran</th>
								<th>No Rekening</th>
								<th>Atas Nama</th>
							</tr>
						</thead>
						<tbody>
							<?php $nomor = 1; ?>
							<?php $ambil = $koneksi->query("SELECT * FROM pembayaranrekening"); ?>
							<?php while ($pecah = $ambil->fetch_assoc()) { ?>
								<tr>
									<td><?php echo $nomor; ?></td>
									<td><?php echo $pecah['namapembayaran']; ?></td>
									<td><?php echo $pecah['norek']; ?></td>
									<td><?php echo $pecah['atasnama']; ?></td>
								</tr>
								<?php $nomor++; ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<br>
				<br>
				<div class="alert alert-info">Total Tagihan Anda : <strong>Rp. <?php echo number_format($detpem["totalbeli"] + $detpem["ongkir"]) ?> <br>(Sudah
						Termasuk biaya pengiriman)</strong></div>

				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label class="mb-2">Nama Rekening</label>
						<input type="text" name="nama" class="form-control mb-2" value="<?= $_SESSION['pengguna']['nama'] ?>" required>
					</div>
					<div class="form-group">
						<label class="mb-2">Tanggal Transfer</label>
						<input type="date" name="tanggaltransfer" class="form-control mb-2" value="<?= date('Y-m-d') ?>" required>

					</div>
					<div class="form-group">
						<label class="mb-2">Foto Bukti</label>
						<input type="file" name="bukti" class="form-control mb-2" required>
					</div>
					<button class="btn btn-primary w-100 mt-4" name="kirim">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</section>
<?php
if (isset($_POST["kirim"])) {
	$namabukti = $_FILES["bukti"]["name"];
	$lokasibukti = $_FILES["bukti"]["tmp_name"];
	$namafix = date("YmdHis") . $namabukti;
	move_uploaded_file($lokasibukti, "foto/$namafix");

	$nama = $_POST["nama"];
	$tanggaltransfer = $_POST["tanggaltransfer"];
	$tanggal = date("Y-m-d");
	$norek = $_POST["norek"];
	$atasnama = $_POST["atasnama"];

	$koneksi->query("INSERT INTO pembayaran(idpenjualan, nama, tanggaltransfer,tanggal, bukti)
		VALUES ('$idpem','$nama','$tanggaltransfer','$tanggal','$namafix')");

	$koneksi->query("UPDATE pemesanan SET statusbeli='Sudah Upload Bukti Pembayaran'
		WHERE idpenjualan='$idpem'");
	echo "<script> alert('Terima kasih');</script>";
	echo "<script>location='riwayat.php';</script>";
}
?>
<?php
include 'footer.php';
?>