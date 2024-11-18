<?php
require_once "config.php";
session_start();
$userid = $_SESSION['id'];
if (!isset($userid) || empty($userid)) {
    header("Location: sin-up.php");
    exit();
}
if (isset($_POST['start'])) {
    header("Location:start.php");
}
if (isset($_POST['veiw'])) {
    header("Location:veiw.php");
}
if (isset($_POST['marks'])) {
    header("Location:user_result.php");
}
if (isset($_POST['print'])) {
    echo "<script>window.print();</script>";
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
    <title>STUDENT LOG IN PAGE</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://kit.fontawesome.com/5a54b76202.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
        }

        body {
            background: linear-gradient(45deg, #d2001a, #7462ff, #f48e21, #23d5ad);
            background-size: 300% 300%;
            width: 100%;
            min-height: 100vh;
            box-sizing: border-box;
            background-repeat: repeat-y;
            text-align: justify;
            animation: color 12s ease-in-out infinite;
        }

        @keyframes color {
            0% {
                background-position: 0 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0 50%;
            }
        }

        .header {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            padding: .5em 1%;
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }


        .logo {
            font-size: 1.7rem;
            transition: .5s ease;
            color: black;
            border: none;
        }

        .logo:hover {
            color: yellowgreen;
        }

        .navbar a,
        .navbar button {
            font-size: 1.7rem;
            color: black;
            margin-left: 1rem;
            border: none;
            transition: .5s ease;
        }

        .navbar a:hover {
            color: #7462ff;
        }

        .bb {
            background-color: red;
            padding: 5px;
            border-radius: 10px;
        }

        .bb:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 1);
            color: white;
        }

        .but {
            display: flex;
            width: 100%;
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
            margin-top: 20px;
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

        .box1 {
            background-color: #edeef1;
            width: 20%;
            height: 89.8vh;
        }

        .box2 {
            width: 80%;
            height: 89.4vh;
            text-align: justify;

        }

        .matter {
            font-size: 1rem;
            margin: 10px;
        }

        .box {
            width: 50%;
            height: auto;
            background-color: black;
            color: #fff;
            padding: 20px;
            font-size: 2rem;
            font-weight: 300;
            font-family: sans-serif;
            border-radius: 30px;
        }
    </style>
</head>

<body>
    <header class="header">
        <button class="logo" style="background-color: transparent;" name="person-circle-outline" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><i class='bx bx-user-circle'></i> Profile</button>

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">"HELLO!"</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <p>Try scrolling the rest of the page to see this option in action.</p>
            </div>
        </div>
        <nav class="navbar">
            <a href=""><i class='bx bxl-linkedin-square'> linkedin</i> </a>
            <a href=""><i class='bx bxl-meta'> Meta</i></a>
            <a href=""><i class='bx bxs-buildings'> Servicer</i></a>
            <a href=""><i class='bx bx-info-circle'> About</i></a>

            <button class="bb" type="button" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" fdprocessedid="njkfkq"><i class="fa-solid fa-person-walking-dashed-line-arrow-right"></i> Back</button>
        </nav>

    </header>
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
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form class="row container-fluid" method="post">
        <div class="col-3 box1 container">
            <div class="row buttons">
                <div class="col-12">
                    <button class="but" style="--clr:#1e9bff" id="start" name="start"><span>START EXAM</span><i></i></button>
                </div>
            </div>
            <div class="row buttons">
                <div class="col-12">
                    <button class="but" style="--clr:#6eff3e" id="veiw" name="veiw"><span>VEIW EXAM'S</span><i></i></button>
                </div>
            </div>
            <div class="row buttons">
                <div class="col-12">
                    <button class="but" style="--clr:#ff1867" id="marks" name="marks"><span>MARK'S</span><i></i></button>
                </div>
            </div>
            <div class="row buttons">
                <div class="col-12">
                    <button class="but" style="--clr:yellow" id="print" name="print"><span>PRINT DETAILES</span><i></i></button>
                </div>
            </div>
        </div>

        <div class="col-9 box2">
            <center>
                <div class="row matter">
                    <h1>Welcome, Good to see you!</h1><br>
                    <h4>All the best for you Exam's</h4>
                </div>
                <div class="card box">
                    <div class="card-body">
                        <?php
                        $data = mysqli_query($conn, "SELECT student_id, student_name, student_mail, gender, branch, phone_no FROM student_login WHERE student_id='$userid'");

                        if ($data) {
                            $userData = mysqli_fetch_assoc($data);
                        ?>
                            <p class="card-title">User ID: <?php echo $userData['student_id']; ?></p>
                            <p class="card-text">Name: <?php echo $userData['student_name']; ?></p>
                            <p class="card-text">Email: <?php echo $userData['student_mail']; ?></p>
                            <p class="card-text">Gender: <?php echo $userData['gender']; ?></p>
                            <p class="card-text">Branch: <?php echo $userData['branch']; ?></p>
                            <p class="card-text">Phone Number: <?php echo $userData['phone_no']; ?></p>
                        <?php
                        } else {
                            echo "<p>No user data found!</p>";
                        }
                        ?>
                    </div>
                </div>
            </center>
        </div>


    </form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://kit.fontawesome.com/5a54b76202.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>