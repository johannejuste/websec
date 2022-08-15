<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/roots.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/singleProduct.css">
    <link rel="stylesheet" href="/css/replies.css">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>APP</title>
</head>

<body>
    <header id="header">
        <nav>
            <a href="/index"><img src="/assets/imgs/logo.png" alt="logo"></a>
        </nav>

        <div class="header-profile">
            <a class="mobile-hide button medium_button" href="/create-product">create product</a>
            <a class="small_profile_picture"><img src="/profile-uploads/<?= $_SESSION['user_image'] ?>" alt="image"></a>
            <!-- <i class="header-chevron fas fa-chevron-down"></i> -->
        </div>

        <div class="profile-options-container">
            <div class="options">

                <a href="/account">Go to profile <i class="fas fa-chevron-right"></i></a>
                <a href="/create-product">Create Product<i class="fas fa-chevron-right"></i></a>
                <a href="/logout">Logout <i class="fas fa-chevron-right"></i></a>
            </div>

        </div>
    </header>