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
if (isset($_POST['create_student'])) {
    $studentID = $_POST['studentID'];
    $studentName = $_POST['studentName'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $branch = $_POST['branch'];
    $phoneNo = $_POST['phoneNo'];
    $password = $_POST['password'];

    $sql = "INSERT INTO student_login (student_id, student_name, student_mail, gender, branch, phone_no, password) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "issssss", $studentID, $studentName, $email, $gender, $branch, $phoneNo, $password);

        if (mysqli_stmt_execute($stmt)) {
            echo '
                <script>
                    Swal.fire({
                      icon: "success",
                      title: "Student created successfully",
                      showConfirmButton: false,
                      timer: 1500
                    }).then(function() {
                        window.location = "teacher_page.php";
                    });
                </script>';
        } else {
            echo '
                <script>
                    Swal.fire({
                      icon: "error",
                      title: "Error creating student",
                      text: "Please try again later.",
                    });
                </script>';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo '
            <script>
                Swal.fire({
                  icon: "error",
                  title: "Error preparing SQL statement",
                  text: "Please try again later.",
                });
            </script>';
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>CREATE-STUDENT</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        * {
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
            margin-left: 1.1rem;
            border: none;
            transition: .5s ease;
        }

        .navbar a:hover {
            color: #7462ff;
        }
        .bb{
            background-color: red;
            padding: 5px;
            border-radius: 10px;
        }
        .bb:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 1);
            color: white;
        }

        .box2 {
            background-color: black;
            color: aliceblue;
            width: 100%;
            height: 91.3vh;
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

        .id {
            justify-content: center;
            width: 50%;
            height: 80vh;
            position: relative;
            top: 40px;
            letter-spacing: 10px;
        }

        .mat {
            position: relative;
            left: 35px;
        }

        #strength {
            margin: 5px;
            text-align: center;
        }

        .strength-good {
            color: green;
        }

        .strength-bad {
            color: red;
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
        <!-- <i class='bx bx-menu' id="menu-icon"></i> -->
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
                        <button class="but" style="--clr:darkgreen" type="submit" id="home" name="home"><span>BACK</span><i></i></button>
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
            <form class="row g-3 needs-validation id" action="" novalidate="" method="post">
                <div class="row display-4 mat">CREATE STUDENT fORM</div>

                <div class="col-md-4 position-relative">
                    <label for="validationTooltip01" class="form-label">STUDENT ID</label>
                    <input type="number" class="form-control" id="validationTooltip01" name="studentID" placeholder="enter the id" required="" fdprocessedid="wm0ph">
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-4 position-relative">
                    <label for="validationTooltip02" class="form-label">STUDENT NAME</label>
                    <input type="text" class="form-control" id="validationTooltip02" name="studentName" placeholder="enter the name" required="" fdprocessedid="wm0ph">
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-4 position-relative">
                    <label for="validationTooltipUsername" class="form-label">G-MAIL</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
                        <input type="email" class="form-control" name="email" id="validationTooltipUsername" aria-describedby="validationTooltipUsernamePrepend" required="" fdprocessedid="xy6qbo" placeholder="enter the mail">
                        <div class="invalid-tooltip">
                            Please choose a unique and valid e-mail.
                        </div>
                    </div>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="validationTooltip03" class="form-label">GENDER</label>
                    <select class="form-select" name="gender" id="validationTooltip03" required="" fdprocessedid="qwz6cd">
                        <option selected="">choose...</option>
                        <option value="male">male</option>
                        <option value="female">female</option>
                    </select>
                    <div class="invalid-tooltip">
                        Please select a gender.
                    </div>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="validationTooltip04" class="form-label">BRANCH</label>
                    <select class="form-select" name="branch" id="validationTooltip04" required="" fdprocessedid="qwz6cd">
                        <option selected="">choose...</option>
                        <option value="ECE">ECE</option>
                        <option value="EEE">EEE</option>
                        <option value="IT">IT</option>
                        <option value="CSE">CSE</option>
                    </select>
                    <div class="invalid-tooltip">
                        Please select a Branch.
                    </div>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="validationTooltip05" class="form-label">MOBILE NO</label>
                    <input type="tel" class="form-control" name="phoneNo" id="validationTooltip05" placeholder="enter the phone no" required="" oninput="formatMobileNumber()" fdprocessedid="wm0ph">
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-4 position-relative">
                    <label for="validationTooltip06" class="form-label">PASSWORD</label>
                    <input type="password" class="form-control" name="password" oninput="checkPasswordStrength()" id="validationTooltip06" placeholder="enter the password" required="" fdprocessedid="wm0ph">
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <div id="strength">
                    <div class="form-check requirement">
                        <input type="radio" class="form-check-input" id="length-radio" name="length" disabled>
                        <label class="form-check-label" for="length-radio">8 CHARACTERS</label>
                    </div>
                    <div class="form-check requirement">
                        <input type="radio" class="form-check-input" id="numbers-radio" name="numbers" disabled>
                        <label class="form-check-label" for="numbers-radio">2 NUMBERS</label>
                    </div>
                    <div class="form-check requirement">
                        <input type="radio" class="form-check-input" id="special-radio" name="special" disabled>
                        <label class="form-check-label" for="special-radio">1 SPECIAL CHARACTER</label>
                    </div>
                    <div class="form-check requirement">
                        <input type="radio" class="form-check-input" id="capital-radio" name="capital" disabled>
                        <label class="form-check-label" for="capital-radio">1 CAPITAL LETTER</label>
                    </div>
                </div>
                <div class="col-md-4 position-relative">
                    <label for="validationTooltip07" class="form-label">CONFORM PWD</label>
                    <input type="password" class="form-control" id="validationTooltip07" oninput="checkPasswordMatch()" placeholder="enter the password" required="" fdprocessedid="wm0ph">
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <div class="col-12">
                    <button class="but" type="submit" id="create_student" name="create_student" style="--clr:#6eff3e" onclick="validateForm()" fdprocessedid="7ikvy8" disabled><span>CREATE</span><i></i></button>
                </div>
            </form>
        </center>
    </div>
    <Script>
        function formatMobileNumber() {
        const mobileInput = document.getElementById('validationTooltip05');
        const inputValue = mobileInput.value;

        if (/^\d+$/.test(inputValue)) {
          if (inputValue.length === 10) {
            mobileInput.value = '+91 ' + inputValue.substring(0, 3) + '-' + inputValue.substring(3, 6) + '-' + inputValue.substring(6);
          }
        } else {
          console.log('Invalid input. Please enter a valid 10-digit mobile number.');
        }
      }

        function checkPasswordStrength() {
            const password = document.getElementById('validationTooltip06').value;

            const lengthRadio = document.getElementById('length-radio');
            const numbersRadio = document.getElementById('numbers-radio');
            const specialRadio = document.getElementById('special-radio');
            const capitalRadio = document.getElementById('capital-radio');

            lengthRadio.checked = password.length >= 8;
            numbersRadio.checked = /\d{2,}/.test(password);
            specialRadio.checked = /[^A-Za-z0-9]/.test(password);
            capitalRadio.checked = /[A-Z]/.test(password);

            const allRequirementsMet = lengthRadio.checked && numbersRadio.checked && specialRadio.checked && capitalRadio.checked;

            const passwordStrength = document.getElementById('strength');

            if (allRequirementsMet) {
                passwordStrength.classList.add('strength-good');
                passwordStrength.classList.remove('strength-bad');
            } else {
                passwordStrength.classList.add('strength-bad');
                passwordStrength.classList.remove('strength-good');
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('validationTooltip06').value;
            const confirmPassword = document.getElementById('validationTooltip07').value;

            const loginBtn = document.getElementById('create_student');

            if (password === confirmPassword) {
                loginBtn.classList.add('enabled');
                loginBtn.disabled = false;
            } else {
                loginBtn.classList.remove('enabled');
                loginBtn.disabled = true;
            }
        }
    </Script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://kit.fontawesome.com/5a54b76202.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>