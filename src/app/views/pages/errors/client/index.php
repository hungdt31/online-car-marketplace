<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT ?>/assets/static/css/error.css" />
</head>

<body>
    <div class="header">
        <div>
            <h2>Website</h2>
            <p>Title</p>
        </div>
        <a href="/">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-back" viewBox="0 0 16 16">
                    <path d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z" />
                </svg>
                <span>Home Page</span>
            </button>
        </a>
    </div>
    <div class="content">
        <div class="block">
            <p>
                <?php
                echo '<strong>ERROR CODE  ></strong> ' . $error_code . '<br>';
                switch ($error_code) {
                    case "404":
                        echo '<dotlottie-player src="https://lottie.host/bc27900b-97cf-49c3-aa66-89836a7c6345/iSjmy9zJQS.lottie" background="transparent" speed="1" style="width: 400px; height: 400px; margin: 0 auto;" loop autoplay></dotlottie-player>';
                        break;
                    case "403":
                        echo '<dotlottie-player src="https://lottie.host/64ea3a4f-beba-42fa-bca3-bbfed241152e/bGnBvHFmkF.lottie" background="transparent" speed="1" style="width: 400px; height: 400px; margin: 0 auto;" direction="1" playMode="forward" loop autoplay></dotlottie-player>';
                        break;
                    default:
                        echo "Something went wrong!";
                }
                ?>
            </p>
        </div>
        <div class="block">
            
            <?php
                switch ($error_code) {
                    case "404":
                        echo '<p class="error-text">The page you are looking for might have been removed, had its name changed or is temporarily unavailable</p>';
                        break;
                    case "403":
                        echo '<p class="error-text">You don\'t have permission to access this page</p>';
                        break;
                    default:
                        echo "Something went wrong!";
                }
                ?>
        </div>
        <div class="block"></div>
    </div>
    <div class="footer">
        <div>
            <h4>Lorem ipsum dolor sit amet consectetur</h4>
            <p>Contact: <span style="color: #088DA5;">koikoidth12@gmail.com</span></p>
        </div>
        <div>
            <div>
                <a href="https://www.facebook.com/koikoidth12" target="_blank">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="https://www.instagram.com/koikoidth12" target="_blank">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="https://www.twitter.com/koikoidth12" target="_blank">
                    <i class="bi bi-twitter"></i>
                </a>
            </div>
        </div>
    </div>
</body>

</html>