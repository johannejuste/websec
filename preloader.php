<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/landing.css">
    <link rel="stylesheet" href="/css/slideUpanimation.css">
    <link rel="stylesheet" href="/css/animations.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title>Landing.</title>
</head>

<body class="background">

    <!--     <div class="background preloader"> -->



    <div id="preloader2">
        <img class="hithere" src="/assets/png/discord-icon-43736.png" alt="logo">
    </div>
    <div class="wap">
        <br><br><br><br><br><br>
        <h2><span>Did you know</span> Henrik <cite>f%!#*n</cite> hates JavaScript?</h2>
    </div>

    <main data-target="slide-content">
        <?php
        //require_once($_SERVER['DOCUMENT_ROOT'] . '/login.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/views_login/view_login.php');

        ?>

    </main>



    <!--     </div> -->
    <script src="/js/preloader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>

</html>