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
if (isset($_POST['questions'])) {
    header("Location: questions.php");
}
if (isset($_POST['result'])) {
    header(("Location: admin_result.php"));
}
if (isset($_POST['data'])) {
    header("Location: data.php");
}
if (isset($_POST['Exit'])) {
    session_destroy();
    header("Location: sin-up.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['activate']) && isset($_POST['ex_id'])) {
        $examId = $_POST['ex_id'];
        updateStatus($conn, $examId, 'activate');
    } elseif (isset($_POST['deactivate']) && isset($_POST['exam_id'])) {
        $exId = $_POST['exam_id'];
        updateStatus($conn, $exId, 'deactivate');
    }
}

function updateStatus($conn, $examId, $status)
{
    $statusUpdateQuery = "UPDATE exam SET status = ? WHERE e_id = ?";
    $stmt = mysqli_prepare($conn, $statusUpdateQuery);
    mysqli_stmt_bind_param($stmt, "si", $status, $examId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://kit.fontawesome.com/5a54b76202.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>CREATE-EXAM</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
        }

        body {
            background: linear-gradient(45deg, #d2001a, #7462ff, #f48e21, #23d5ad);
            background-size: 400% 400%;
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
            margin-left: 1.1rem;
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

        .card2 {
            height: 100%;
            background-color: transparent;
            margin: 20px;
            border: none;
        }

        .card-body {
            padding: 20px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        .card-body:hover {
            box-shadow: 10px 10px 10px rgba(0, 0, 0, 1);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1rem;
            line-height: 1.4;
        }

        .btn-success,
        .btn-danger {
            margin-top: 2px;
            width: 40%;
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
                        <button class="but" style="--clr:darkgreen" type="submit" id="home" name="home"><span>HOME</span><i></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row box2">
        <center>
            <form action="" method="post">
                <div class="row">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

                        <input type="submit" class="btn-check" name="result" id="btnradio6" autocomplete="off">
                        <label class="btn but" style="--clr:red" for="btnradio6"><span>RESULT</span><i></i></label>

                        <input type="submit" class="btn-check" name="data" id="btnradio2" autocomplete="off">
                        <label class="btn but" style="--clr:#6eff3e" for="btnradio2"><span>CREATE EXAM DATA</span><i></i></label>

                        <input type="submit" class="btn-check" name="questions" id="btnradio3" autocomplete="off">
                        <label class="btn but" style="--clr:yellow" for="btnradio3"><span>CREATE QUESTION'S</span><i></i></label>

                    </div>
                </div>
            </form>
        </center>
    </div>
    <div class="row card2">
        <?php
        $currentDateTime = date('Y-m-d H:i:s');

        // Fetch today exams
        $todayExams = mysqli_query($conn, "SELECT e_id, exam_name, subject, branch, total_marks, exam_date, start_time, end_time, status 
                                        FROM exam 
                                        WHERE DATE(exam_date) = CURDATE() 
                                        ORDER BY exam_date, start_time");

        while ($todayTransaction = mysqli_fetch_assoc($todayExams)) {
            $startDateTime = $todayTransaction['exam_date'] . ' ' . $todayTransaction['start_time'];
            $endDateTime = $todayTransaction['exam_date'] . ' ' . $todayTransaction['end_time'];

            if ($currentDateTime > $endDateTime) {
                echo generateCard($todayTransaction, 'danger', 'Time Out');
            } else {
                echo generateCard($todayTransaction, 'success');
            }
        }

        // Fetch tomorrow exams
        $tomorrowExams = mysqli_query($conn, "SELECT e_id, exam_name, subject, branch, total_marks, exam_date, start_time, end_time, status 
                                           FROM exam 
                                           WHERE DATE(exam_date) = DATE_ADD(CURDATE(), INTERVAL 1 DAY) 
                                           ORDER BY exam_date, start_time");

        while ($tomorrowTransaction = mysqli_fetch_assoc($tomorrowExams)) {
            $startDateTime = $tomorrowTransaction['exam_date'] . ' ' . $tomorrowTransaction['start_time'];
            $endDateTime = $tomorrowTransaction['exam_date'] . ' ' . $tomorrowTransaction['end_time'];

            if ($currentDateTime > $endDateTime) {
                echo generateCard($tomorrowTransaction, 'danger', 'Time Out');
            } else {
                echo generateCard($tomorrowTransaction, 'success');
            }
        }

        // Fetch upcoming exams
        $upcomingExams = mysqli_query($conn, "SELECT e_id, exam_name, subject, branch, total_marks, exam_date, start_time, end_time, status 
                                          FROM exam 
                                          WHERE DATE(exam_date) > DATE_ADD(CURDATE(), INTERVAL 1 DAY) 
                                          ORDER BY exam_date, start_time");

        while ($upcomingTransaction = mysqli_fetch_assoc($upcomingExams)) {
            echo generateCard($upcomingTransaction, 'light');
        }

        // Fetch past exams
        $pastExams = mysqli_query($conn, "SELECT e_id, exam_name, subject, branch, total_marks, exam_date, start_time, end_time, status 
                                      FROM exam 
                                      WHERE DATE(exam_date) < CURDATE() 
                                      ORDER BY exam_date DESC, start_time DESC");

        while ($pastTransaction = mysqli_fetch_assoc($pastExams)) {
            echo generateCard($pastTransaction, 'danger', 'Time Out');
        }
        ?>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var cards = document.querySelectorAll('.card');

            cards.forEach(function(card) {
                var remainingTime = card.getAttribute('data-remaining-time');
                var cardColor = card.getAttribute('data-card-color');
                card.style.backgroundColor = cardColor;

                if (remainingTime > 0) {
                    setInterval(function() {
                        remainingTime--;
                        card.querySelector('.remaining-time').innerText = formatTime(remainingTime);
                    }, 1000);
                } else {
                    card.querySelector('.remaining-time').innerText = 'Time Over';
                    card.querySelectorAll('button').forEach(function(button) {
                        button.disabled = true;
                    });
                }
            });

            function formatTime(seconds) {
                var hours = Math.floor(seconds / 3600);
                var minutes = Math.floor((seconds % 3600) / 60);
                var remainingSeconds = seconds % 60;

                var formattedTime = hours + ' hours, ' + minutes + ' minutes, ' + remainingSeconds + ' seconds';

                return formattedTime;
            }
        });
        // document.addEventListener('DOMContentLoaded', function () {
        //     var forms = document.querySelectorAll('form');

        //     forms.forEach(function (form) {
        //         form.addEventListener('submit', function (event) {
        //             var buttonClicked = event.submitter; // Get the button that was clicked

        //             // Check if the clicked button is the "Activate" or "Deactivate" button
        //             if (buttonClicked.name === 'activate' || buttonClicked.name === 'deactivate') {
        //                 // Show SweetAlert confirmation
        //                 event.preventDefault(); // Prevent the form from submitting immediately

        //                 Swal.fire({
        //                     title: 'Are you sure?',
        //                     text: 'You are about to ' + buttonClicked.name + ' this exam!',
        //                     icon: 'warning',
        //                     showCancelButton: true,
        //                     confirmButtonColor: '#3085d6',
        //                     cancelButtonColor: '#d33',
        //                     confirmButtonText: 'Yes'
        //                 }).then((result) => {
        //                     if (result.isConfirmed) {
        //                         // If the user clicks "Yes," submit the form
        //                         form.submit();
        //                     }
        //                 });
        //             }
        //         });
        //     });
        // });
    </script>


    <?php
    function generateCard($transaction)

    {
        $startTime = new DateTime($transaction['exam_date'] . ' ' . $transaction['start_time']);
        $currentTime = new DateTime();
        $remainingTime = $startTime->getTimestamp() - $currentTime->getTimestamp();

        $remainingTimeFormatted = ($remainingTime > 0) ? formatTime($remainingTime) : 'Time Over';

        return "
        <div class='col-md-4 mb-4'>
            <div class='card' data-remaining-time='$remainingTime'>
                <div class='card-body'>
                    <center>
                        <h5 class='card-title'>$transaction[exam_name]</h5>
                    </center>
                    <p class='card-text'>
                        <strong>Subject:</strong> $transaction[subject]<br>
                        <strong>Branch:</strong> $transaction[branch]<br>
                        <strong>Total Marks:</strong> $transaction[total_marks]<br>
                        <strong>Exam Date:</strong> $transaction[exam_date]<br>
                        <strong>Exam Time:</strong> $transaction[start_time]<br>
                        <strong>Exam End:</strong> $transaction[end_time]<br>
                        <strong>Status:</strong> $transaction[status]<br>
                        <strong>Remaining Time:</strong> <span class='remaining-time'>$remainingTimeFormatted</span>
                    </p>
                    <form method='post'>
                        <input type='hidden' name='ex_id' value='$transaction[e_id]'>
                        <button type='submit' name='activate' class='btn btn-success'>Activate</button>
                        <input type='hidden' name='exam_id' value='$transaction[e_id]'>
                        <button type='submit' name='deactivate' class='btn btn-danger'>Deactivate</button>
                    </form>
                </div>
            </div>
        </div>
    ";
    }

    function formatTime($seconds)
    {
        $interval = new DateInterval('PT' . $seconds . 'S');
        $formattedTime = $interval->format('%h hours, %i minutes, %s seconds');

        return $formattedTime;
    }

    ?>



</body>

</html>