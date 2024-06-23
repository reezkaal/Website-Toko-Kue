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
		<h1 class="display-4 text-white animated slideInDown mb-3">Riwayat</h1>
		<nav aria-label="breadcrumb animated slideInDown">
			<ol class="breadcrumb justify-content-center mb-0">
				<li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
				<li class="breadcrumb-item text-primary active" aria-current="page">Riwayat</li>
			</ol>
		</nav>
	</div>
</div>
<div class="container-xxl py-6">
	<div class="container">
		<div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
			<p class="text-primary text-uppercase mb-2">Riwayat</p>
			<h1 class="display-6 mb-4">Riwayat</h1>
		</div>
		<div class="row g-0 justify-content-center">
			<div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
				<table class="table">
					<thead class="bg-primary text-white">
						<tr class="text-center">
							<th width="10px">No</th>
							<th width="30%x">Daftar</th>
							<th>Tanggal</th>
							<th>Total</th>
							<th>Opsi</th>
							<th>Bukti Pembayaran</th>
							<th>Nota</th>
						</tr>
					</thead>
					<tbody>
						<?php $nomor = 1;
						$id = $_SESSION["pengguna"]['id'];
						$ambil = $koneksi->query("SELECT *, pemesanan.idpenjualan as idpenjualanreal FROM pemesanan left join pembayaran on pemesanan.idpenjualan = pembayaran.idpenjualan WHERE pemesanan.id='$id' order by pemesanan.tanggalbeli desc, pemesanan.idpenjualan desc");
						while ($pecah = $ambil->fetch_assoc()) { ?>
							<tr>
								<td><?php echo $nomor; ?></td>
								<td>
									<ul>
										<?php $ambilproduk = $koneksi->query("SELECT * FROM penjualan join produk on penjualan.idproduk = produk.idproduk where idpenjualan='$pecah[idpenjualanreal]'");
										while ($produk = $ambilproduk->fetch_assoc()) { ?>
											<li>
												<?= $produk['namaproduk'] ?> x <?= $produk['jumlah'] ?>
											</li>
										<?php } ?>
									</ul>
								</td>
								<td><?php echo tanggal($pecah['tanggalbeli']) . '<br>Jam ' . date('H:i', strtotime($pecah['waktu'])) ?></td>
								<td>Rp. <?php echo number_format($pecah["totalbeli"] + $pecah["ongkir"]); ?></td>
								<!-- <td>
										<?php if ($pecah['statusbeli'] == "Belum Bayar") {
											$deadline = date('Y-m-d H:i', strtotime($pecah['waktu'] . ' +1 day'));
											$harideadline = date('Y-m-d', strtotime($pecah['waktu'] . ' +1 day'));
											$jamdeadline = date('H:i', strtotime($pecah['waktu'] . ' +1 day'));
											if (date('Y-m-d H:i') >= $deadline) {
												echo 'Waktu pembayaran<br>telah habis';
											} else { ?>
												<a href="pembayaran.php?id=<?php echo $pecah["idpenjualanreal"] ?>" class="btn btn-danger">Upload Bukti<br>Pembayaran Sebelum<br><?= tanggal($harideadline) . ' - Jam ' . $jamdeadline ?></a>
											<?php }
										} elseif ($pecah['statusbeli'] == "Sudah Upload Bukti Pembayaran") { ?>
											<a class="btn btn-danger text-white">Menunggu Konfirmasi Admin</a>
										<?php } elseif ($pecah['statusbeli'] == "Barang Di Kirim") { ?>
											<a class="btn btn-danger text-white">Barang Anda Sedang Di Kirim, Mohon Di Tungggu</a>
											<br><br>
											<p><a target="_blank" href="https://cekresi.com">No Resi : <?= $pecah['resipengiriman'] ?></a></p>
										<?php } elseif ($pecah['statusbeli'] == "Barang Telah Sampai ke Pemesan") { ?>
											<a data-toggle="modal" data-target="#selesai<?= $nomor ?>" class="btn btn-success text-white">Konfirmasi Selesai</a>
										<?php } elseif ($pecah['statusbeli'] == "Selesai") { ?>
											Selesai
										<?php } elseif ($pecah['statusbeli'] == "Pesanan Di Tolak") { ?>
											<a class="btn btn-danger text-white">Pesanan Anda Di Tolak</a>
										<?php } ?>
									</td> -->
								<td>
									<?php if ($pecah['statusbeli'] == "Belum Bayar") {
										$deadline = date('Y-m-d H:i', strtotime($pecah['waktu'] . ' +1 day'));
										$harideadline = date('Y-m-d', strtotime($pecah['waktu'] . ' +1 day'));
										$jamdeadline = date('H:i', strtotime($pecah['waktu'] . ' +1 day'));
										if (date('Y-m-d H:i') >= $deadline) {
											echo 'Waktu pembayaran<br>telah habis';
										} else { ?>
											<a href="pembayaran.php?id=<?php echo $pecah["idpenjualanreal"] ?>" class="btn btn-success">Silahkan Upload<br>Pembayaran Sebelum<br><?= tanggal($harideadline) . ' - Pukul ' . $jamdeadline . ' W.I.B' ?></a>
										<?php }
									} elseif ($pecah['statusbeli'] == "Sudah Upload Bukti Pembayaran") { ?>
										<a class="btn btn-primary text-white">Menunggu Konfirmasi Admin</a>
									<?php } elseif ($pecah['statusbeli'] == "Belum di Konfirmasi") { ?>
										<a class="btn btn-primary text-white">Menunggu Konfirmasi Admin</a>
									<?php } elseif ($pecah['statusbeli'] == "Barang Di Kemas") { ?>
										<a class="btn btn-primary text-white">Barang Anda Sedang Di Kemas, Mohon Di Tungggu</a>
									<?php } elseif ($pecah['statusbeli'] == "Barang Di Kirim") { ?>
										<a class="btn btn-primary text-white">Barang Anda Sedang Di Kirim, Mohon Di Tungggu</a>
										<br><br>
										<p><a target="_blank" href="https://cekresi.com">No Resi : <?= $pecah['resipengiriman'] ?></a></p>
									<?php } elseif ($pecah['statusbeli'] == "Barang Telah Sampai ke Pemesan") { ?>
										<a data-bs-toggle="modal" data-bs-target="#selesai<?= $nomor ?>" class="btn btn-success text-white">Konfirmasi Selesai</a>
									<?php } elseif ($pecah['statusbeli'] == "Selesai") { ?>
										<a href="ulasan.php?id=<?= $pecah["idpenjualan"] ?>" class="btn btn-success text-white">Berikan Ulasan</a>
									<?php } elseif ($pecah['statusbeli'] == "Pesanan Di Tolak") { ?>
										<a class="btn btn-danger text-white">Pesanan Anda Di Tolak</a>
									<?php } ?>
									<br>
									<br>
								</td>
								<td><img width="100px" src="foto/<?= $pecah['bukti'] ?>" alt=""></td>
								<td>
									<?php if ($pecah['statusbeli'] != "Belum Bayar") { ?>
										<a class="btn btn-primary text-white" target="_blank" href="notacetak.php?id=<?= $pecah['idpenjualanreal'] ?>">Nota</a>
									<?php } ?>
								</td>
							</tr>
							<?php $nomor++; ?>
						<?php  } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php
