<?php
include 'header.php';
include '../db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TheFirm | Our Attorneys</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Law Firm, Legal Services, Attorneys, Legal Team" name="keywords">
    <meta content="Meet our expert team of attorneys specializing in various legal practices" name="description">

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

    <link href="css/attorneystyle.css" rel="stylesheet">

    <style>
    .page-header {
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f5f5;
        padding: 20px 0;
    }

    .rating {
        direction: rtl;
        text-align: center;
    }

    .rating input {
        display: none;
    }

    .rating label {
        font-size: 30px;
        color: gray;
        cursor: pointer;
    }

    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
        color: gold;
    }

    .attorney-card {
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    margin-bottom: 30px;
}

.attorney-card:hover {
    transform: translateY(-5px);
}

.attorney-image img {
    width: 100%;
    height: 300px;
    object-fit: cover;
}

.attorney-info {
    padding: 20px;
    text-align: center;
}

.attorney-info h3 {
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 20px;
    color: #343a40;
}

.attorney-meta-item {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    margin-bottom: 8px;
}

.attorney-meta-item i {
    margin-right: 8px;
}

.attorney-text {
    font-size: 14px;
    color: #555;
    margin-bottom: 15px;
}

    </style>
</head>

<body>
    <br><br><br>
    <section class="attorneys-section">
        <div class="container">
           
            <div class="row">
                <?php
                $sql = "SELECT * FROM user WHERE role=2";
                $res = $conn->query($sql);

                if ($res && $res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        $id = $row['id'];

                        $sql1 = "SELECT * FROM attorneys WHERE userid='$id'";
                        $res1 = $conn->query($sql1);
                        $specializationText = "";
                        if ($res1 && $res1->num_rows > 0) {
                            $row1 = $res1->fetch_assoc();
                            $specializationText = $row1['specialized'];
                        }

                        $sql2 = "SELECT * FROM cv WHERE userid='$id'";
                        $res2 = $conn->query($sql2);
                        $graduationYear = "";
                        $university = "";
                        $description = "";
                        if ($res2 && $res2->num_rows > 0) {
                            $row2 = $res2->fetch_assoc();
                            $graduationYear = $row2['year'];
                            $university = $row2['university'];
                            $description = $row2['description'];
                        }
                ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="attorney-card">
                                <div class="attorney-image">
                                <img src="../<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?>" class="img-fluid rounded shadow-sm">
                                </div>
                                <div class="attorney-info">
                                    <h3><?= htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></h3>

                                    <div class="attorney-meta">
                                        <?php if (!empty($specializationText)) { ?>
                                            <div class="attorney-meta-item">
                                                <i class="fas fa-gavel"></i>
                                                <p><?= htmlspecialchars($specializationText); ?> Law</p>
                                            </div>
                                        <?php } ?>
                                        <?php if (!empty($graduationYear)) { ?>
                                            <div class="attorney-meta-item">
                                                <i class="fas fa-calendar-alt"></i>
                                                <p>Graduated <?= htmlspecialchars($graduationYear); ?></p>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <?php if (!empty($university)) { ?>
                                        <p class="attorney-text"><?= htmlspecialchars($university); ?></p>
                                    <?php } ?>

                                    <a class="btn btn-outline" href="#" data-bs-toggle="modal" data-bs-target="#attorneyModal<?= $id; ?>">
                                        Read More <i class="fas fa-angle-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="attorneyModal<?= $id; ?>" tabindex="-1" aria-labelledby="attorneyModalLabel<?= $id; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="attorneyModalLabel<?= $id; ?>">
                                            <?= htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?> -
                                            <?php if (!empty($specializationText)) { ?>
                                                Specialized in <?= htmlspecialchars($specializationText); ?> Law
                                            <?php } else { ?>
                                                Attorney at TheFirm
                                            <?php } ?>
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-4 mb-md-0">
                                                <img src="../<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?>" class="img-fluid rounded">
                                            </div>
                                            <div class="col-md-8">
                                                <h4>Professional Profile</h4>
                                                <?php if (!empty($description)) { ?>
                                                    <p><?= nl2br(htmlspecialchars($description)); ?></p>
                                                <?php } else { ?>
                                                    <p><?= htmlspecialchars($row['fname']); ?> is a dedicated attorney specializing in <?= htmlspecialchars($specializationText); ?> Law. They are committed to delivering outstanding legal support and client advocacy.</p>
                                                <?php } ?>

                                                <?php if (!empty($university)) { ?>
                                                    <h4 class="mt-4">Education</h4>
                                                    <p><?= htmlspecialchars($university); ?>, Class of <?= htmlspecialchars($graduationYear); ?></p>
                                                <?php } ?>

                                                <h4 class="mt-4">Contact Information</h4>
                                                <p><i class="fas fa-envelope me-2"></i> <?= htmlspecialchars(strtolower($row['fname'] . '.' . $row['lname'])); ?>@thefirm.com</p>
                                                <p><i class="fas fa-phone me-2"></i> (123) 456-7890</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <a href="contract.php?id=<?= $id ; ?>" class="btn btn-primary">
                                        <i class="fas fa-credit-card mr-2"></i> Contract
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<div class="col-12"><p class="text-center">No attorneys found.</p></div>';
                }
                ?>
            </div>
        </div>
    </section>

    <br><br>
    <?php include 'footer.php'; ?>

    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script>
        $(window).scroll(function () {
            $('.header').toggleClass('sticky', $(this).scrollTop() > 100);
            $('.back-to-top').toggleClass('active', $(this).scrollTop() > 200);
        });

        $('.back-to-top').click(function () {
            $('html, body').animate({ scrollTop: 0 }, 800);
            return false;
        });
    </script>
</body>

</html>
