<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Istanbul Gourmet Market</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Your custom styles -->
    <style>
        /* Add your custom styles here */
        body {
            padding-top: 60px; /* Adjust according to your navbar height */
        }
    </style>
</head>
<body>

@include('templates.header')

<div class="container mt-5">
    <div class="col-lg">
        <div class="mb-4">
            <h2 class="display-4">Welcome to Istanbul Gourmet Market!</h2>
        </div>

        <!-- Carousel -->
        <div id="carouselExample" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="image1.jpg" class="d-block w-100" alt="Image 1">
                </div>
                <div class="carousel-item">
                    <img src="image2.jpg" class="d-block w-100" alt="Image 2">
                </div>
                <div class="carousel-item">
                    <img src="image3.jpg" class="d-block w-100" alt="Image 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Card for updates -->
        <div class="card mb-4">
            <!-- Card content... -->
        </div>

        <!-- Available Brands -->
        <div class="mb-4">
            <h4>Sponsored Brands include:</h4>
            <div class="d-flex justify-content-between align-items-center">
                <img src="brand1.jpg" alt="Brand 1" class="img-fluid brand-logo">
                <img src="brand2.jpg" alt="Brand 2" class="img-fluid brand-logo">
                <img src="brand3.jpg" alt="Brand 3" class="img-fluid brand-logo">
                <!-- Add more brand images as needed -->
            </div>
        </div>
    </div>


</div>


@include('templates.footer')

<!-- Bootstrap JS and Popper.js (if needed) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
