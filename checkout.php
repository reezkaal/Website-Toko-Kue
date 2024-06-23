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
		<h1 class="display-4 text-white animated slideInDown mb-3">Checkout</h1>
		<nav aria-label="breadcrumb animated slideInDown">
			<ol class="breadcrumb justify-content-center mb-0">
				<li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
				<li class="breadcrumb-item text-primary active" aria-current="page">Checkout</li>
			</ol>
		</nav>
	</div>
</div>
<div class="container-xxl py-6">
	<div class="container">
		<div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
			<p class="text-primary text-uppercase mb-2">Checkout</p>
			<h1 class="display-6 mb-4">Checkout</h1>
		</div>
		<div class="row g-0 justify-content-center">
			<div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
				<table class="table">
					<thead class="bg-primary text-white">
						<tr class="text-center">
							<th>No</th>
							<th>Produk</th>
							<th>Berat (*g)</th>
							<th>Harga</th>
							<th>Jumlah Beli</th>
							<th>SubBerat (*g)</th>
							<th>SubHarga</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$nomor = 1;
						$totalbelanja = 0;
						$totalberat = 0;
						foreach ($_SESSION["keranjang"] as $idproduk => $jumlah) : ?>
							<?php
							$ambil = $koneksi->query("SELECT * FROM produk 
								WHERE idproduk='$idproduk'");
							$pecah = $ambil->fetch_assoc();
							$totalharga = $pecah["hargaproduk"] * $jumlah;
							$subberat = $pecah["beratproduk"] * $jumlah;
							$totalberat += $subberat;
							$berat = $totalberat / 1000;
							?>
							<tr>
								<td><?php echo $nomor; ?></td>
								<td><?php echo $pecah['namaproduk']; ?></td>
								<td><?php echo $pecah['beratproduk']; ?></td>
								<td>Rp <?php echo number_format($pecah['hargaproduk']); ?></td>
								<td><?php echo $jumlah; ?></td>
								<td><?php echo ($subberat); ?></td>
								<td>Rp <?php echo number_format($totalharga); ?></td>
							</tr>
							<?php $nomor++; ?>
							<?php $totalbelanja += $totalharga; ?>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="container-xxl">
	<div class="container">
		<div class="row g-0 justify-content-center">
			<div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
				<form method="post">
					<div class="row g-3">
						<div class="col-md-6">
							<div class="form-group">
								<label class="mb-2">Nama Pelanggan</label>
								<input type="text" readonly value="<?php echo $_SESSION["pengguna"]['nama'] ?>" class="form-control mb-2" name="namapelanggan">
							</div>
							<div class="form-group">
								<label class="mb-2">No. Handphone Pelanggan</label>
								<input type="text" readonly value="<?php echo $_SESSION["pengguna"]['telepon'] ?>" class="form-control mb-2">
							</div>
							<div class="form-group">
								<label class="mb-2">Alamat Lengkap Pengiriman</label>
								<input type="hidden" name="totalberatnya" value="<?php echo $berat ?>" required>
								<textarea class="form-control mb-2" name="alamatpengiriman" placeholder="Masukkan Alamat"><?php echo $_SESSION["pengguna"]['alamat'] ?></textarea>
							</div>
							<div class="form-group">
								<div class="row">
									<!-- <input type="hidden" name="total_berat" value="1"> -->
									<input type="hidden" name="provinsi">
									<input type="hidden" name="distrik">
									<input type="hidden" name="tipe">
									<input type="hidden" name="kodepos">
									<input type="hidden" name="ekspedisi">
									<input type="hidden" name="paket">
									<input type="hidden" name="ongkir" id="ongkir">
									<input type="hidden" name="estimasi">
									<div class="col-md-6 form-group">
										<label>Provinsi</label>
										<select class="form-control" name="nama_provinsi">

										</select>
									</div>
									<div class="col-md-6 form-group">
										<label>Kota</label>
										<select class="form-control" name="nama_distrik">

										</select>
									</div>
									<div class="col-md-12 form-group  mt-2">
										<div class="form-group">
											<label>Pilih Metode Pengiriman</label>
											<select name="metodepengiriman" id="metodepengiriman" class="form-control" onchange="handlemetodepengiriman()" required>
												<option value="">Pilih</option>
												<option value="Reguler">Reguler</option>
												<option value="Same Day">Same Day - 6 Jam</option>
												<option value="Instant">Instant - 2 Jam</option>
											</select>
										</div>
									</div>
								</div>

								<div class="tampil" id="tampil" style="display: none;">
									<div class="row">
										<div class="col-md-6 form-group  mt-2">
											<label>Ekspedisi</label>
											<select class="form-control" name="nama_ekspedisi" id="ekspedisi1">
											</select>
										</div>
										<div class="col-md-6 form-group  mt-2">
											<label>Layanan</label>
											<select class="form-control" name="nama_paket" id="layanan1">
											</select>
										</div>
									</div>
								</div>
								<div class="tampil2" id="tampil2" style="display: none;">
									<div class="row">
										<div class="col-md-12 form-group mt-2">
											<label>Ekspedisi </label>
											<select class="form-control" name="nama_ekspedisi2" id="ekspedisi2">
												<option value="Gojek">Gojek</option>
												<option value="Grab">Grab</option>
											</select>
										</div>

									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<input type="hidden" id="totalbelanja" name="totalbelanja" value="<?php echo $totalbelanja ?>" required>
							<div class="col-md-12 form-group p_star">
								<label>Total Belanja</label>
								<input class="form-control valid mb-3" type="number" readonly required value="<?= $totalbelanja ?>">
							</div>
							<div class="form-group">
								<label class="mb-2">Total Berat (*g)</label>
								<input class="form-control mb-2" name="berat" type="number" value="<?= $totalberat ?>" readonly required id="berat">
							</div>
							<div class="form-group">
								<label class="mb-2">Ongkir Pengiriman</label>
								<input class="form-control mb-2" name="ongkir" type="number" value="0" readonly required id="ongkir">
							</div>
							<div class="form-group">
								<label class="mb-2">Grandtotal</label>
								<input class="form-control mb-2" id="grandtotal" value="<?= $totalbelanja ?>" required readonly type="number">
							</div>


							<button class="btn btn-primary pull-right w-100 mt-4" name="checkout">Selesaikan Pembayaran</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
if (isset($_POST["checkout"])) {
	$notransaksi = '#INV-' . date("Ymdhis");
	$id = $_SESSION["pengguna"]["id"];
	$tanggalbeli = date("Y-m-d");
	$waktu = date("Y-m-d H:i:s");
	$alamatpengiriman = $_POST["alamatpengiriman"];
	$totalbeli = $totalbelanja;
	$totalberatnya = $_POST["totalberatnya"];
	$ongkir = $_POST["ongkir"];
	$kota = $_POST["nama_distrik"];
	$provinsi = $_POST["nama_provinsi"];
	$totalberat = $_POST["berat"];
	$metodepengiriman = $_POST['metodepengiriman'];
	if ($metodepengiriman == 'Reguler') {
		$ekspedisi = strtoupper($_POST["nama_ekspedisi"]);
		$layanan = $_POST["nama_paket"];

		$koneksi->query(
			"INSERT INTO pemesanan(notransaksi,
				id, tanggalbeli, totalbeli, alamatpengiriman,totalberat, kota, provinsi, ekspedisi, layanan, ongkir, statusbeli, waktu, metodepengiriman)
				VALUES('$notransaksi','$id', '$tanggalbeli', '$totalbeli','$alamatpengiriman','$totalberat', '$kota','$provinsi','$ekspedisi','$layanan','$ongkir', 'Belum Bayar', '$waktu','$metodepengiriman')"
		) or die(mysqli_error($koneksi));
		$idpenjualan_barusan = $koneksi->insert_id;
		foreach ($_SESSION['keranjang'] as $idproduk => $jumlah) {
			$ambil = $koneksi->query("SELECT*FROM produk WHERE idproduk='$idproduk'");
			$perproduk = $ambil->fetch_assoc();
			$nama = $perproduk['namaproduk'];
			$harga = $perproduk['hargaproduk'];
			$subharga = $perproduk['hargaproduk'] * $jumlah;

			$stok_sekarang = $perproduk['stokproduk'] - $jumlah;
			$koneksi->query("UPDATE produk SET stokproduk='$stok_sekarang' WHERE idproduk='$idproduk'");

			$koneksi->query("INSERT INTO penjualan (idpenjualan, idproduk, nama, harga, subharga, jumlah)
					VALUES ('$idpenjualan_barusan','$idproduk', '$nama','$harga','$subharga','$jumlah')") or die(mysqli_error($koneksi));
		}
	} else {
		$ekspedisi = strtoupper($_POST["nama_ekspedisi2"]);
		$layanan = $_POST["nama_ekspedisi2"];
		$ongkir = 0;

		$koneksi->query(
			"INSERT INTO pemesanan(notransaksi,
				id, tanggalbeli, totalbeli, alamatpengiriman,totalberat, kota, provinsi, ekspedisi, layanan, ongkir, statusbeli, waktu, metodepengiriman)
				VALUES('$notransaksi','$id', '$tanggalbeli', '$totalbeli','$alamatpengiriman','$totalberat', '$kota','$provinsi','$ekspedisi','$layanan','$ongkir', 'Belum di Konfirmasi', '$waktu','$metodepengiriman')"
		) or die(mysqli_error($koneksi));
		$idpenjualan_barusan = $koneksi->insert_id;
		foreach ($_SESSION['keranjang'] as $idproduk => $jumlah) {
			$ambil = $koneksi->query("SELECT*FROM produk WHERE idproduk='$idproduk'");
			$perproduk = $ambil->fetch_assoc();
			$nama = $perproduk['namaproduk'];
			$harga = $perproduk['hargaproduk'];

			$stok_sekarang = $perproduk['stokproduk'] - $jumlah;
			$koneksi->query("UPDATE produk SET stokproduk='$stok_sekarang' WHERE idproduk='$idproduk'");

			$subharga = $perproduk['hargaproduk'] * $jumlah;
			$koneksi->query("INSERT INTO penjualan (idpenjualan, idproduk, nama, harga, subharga, jumlah)
					VALUES ('$idpenjualan_barusan','$idproduk', '$nama','$harga','$subharga','$jumlah')") or die(mysqli_error($koneksi));
		}
	}

	unset($_SESSION["keranjang"]);
	echo "<script> alert('Pembelian Sukses');</script>";
	echo "<script> location ='riwayat.php';</script>";
}
?>
<?php
include 'footer.php';
?>

<!-- <script>
	function check() {
		var val = document.getElementById('kota').value;
		if (val == 'Medan') {
			document.getElementById('ongkir').value = "5000";
		} else if (val == 'Palembang') {
			document.getElementById('ongkir').value = "7000";
		} else if (val == 'Jakarta') {
			document.getElementById('ongkir').value = "7000";
		} else if (val == 'Bandung') {
			document.getElementById('ongkir').value = "7000";
		} else if (val == 'Surabaya') {
			document.getElementById('ongkir').value = "10000";
		} else if (val == 'Yogyakarta') {
			document.getElementById('ongkir').value = "10000";
		} else if (val == 'Bali') {
			document.getElementById('ongkir').value = "10000";
		} else if (val == 'Cirebon') {
			document.getElementById('ongkir').value = "10000";
		} else if (val == 'Tanjung Enim') {
			document.getElementById('Tanjung Enim').value = "12000";
		}
		var num1 = document.getElementById("ongkir").value;
		var num2 = document.getElementById("totalbelanja").value;
		result = parseInt(num1) + parseInt(num2);
		document.getElementById("grandtotal").value = result;

	}
</script> -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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
		$.ajax({
			type: 'post',
			url: 'dataekspedisi.php',
			success: function(hasil_ekspedisi) {
				$("select[name=nama_ekspedisi]").html(hasil_ekspedisi);
			}
		});

		$("select[name=nama_ekspedisi]").on("change", function() {
			//dapetin data ongkir

			//dapetin ekspedisi terpilih
			var ekpedisi_terpilih = $("select[name=nama_ekspedisi]").val();
			//dapetin id_distrik yg dipilih pengguna
			var distrik_terpilih = $("option:selected", "select[name=nama_distrik]").attr("id_distrik");
			//dapetin total berat dari inputan
			var total_berat = $("input[name=totalberatnya]").val();
			$.ajax({
				type: 'post',
				url: 'datapaket.php',
				data: 'ekspedisi=' + ekpedisi_terpilih + '&distrik=' + distrik_terpilih + '&berat=' + total_berat,
				success: function(hasil_paket) {
					console.log(hasil_paket);
					$("select[name=nama_paket]").html(hasil_paket);

					//taro ekspedisi terpilih di inputan ekspedisi
					$("input[name=ekspedisi]").val(ekpedisi_terpilih);
				}
			})
		});
		$("select[name=nama_distrik]").on("change", function() {
			var prov = $("option:selected", this).attr("nama_provinsi");
			var dist = $("option:selected", this).attr("nama_distrik");
			var tipe = $("option:selected", this).attr("tipe_distrik");
			var kodepos = $("option:selected", this).attr("kodepos");

			$("input[name=provinsi]").val(prov);
			$("input[name=distrik]").val(dist);
			$("input[name=tipe]").val(tipe);
			$("input[name=kodepos]").val(kodepos);
		});
		$("select[name=nama_paket]").on("change", function() {
			var paket = $("option:selected", this).attr("paket");
			var ongkir = $("option:selected", this).attr("ongkir");
			var etd = $("option:selected", this).attr("etd");

			$("input[name=paket]").val(paket);
			$("input[name=ongkir]").val(ongkir);
			$("input[name=estimasi]").val(etd);
			var num2 = document.getElementById("totalbelanja").value;
			result = parseInt(ongkir) + parseInt(num2);
			document.getElementById("grandtotal").value = result;
		})
	});
