<?php
require_once "config.php";
session_start();
$userid = $_SESSION['id'];
if (!isset($userid) || empty($userid)) {
    header("Location: sin-up.php");
    exit();
}
if (isset($_POST['home'])) {
    header("Location: teacher_page.php");
}
if (isset($_POST['Exit'])) {
    session_destroy();
    header("Location: sin-up.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>UPDATE-STUDENT</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
            }
        body {
            box-sizing: border-box;
            background-color: ghostwhite;
            min-height: 100vh;
            width: 100%;
        }

        .absolute {
            position: absolute;
            top: 50px !important;
            inset: 0;
            justify-content: center;
            display: inline-flex;
            flex-direction: row;
        }

        .justify-content {
            justify-content: center;
        }

        .bg-shape1 {
            width: 400px;
            height: 400px;
            border-radius: 9999px;
            position: relative;
            animation: one 10s infinite;
        }

        .bg-shape2 {
            width: 300px;
            height: 300px;
            border-radius: 9999px;
            position: relative;
            animation: two 10s infinite;
        }

        @keyframes one {
            0% {
                left: 0px;
                top: 0px;
            }

            25% {
                left: -100px;
                top: 70px;
            }

            50% {
                left: 20px;
                top: 150px;
            }

            75% {
                left: 50px;
                top: 100px;
            }

            100% {
                left: 0px;
                top: 0px;
            }
        }

        @keyframes two {
            0% {
                left: 0px;
                top: 0px;
            }

            25% {
                left: -50px;
                top: 10px;
            }

            50% {
                left: 100px;
                top: 50px;
            }

            75% {
                left: 50px;
                top: 100px;
            }

            100% {
                left: 0px;
                top: 0px;
            }
        }

        .opacity-50 {
            opacity: .5;
        }

        .bg-blur {
            filter: blur(90px);
        }

        .bg-primary {
            background-color: rgb(30, 0, 255);
        }

        .bg-teal {
            background-color: rgb(255, 72, 173);
        }

        .bg-purple {
            background-color: rgb(140, 0, 215);
        }
        .header {
            position: relative;
            margin: 0;
            width: 100%;
        }

        .ab {
            font-size: 2rem;
            color: black;
            margin-right: 5px;
            margin-top: 2px;
            background-color: transparent;
        }

        .bb {
            font-size: 1.8rem;
            color: black;
            margin-right: 5px;
            background-color: transparent;
            cursor: pointer;
            border: none;
        }

        .aa {
            font-size: 2.5rem;
            color: black;
            margin-right: 5px;
            background-color: transparent;
            cursor: pointer;
            border: none;
        }

        .cc {
            font-size: 2.2rem;
            color: black;
            margin-right: 5px;
            cursor: pointer;
            margin-top: 3px;
        }

        .bb:hover {
            box-shadow: 0 0 30px rgba(0, 0, 0, .3);
            border-radius: 20px;
            color: red;
        }

        .aa:hover {
            box-shadow: 0 0 30px rgba(0, 0, 0, .3);
            border-radius: 20px;
            color: yellowgreen;
        }
        .box2 {
            background-color: lightgray;
            width: 80%;
            height: 90vh;
            text-align: justify;

        }
        .box2 {
            background-color: lightgray;
            width: 100%;
            height: 90vh;
            text-align: justify;

        }

        .but {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            background-color: #fff;
            color: #27282c;
            font-size: 1em;
            letter-spacing: 0.1em;
            font-weight: 400;
            padding: 10px 20px;
            transition: 0.5s;
            border: 1px solid black;
            cursor: pointer;
        }

        .but:hover {
            letter-spacing: 0.25em;
            background: var(--clr);
            color: var(--clr);
            box-shadow: 0 0 35px var(--clr);
            border: none;
        }

        .but::before {
            content: '';
            position: absolute;
            inset: 2px;
            background-color: #fff;
        }

        .but span {
            position: relative;
            z-index: 1;
        }

        .but i {
            position: absolute;
            inset: 0;
            display: block;
        }

        .but i::before {
            content: '';
            position: absolute;
            top: 0;
            left: 80%;
            width: 10px;
            height: 4px;
            background-color: #27282c;
            transform: translateX(-50%) skewX(325deg);
            transition: 0.5s;
        }

        .but:hover i::before {
            width: 20px;
            left: 20%;
        }

        .but i::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 20%;
            width: 10px;
            height: 4px;
            background-color: #27282c;
            transform: translateX(-50%) skewX(325deg);
            transition: 0.5s;
        }

        .but:hover i::after {
            width: 20px;
            left: 80%;
        }
    </style>
</head>
<body>
<div class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="offcanvasWithBothOptions" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <p class="ab">Profile</p>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li>
                            <ion-icon class="aa" name="person-circle-outline" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"></ion-icon>
                        </li>
                    </ul>
                    <form class="d-flex" role="search" method="post">
                        <i class="fa-solid fa-graduation-cap cc"></i>
                        <i class="fa-solid fa-circle-info cc"></i>
                        <button class="bb" type="button" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" fdprocessedid="njkfkq"><i class="fa-solid fa-person-walking-dashed-line-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </nav>
    </div>
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">"HELLO!"</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Try scrolling the rest of the page to see this option in action.</p>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center h1">
                    Do you want to log-out or move to home-page!
                </div>
                <form action="" method="post">
                <div class="modal-footer justify-content-center">
                    <button class="but" style="--clr:#ff1867" type="submit" id="Exit" name="Exit"><span>LOG-OUT</span><i></i></button>
                    <button class="but" style="--clr:darkgreen" type="submit" id="home" name="home"><span>HOME</span><i></i></button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="absolute">
        <div class="absolute inset-0 justify-content">
            <div class="bg-shape1 bg-teal opacity-50 bg-blur"></div>
            <div class="bg-shape2 bg-primary opacity-50 bg-blur"></div>
            <div class="bg-shape3 bg-purple opacity-50 bg-blur"></div>
        </div>
    </div>
    <div class="box2">
        <center>

        </center>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://kit.fontawesome.com/5a54b76202.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>