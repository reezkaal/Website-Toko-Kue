<?php
session_start();
include 'koneksi.php';
?>
<?php
$idproduk = $_GET["id"];
$ambil = $koneksi->query("SELECT*FROM produk WHERE idproduk='$idproduk'");
$detail = $ambil->fetch_assoc();
$kategori = $detail["idkategori"];
?>
<?php include 'header.php'; ?>
<div class="container-fluid page-header py-6 wow fadeIn" data-wow-delay="0.1s">
	<div class="container text-center pt-5 pb-3">
		<h1 class="display-4 text-white animated slideInDown mb-3">Detail</h1>
		<nav aria-label="breadcrumb animated slideInDown">
			<ol class="breadcrumb justify-content-center mb-0">
				<li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
				<li class="breadcrumb-item text-primary active" aria-current="page">Detail</li>
			</ol>
		</nav>
	</div>
</div>

<div class="container-xxl py-6">
	<div class="container">
		<div class="row g-5">
			<div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
				<div class="row position-relative h-100">
					<img style="height: 500px;object-fit: cover;" class="img-fluid rounded" src="foto/<?php echo $detail["fotoproduk"]; ?>" alt="">
				</div>
			</div>
			<div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
				<div class="h-100">
					<h3><?php echo $detail["namaproduk"] ?></h3>
				<p class="price"><span>Rp. <?php echo number_format($detail["hargaproduk"]); ?></span></p>
				<?php
				$ambilulasan = mysqli_query($koneksi, "SELECT sum(bintang) as totalbintang FROM ulasan where ulasan.idproduk = '$idproduk'");
				$dataulasan = $ambilulasan->fetch_assoc();
				$ambilulasan = mysqli_query($koneksi, "SELECT * FROM ulasan where ulasan.idproduk = '$idproduk'");
				$hitungulasan = $ambilulasan->num_rows;
				if ($hitungulasan == 0) {
					$jumlahulasan = 1;
				} else {
					$jumlahulasan = $hitungulasan;
				}
				$rataulasan = $dataulasan['totalbintang'] / $jumlahulasan;
				$kritik = "";
				for ($i = 1; $i <= 5; $i++) {
					if ($rataulasan >= $i) {
						$kritik .= '<span class="fa fa-star checked" style="color:#ffc700;font-size:15pt"></span>';
					} else {
						$kritik .= '<span class="fa fa-star" style="font-size:15pt"></span>';
					}
				}
				if ($hitungulasan >= 1) {
					echo $kritik;
				}
				?>
				<br>
				<br>
				<span style="color: #000;font-size:15pt !important;"><?php echo $detail["deskripsiproduk"]; ?></span>
				<div class="row mt-4">
					<div class="w-100"></div>
					<div class="col-md-12">
						<p style="color: #000;font-size:15pt !important;">Sisa Produk : <?php echo number_format($detail["stokproduk"]); ?></p>
					</div>
				</div>
				<form method="post">
					<div class="form-group">
						<label>Beli Produk</label>
						<input type="number" placeholder="Jumlah" min="1" class="form-control" name="jumlah" max="<?php echo number_format($detail["stokproduk"]); ?>" required></input>
						<br>
						<button class="btn btn-success float-right" name="beli"><i class="fa fa-shopping-cart"></i> Beli</button>
					</div>
				</form>
				<?php
				if (isset($_POST["beli"])) {
					if (!isset($_SESSION["pengguna"])) {
						echo "<script> alert('Anda belum login');</script>";
						echo "<script> location ='login.php';</script>";
					} else {
						$jumlah = $_POST["jumlah"];
						$_SESSION["keranjang"][$idproduk] = $jumlah;
						echo "<script> alert('Produk Masuk Ke Keranjang');</script>";
						echo "<script> location ='keranjang.php';</script>";
					}
					
				}
				?>
				<br>
				<br>
				<?php
				$ambilulasan = mysqli_query($koneksi, "SELECT * FROM ulasan left join pengguna ON pengguna.id = ulasan.idpengguna where ulasan.idproduk = '$idproduk' order by waktu desc");
				$cekulasan = $ambilulasan->num_rows;
				if ($cekulasan >= 1) { ?>
					<div class="row mb-3">
						<div class="col-md-12">
							<ul class="comment-list">
								<?php
									$top = 190;
									while ($ulasan = mysqli_fetch_assoc($ambilulasan)) {
										$kritik = "";
										for ($i = 1; $i <= 5; $i++) {
											if ($ulasan['bintang'] >= $i) {
												$kritik .= '<span class="fa fa-star checked" style="color:#ffc700"></span>';
											} else {
												$kritik .= '<span class="fa fa-star"></span>';
											}
										}
										?>
									<div class="card mb-3 p-3 shadow-sm">
										<div class="row">
											<?php if ($ulasan['foto'] != "") { ?>
												<div class="col-md-7 my-auto">
													<li class="comment-list-item">
														<div class="comment-list-item-image">
															<p class="text-success"><?= tanggal(date('Y-m-d', strtotime($ulasan['waktu']))) ?> - <?= date('H:i', strtotime($ulasan['waktu'])) ?></p>
														</div>
														<div class="comment-list-item-content">
															<?php if ($ulasan['tampilannama'] == "Tampilkan Nama") { ?>
																<h5 class="text-success mb-3"><?= $ulasan['nama'] ?></h5>
															<?php } else { ?>
																<h5 class="text-success mb-3">*******</h5>
															<?php } ?>
															<?= $kritik ?>
															<p class="mt-3"><?= $ulasan['ulasan'] ?></p>
														</div>
													</li>
												</div>
												<div class="col-md-5">
													<img src="foto/<?= $ulasan['foto'] ?>" width="100%" style="border-radius: 10px;">
												</div>
											<?php } else { ?>
												<div class="col-md-12">
													<li class="comment-list-item">
														<div class="comment-list-item-image">
															<p class="text-success"><?= tanggal(date('Y-m-d', strtotime($ulasan['waktu']))) ?> - <?= date('H:i', strtotime($ulasan['waktu'])) ?></p>
														</div>
														<div class="comment-list-item-content">
															<h5 class="text-success mb-3"><?= $ulasan['nama'] ?></h5>
															<?= $kritik ?>
															<p class="mt-3"><?= $ulasan['ulasan'] ?></p>
														</div>
													</li>
												</div>
											<?php } ?>
										</div>
									</div>
								<?php
									} ?>
							</ul>
						</div>
					</div>
				<?php } else { ?>
					<div class="row mb-3">
						<div class="col-md-12">
							<div class="card mb-3 p-3 shadow-sm">
								<h3 class="text-center">Ulasan masih kosong</h3>
								<img src="foto/kosong.png" width="100%" style="border-radius: 10px;">
							</div>
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include 'footer.php';
?>