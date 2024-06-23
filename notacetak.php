<?php
function rupiah($angka)
{
    $hasilrupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasilrupiah;
}
include('koneksi.php');
function tanggal($tgl)
{
    $tanggal = substr($tgl, 8, 2);
    $bulan = getBulan(substr($tgl, 5, 2));
    $tahun = substr($tgl, 0, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
function getBulan($bln)
{
    switch ($bln) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}
$idpem = $_GET["id"];
$ambil = $koneksi->query("SELECT*FROM pemesanan JOIN pengguna
ON pemesanan.id=pengguna.id
WHERE pemesanan.idpenjualan='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
?>
<html>

<head>
    <title>Kedai Kanzoe</title>
    <style>
        @page {
            margin: 3mm;
        }
    </style>
    <style>
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 1px;
        }
    </style>
</head>
 <center>
<body style='font-family:tahoma; font-size:8pt;padding-top:50px'>
    <table width="530px">
        <tr>
            <td style="padding-right:5px"><img src="foto/logo.jpg" width="125"></td>
            <td>
                    <font size="6"><b>Kedai Kanzoe</b></font><br>
                    <font size="2">JL.Sabi Raya RT/05 RW/02 No.29 Kel.Bencongan, Kec.Kelapa Dua, Kab.Tangerang, Banten.
                    </font><br>
                </center>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <hr style="border-top: 1px solid black;width:660">
    <br>
    <center>
        <table style='width:660; font-size:16pt; font-family:calibri; border-collapse: turunbawah;' border='0'>
            <tr>
                <td style="width:150px">
                    <span style="font-size:11pt">No. Nota</span>
                </td>
                <td>
                    <span style="font-size:11pt"> : <?= $pecah['notransaksi'] ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="font-size:11pt">Tanggal</span>
                </td>
                <td>
                    <span style="font-size:11pt"> : <?= tanggal(date('Y-m-d', strtotime($pecah['tanggalbeli']))) ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="font-size:11pt">Nama</span>
                </td>
                <td>
                    <span style="font-size:11pt"> : <?= $pecah['nama'] ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="font-size:11pt">Alamat</span>
                </td>
                <td>
                    <span style="font-size:11pt"> : <?= $pecah['alamat'] ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="font-size:11pt">No. HP</span>
                </td>
                <td>
                    <span style="font-size:11pt"> : <?= $pecah['telepon'] ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="font-size:11pt">Metode Pengiriman</span>
                </td>
                <td>
                    <span style="font-size:11pt"> : <?= $pecah['metodepengiriman'] ?></span>
                </td>
            </tr>
        </table>
        <br><br>
        <table cellspacing='0' cellpadding='0' style='width:660; font-size:12pt; font-family:calibri; border-collapse: turunbawah;' border='1'>
            <thead>
                <tr>
                    <th style="padding:5px;margin:5px">No</th>
                    <th width="40%">Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor = 1; ?>
                <?php $ambildetail = $koneksi->query("SELECT * FROM penjualan WHERE idpenjualan='$_GET[id]'"); ?>
                <?php while ($detail = $ambildetail->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo $detail['nama']; ?></td>
                        <td align="left"><?php echo rupiah($detail['harga']); ?></td>
                        <td align="center"><?php echo $detail['jumlah']; ?></td>
                        <td style="padding:5px;margin:5px"><?php echo rupiah($detail['subharga']); ?></td>
                    </tr>
                    <?php $nomor++; ?>
                <?php } ?>
                <tr>
                    <td colspan="4" style="text-align:right">Total Harga : &nbsp;</b></em></td>
                    <td class="text-hijau" style="padding:5px;margin:5px"><?php echo rupiah($pecah['totalbeli']) ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:right">Ongkir : &nbsp;</b></em></td>
                    <td class="text-hijau" style="padding:5px;margin:5px"><?php echo rupiah($pecah['ongkir']) ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:right">Grand Total : &nbsp;</b></em></td>
                    <td class="text-hijau" style="padding:5px;margin:5px"><?php echo rupiah($pecah['totalbeli'] + $pecah['ongkir']) ?></td>
                </tr>
            </tbody>
        </table>
        <br><br>
        <table cellspacing='0' cellpadding='0' style='width:550px; font-size:11pt; font-family:calibri; border-collapse: turunbawah;'>
            <tr>
                <td width="60"><br><br><br><br></td>
                <?php
                $now = date("Y-m-d");

                ?>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Penerima <br><br><br><br><br>(.....................)</td>
                <td width="130"><br><br><br><br></td>
                <?php
                $now = date("Y-m-d");

                ?>
                <td>Hormat Kami, <br><br><br><br><br>(.....................)</td>
            </tr>
        </table>
    </center>
</body>

</html>
<script>
    window.print();
</script>