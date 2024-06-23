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
		<h1 class="display-4 text-white animated slideInDown mb-3">Keranjang</h1>
		<nav aria-label="breadcrumb animated slideInDown">
			<ol class="breadcrumb justify-content-center mb-0">
				<li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
				<li class="breadcrumb-item text-primary active" aria-current="page">Keranjang</li>
			</ol>
		</nav>
	</div>
</div>
<div class="container-xxl py-6">
	<div class="container">
		<div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
			<p class="text-primary text-uppercase mb-2">Keranjang</p>
			<h1 class="display-6 mb-4">Keranjang</h1>
		</div>
		<div class="row g-0 justify-content-center">
			<div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
				<table class="table">
					<thead class="bg-primary text-white">
						<tr class="text-center">
							<th>No</th>
							<th>Produk</th>
							<th>Foto Produk</th>
							<th>Harga</th>
							<th>Jumlah Beli</th>
							<th>Total Harga</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $nomor = 1; ?>
						<?php if (!empty($_SESSION["keranjang"])) { ?>
							<?php foreach ($_SESSION["keranjang"] as $idproduk => $jumlah) : ?>
								<?php
										$ambil = $koneksi->query("SELECT * FROM produk 
								WHERE idproduk='$idproduk'");
										$pecah = $ambil->fetch_assoc();
										$totalharga = $pecah["hargaproduk"] * $jumlah;
										?>
								<tr class="text-center">
									<td><?php echo $nomor; ?></td>
									<td><?php echo $pecah['namaproduk']; ?></td>
									<td>
										<img width="100px" src="foto/<?php echo $pecah["fotoproduk"]; ?>">
									</td>
									<td>Rp <?php echo number_format($pecah['hargaproduk']); ?></td>
									<td><?php echo $jumlah; ?></td>
									<td>Rp <?php echo number_format($totalharga); ?></td>
									<td>
										<a href="hapuskeranjang.php?id=<?php echo $idproduk ?>" class="btn btn-danger btn-xs">Hapus</a>
									</td>
								</tr>
								<?php $nomor++; ?>
						<?php endforeach;
						} ?>
					</tbody>
				</table>
			</div>
		</div>
		<br><br>
		<div class="row justify-content-center">
			<a href="index.php" class="btn btn-warning"><i class="fa fa-cart-plus"></i>Lanjutkan Belanja</a>
			&nbsp;<a href="checkout.php" class="btn btn-primary">Checkout</a>
		</div>
		<br><br>
	</div>
</div>

<?php
include 'footer.php';
?>