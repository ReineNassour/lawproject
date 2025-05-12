<?php
session_start();
include 'checkStatus.php';
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TheFirm | Contact Us</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Law Firm, Legal Services, Attorneys, Contact" name="keywords">
    <meta content="Contact our legal experts for consultation and inquiries" name="description">

    <!-- Favicon -->
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animation -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">

    <!-- Carousel -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Custom Styles -->
   
    <link href="css/contact.css" rel="stylesheet">

</head>

<body>
    <!-- Page Header Start -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Contact Us</h2>
                </div>
                <div class="col-12">
                    <div class="breadcrumb">
                        <a href="index.php">Home</a>
                        <a href="contact.php">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
            <div class="section-header">
                <h2>Get In Touch</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fa fa-map-marker-alt"></i>
                            <div class="contact-text">
                                <h2>Location</h2>
                                <p>Qubic Square Business, Sin El Fil, Beirut, Lebanon</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fa fa-phone-alt"></i>
                            <div class="contact-text">
                                <h2>Phone</h2>
                                <p>+012 345 67890</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fa fa-envelope"></i>
                            <div class="contact-text">
                                <h2>Email</h2>
                                <p>thefirm.contact.leb@gmail.com</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fa fa-clock"></i>
                            <div class="contact-text">
                                <h2>Office Hours</h2>
                                <p>Monday - Friday: 8:00 AM - 9:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-form">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your Name" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Your Email" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Subject" required="required" />
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Message" required="required" rows="5"></textarea>
                            </div>
                            <div>
                                <button class="btn" type="submit">
                                    <i class="fa fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <?php include 'footer.php'; ?>

    <!-- Back to Top -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Sticky Header
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('.header').addClass('sticky');
            } else {
                $('.header').removeClass('sticky');
            }
        });

        // Back to Top Button
        $(window).scroll(function() {
            if ($(this).scrollTop() > 200) {
                $('.back-to-top').addClass('active');
            } else {
                $('.back-to-top').removeClass('active');
            }
        });

        $('.back-to-top').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    </script>
</body>

</html>