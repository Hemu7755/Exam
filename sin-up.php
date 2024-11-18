<?php
require_once "config.php";

if (isset($_POST['submit'])) {
    $userid = mysqli_real_escape_string($conn, $_POST['user_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $stmt_teacher = $conn->prepare("SELECT teacher_id FROM teacher_login WHERE status='1' AND BINARY teacher_id = ? AND BINARY password = ?") or die(mysqli_error($conn));
    $stmt_teacher->bind_param("ss", $userid, $password);
    $stmt_teacher->execute();
    $stmt_teacher->store_result();
    $teacher_count = $stmt_teacher->num_rows;
    $stmt_teacher->close();

    $stmt_student = $conn->prepare("SELECT student_id FROM student_login WHERE status='1' AND BINARY  student_id = ? AND BINARY password = ?") or die(mysqli_error($conn));
    $stmt_student->bind_param("ss", $userid, $password);
    $stmt_student->execute();
    $stmt_student->store_result();
    $student_count = $stmt_student->num_rows;
    $stmt_student->close();

    if ($teacher_count > 0) {
        $stmt_teacher_pin = $conn->prepare("SELECT teacher_id FROM teacher_login WHERE status='1' AND BINARY  teacher_id = ? AND BINARY password = ?") or die(mysqli_error($conn));
        $stmt_teacher_pin->bind_param("ss", $userid, $password);
        $stmt_teacher_pin->execute();
        $stmt_teacher_pin->store_result();
        $pin_count = $stmt_teacher_pin->num_rows;
        $stmt_teacher_pin->close();

        if ($pin_count > 0) {
            session_start();
            $_SESSION['id'] = $userid;
            $userid = $_SESSION['id'];
            header("location: teacher_page.php");
            exit();
        }
    } elseif ($student_count > 0) {
        $stmt_student_pin = $conn->prepare("SELECT student_id FROM student_login WHERE status='1' AND BINARY  student_id = ? AND BINARY password = ?") or die(mysqli_error($conn));
        $stmt_student_pin->bind_param("ss", $userid, $password);
        $stmt_student_pin->execute();
        $stmt_student_pin->store_result();
        $pin_count = $stmt_student_pin->num_rows;
        $stmt_student_pin->close();

        if ($pin_count > 0) {
            session_start();
            $_SESSION['id'] = $userid;
            $userid = $_SESSION['id'];
            header("location: student_page.php");
            exit();
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login error',
                text: 'Invalid ID or PIN. Please try again.',
            }).then(function() {
                window.location.href = 'sin-up.php';
            });
        </script>
    </body>

    </html>
<?php
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>EXAMINATION</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "poppins", sans-serif;
        }

        body {
            background: #f9f9f9;
            min-height: 100vh;
            overflow-x: hidden;
        }

        header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }

        .header.sticky {
            border-bottom: .1rem solid rgba(0, 0, 0, .2);
        }

        .logo {
            font-size: 3.5em;
            color: #359381;
            pointer-events: none;
            margin-bottom: 10px;
            /* margin-right: 300px; */
            /* align-items: flex-start; */
        }

        .navigation a {
            text-decoration: none;
            color: #359381;
            padding: 6px 10px;
            border-radius: 20px;
            margin-bottom: 5px;
            text-align: center;
            font-weight: 600;
        }

        .navi a {
            font-size: 2.5em;
            padding: 6px 10px;
            text-decoration: none;
            color: white;
            margin-bottom: 5px;
            position: relative;
            text-align: center;
            border-radius: 20px;
            font-weight: 600;
        }

        .navigation a:hover,
        .navigation a:active,
        .navi a:hover,
        .navi a:active {
            background: #359381;
            color: #fff;
        }

        @media (min-width: 576px) {

            .logo {
                margin-right: 20px;
            }

            .navigation,
            .navi {
                width: auto;
                margin-top: 0;
            }

            .navigation a,
            .navi a {
                margin-bottom: 0;
            }
        }

        .parallax {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #well {
            position: absolute;
            font-size: 5em;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, .5);
        }

        .parallax img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            pointer-events: none;
        }

        .sec {
            position: relative;
            background: #003329;
            padding: 20px;
            box-sizing: border-box;
            min-height: 100vh;
            color: white;
            /* text-align: center; */
        }

        .box {
            /* width: 100%; */
            justify-content: center;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            margin-top: 20px;
            padding: 15px;
        }

        @media (min-width: 768px) {
            .sec {
                padding: 40px;
            }

            .box {
                margin-top: 40px;
            }
        }

        @media (min-width: 992px) {

            .col-7,
            .col-3 {
                width: 45%;
                margin: 0 2.5%;
            }
        }

        @media (min-width: 1200px) {

            .col-7,
            .col-3 {
                width: 48%;
                margin: 0 1%;
            }
        }

        .wrapper {
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            background: #359381;
            border: 2px solid rgba(255, 255, 255, .5);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 30px rgba(0, 0, 0, 1);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            transition: height .2s ease;
        }

        .form-box {
            width: 100%;
            padding: 20px;
        }

        .form-box h2 {
            font-size: 2em;
            color: black;
            text-align: center;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            border-bottom: 2px solid black;
            margin: 30px 0;
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 2px;
            transform: translateY(-50%);
            font-size: 1em;
            color: black;
            font-weight: bold;
            pointer-events: none;
            transition: font-size 0.2s ease, top 0.2s ease, color 0.3s ease;
        }

        .input-box input:focus~label,
        .input-box input:valid~label {
            font-size: 0.8rem;
            top: -2px;
            color: rgba(255, 255, 255, rgba(0, 0, 0, 0.7));
            border: 2px solid black;
            width: 60px;
            padding: 2px;
            text-align: center;
            border-radius: 10px;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1em;
            color: black;
            font-weight: bold;
            padding: 0 35px 0 5;
        }

        .input-box .icon {
            position: absolute;
            right: 8px;
            font-size: 1em;
            color: black;
            line-height: 57px;
        }

        .remember-forget {
            font-size: .9em;
            color: black;
            font-weight: 500;
            flex-direction: column;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
        }

        .remember-forget label input {
            accent-color: white;
            margin-right: 3px;
        }

        .remember-forget a {
            color: black;
            font-weight: bold;
            text-decoration: none;
        }

        .remember-forget a:hover {
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            height: 45px;
            background: black;
            border: none;
            outline: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 1.5em;
            color: #fff;
            font-weight: 500;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }

        .btn:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7);
            background-color: #fff;
            color: black;
        }

        .login-register {
            font-size: .9em;
            color: black;
            text-align: center;
            font-weight: 500;
            margin: 25px 0 10px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .login-register p {
            color: black;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <header>
        <h2 class="logo"><ion-icon name="skull-outline"></ion-icon></h2>
        <nav class="navigation">
            <a href="#home" class="active">Home</a>
            <a href="">About</a>
            <a href="">Service</a>
            <a href="">Contact</a>
        </nav>
        <nav class="navi">
            <a href="#log-in">Log-in</a>
        </nav>
    </header>
    <section class="parallax">
        <img src="hill1.png" id="hill1" alt="">
        <img src="hill2.png" id="hill2" alt="">
        <img src="hill3.png" id="hill3" alt="">
        <img src="hill4.png" id="hill4" alt="">
        <img src="hill5.png" id="hill5" alt="">
        <img src="tree.png" id="tree" alt="">
        <h2 id="well">WELCOME TO HACKER COLLAGE</h2>
        <img src="leaf.png" id="leaf" alt="">
        <img src="plant.png" id="plant" alt="">
    </section>
    <div class="sec container-fluid" id="log-in">
        <div class="row box">
            <div class="col-7">
                <center>
                    <p class="display-3">Online exam</p>
                </center><br>
                <p class="h1">SIGN IN TO <span style="color: #359381;">START YOUR SESSION</span></p><br>
                <p>"Embrace the challenge of online exams, where dedication meets determination. Staff and students, let your virtual efforts be the keystrokes of success. In this digital arena, every click is a step closer to triumph – you've got the power to conquer the pixels and emerge victorious!"</p>
                <!-- <div class="image"></div> -->
            </div>
            <div class="col-3">
                <div class="wrapper">
                    <div class="form-box login">
                        <h2>LOG-IN</h2>
                        <form method="post">
                            <div class="input-box">
                                <span class="icon"><ion-icon name="person"></ion-icon></span>
                                <input type="text" id="user_id" name="user_id" required>
                                <label>ID</label>
                            </div>
                            <div class="input-box">
                                <span class="toggle-password icon" onclick="togglePasswordVisibility()"><ion-icon name="eye"></ion-icon></span>
                                <input type="password" id="password" name="password" required>
                                <label>Password</label>
                            </div>
                            <div class="remember-forget">
                                <a href="">Forgot password?</a>
                            </div>
                            <button type="submit" class="btn" id="submit" name="submit">Login</button>
                            <div class="login-register">
                                <span>Welcome, Happy to see you!</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        let well = document.getElementById("well");
        let leaf = document.getElementById("leaf");
        let hill1 = document.getElementById("hill1");
        let hill4 = document.getElementById("hill4");
        let hill5 = document.getElementById("hill5");

        window.addEventListener('scroll', () => {
            let value = window.scrollY;

            well.style.marginTop = value * .9 + 'px';
            leaf.style.top = value * -1.5 + 'px';
            leaf.style.left = value * 1.5 + 'px';
            hill5.style.left = value * 1.5 + 'px';
            hill4.style.left = value * -1.5 + 'px';
            hill1.style.top = value * .1 + 'px';
        })

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.querySelector('.toggle-password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.innerHTML = '<ion-icon name="eye-off"></ion-icon>';
            } else {
                passwordInput.type = 'password';
                toggleIcon.innerHTML = '<ion-icon name="eye"></ion-icon>';
            }
        }

        let section = document.querySelectorAll('section');
        let navlinks = document.querySelectorAll('header nav a');

        window.onscroll = () => {
            sections.forEach(sec => {
                let top = window.scrollY;
                let offset = sec.offsetTop - 150;
                let height = sec.offsetHeight;
                let id = sec.getAttribute('id');

                if (top >= offset && top < offset + height) {
                    navlinks.forEach(links => {
                        links.classList.remove('active');
                        document.querySelector('header nav a[herf*=' + id + ']').classList.add('active');
                    });
                };
            });
            let header = document.querySelector('header');

            header.classList.toggle('sticky', window.scrollY > 100);
        };
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>