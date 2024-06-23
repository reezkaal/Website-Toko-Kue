<div class="container-fluid bg-dark text-light footer my-6 mb-0 py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-5 col-md-6">
                <h4 class="text-light mb-4">Kontak</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>JL.Sabi Raya RT/05 RW/02 No.29 Kel.Bencongan, Kec.Kelapa Dua, Kab.Tangerang, Banten.</p>
                <a class="btn btn-link" href="https://wa.me/62895343919847"><i class="fab fa-whatsapp me-3"></i>0895 3439 19847</a>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>kedaikanzoe@gmail.com</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Tautan</h4>
                <a class="btn btn-link" href="index.php">Home</a>
                <a class="btn btn-link" href="produk.php">Produk</a>
                <a class="btn btn-link" href="daftar.php">Daftar</a>
                <a class="btn btn-link" href="login.php">Login</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Map</h4>
                <div class="row g-2">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3966.4221810228355!2d106.60134800000002!3d-6.207913!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNsKwMTInMjguNSJTIDEwNsKwMzYnMDQuOSJF!5e0!3m2!1sid!2sid!4v1718742049229!5m2!1sid!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid copyright text-light py-4 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                &copy; Kedai Kanzoe, All Right Reserved.
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_SESSION["pengguna"])) { ?>
    <?php
    $id = $_SESSION["pengguna"]['id'];
    $ambil = $koneksi->query("SELECT *FROM pengguna WHERE id='$id'");
    $pecah = $ambil->fetch_assoc(); ?>
    <a class="random-icon" href="chat.php" target="_blank">
        <i class="far fa-comments my-float"></i>
    </a>
    <a class="whats-app" href="https://wa.me/62895343919847" target="_blank">
        <i class="fab fa-whatsapp my-float"></i>
    </a>
<?php } else { ?>
    <a class="whats-app" href="https://wa.me/62895343919847" target="_blank">
        <i class="fab fa-whatsapp my-float"></i>
    </a>
<?php } ?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="home/lib/wow/wow.min.js"></script>
<script src="home/lib/easing/easing.min.js"></script>
<script src="home/lib/waypoints/waypoints.min.js"></script>
<script src="home/lib/counterup/counterup.min.js"></script>
<script src="home/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="home/js/main.js"></script>
<script>
    $(document).ready(function() {
        $('.scroll-button').click(function() {
            var target = $(this).data('scroll-to');
            var position = 0;

            if (target === 'middle') {
                position = $('.container').offset().top;
            } else if (target === 'bottom') {
                position = $(document).height();
            }

            $('html, body').animate({
                scrollTop: position
            }, 1000);
        });
    });
</script>
</body>

</html>