</script>

<script>
	function handlemetodepengiriman() {
		var metodepengiriman = document.getElementById("metodepengiriman").value;
		var tampilDiv = document.getElementById("tampil");
		var tampilDiv2 = document.getElementById("tampil2");

		if (metodepengiriman == "Same Day" || metodepengiriman == "Instant") {
			tampilDiv.style.display = "none";
			tampilDiv2.style.display = "block";

			document.getElementById("ekspedisi1").removeAttribute("required");
			document.getElementById("layanan1").removeAttribute("required");
			document.getElementById("ekspedisi2").setAttribute("required", true);
		} else if (metodepengiriman == "Reguler") {
			tampilDiv.style.display = "block";
			tampilDiv2.style.display = "none";
			document.getElementById("ekspedisi1").setAttribute("required", true);
			document.getElementById("layanan1").setAttribute("required", true);
			document.getElementById("ekspedisi2").removeAttribute("required");
		} else {
			tampilDiv.style.display = "none";
			tampilDiv2.style.display = "none";
			document.getElementById("ekspedisi1").removeAttribute("required");
			document.getElementById("layanan1").removeAttribute("required");
			document.getElementById("ekspedisi2").removeAttribute("required");
			// document.getElementById("prov").setAttribute("required", true);
			// document.getElementById("kota").setAttribute("required", true);
			// document.getElementById("Virtual Account").setAttribute("required", true);
			// document.getElementById("layanan").setAttribute("required", true);
			// document.getElementById("ongkir").setAttribute("required", true);

		}
	}
</script>