$no = 1;
$id = $_SESSION["pengguna"]['id'];
$ambil = $koneksi->query("SELECT *, pemesanan.idpenjualan as idpenjualanreal FROM pemesanan left join pembayaran on pemesanan.idpenjualan = pembayaran.idpenjualan WHERE pemesanan.id='$id' order by pemesanan.tanggalbeli desc, pemesanan.idpenjualan desc");
while ($pecah = $ambil->fetch_assoc()) { ?>
	<div class="modal fade" id="selesai<?= $no ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pesanan Selesai</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="post">
					<div class="modal-body">
						<h5>Apakah anda yakin ingin mengkonfirmasi pesanan telah selesai ?</h5>
					</div>
					<div class="modal-footer">
						<input type="hidden" class="form-control" value="<?= $pecah['idpenjualan'] ?>" name="idpenjualan">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
						<button type="submit" name="selesai" value="selesai" class="btn btn-primary">Konfirmasi</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
	$no++;
} ?>
<?php
if (isset($_POST["selesai"])) {
	$koneksi->query("UPDATE pemesanan SET statusbeli='Selesai'
		WHERE idpenjualan='$_POST[idpenjualan]'");
	echo "<script>alert('Pesanan berhasil di konfirmasi selesai')</script>";
	echo "<script>location='riwayat.php';</script>";
}
?>
<div style="padding-top:250px"></div>
<?php
include 'footer.php';
?>