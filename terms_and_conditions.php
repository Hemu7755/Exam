<?php
require_once "config.php";
session_start();
$userid = $_SESSION['id'];
if (!isset($userid) || empty($userid)) {
    header("Location: sin-up.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Exam</title>
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
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 10vh;
            padding: .5em 1%;
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 1);
            z-index: 100;
        }

        .logo {
            font-size: 1rem;
            transition: .5s ease;
            color: black;
        }

        .logo:hover {
            color: yellowgreen;
        }

        .navbar {
            font-size: 4rem;
            color: black;
            margin-left: 1.1rem;
            border: none;
            transition: .5s ease;
        }

        .container {
            margin: 90px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 1);
            padding: 30px;
            background-color: white;
            text-align: justify;
        }

        .container h1 {
            color: #1a73e8;
        }

        .container span {
            font-size: 25px;
            font-style: Arial Rounded MT Bold;

        }

        .checkbox-label {
            font-size: 20px;
            display: block;
        }

        #startExamBtn {
            background-color: #1a73e8;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;

        }

        #startExamBtn:hover {
            background-color: #0e5a9b;
        }

        .terms {
            padding: 20px;
            text-align: justify;
            font-family: sans-serif;
        }

        .container {
            animation: slideFromBottom 1s ease-in-out forwards;
        }

        @keyframes slideFromBottom {
            0% {
                opacity: 0;
                transform: translateY(50%);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .a{
            font-weight: bold;
        }
        .b{
            font-size: 1em;
        }
    </style>
</head>

<body>
    <center>
        <header class="header">
            <div class="logo">
                <h1>Online Examination Portal</h1>
            </div>
            <nav class="navbar">
                <div id="timer"></div>
            </nav>
        </header>
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4"></div>
                    <div class="col-4"></div>
                </div>
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4"></div>
                    <div class="col-4"></div>
                </div>
                <div class="col-12 d-flex flex-column align-items-center">
                    <h1 class="text-center ">Welcome to the Exam</h1>
                    <span>Please read and agree to the following terms and conditions before starting the exam:</span>
                    <div class="h4 terms">
                        <p>**Terms and Conditions for Online Exam** <br><br>

                            <span class="a">Guidelines and instructions for the Candidates for Online Examination</span><br>

                            <p class="b">Online examination is being conducted for evaluating the students' performance for August 2020 Term-End Examination (TEE) for various courses. <br><br>

                            It is an Online Examination system, fully computerized, user friendly having advanced security features making it fair, transparent and standardized.<br><br>

                            Candidates are requested to take the test honestly, ethically, and should follow all the instructions.</p><br>

                            <span class="a">Basic Instructions for Online Examinations:</span><br><br>

                            <span class="a">A. General information:</span><br><br>

                            <p class="b">1. The examination will comprise of Objective type Multiple Choice Questions (MCQs)<br><br>

                            2. All questions are compulsory and each carries One mark.<br><br>

                            3. The total number of questions, duration of examination, will be different based on the course, the detail is available on your screen.<br><br>

                            4. The Subjects or topics covered in the exam will be as per the Syllabus.<br><br>

                            5. There will be NO NEGATIVE MARKING for the wrong answers</p><br>

                            <span class="a">B. Information & Instructions:</span><br><br>

                            <p class="b">1. The examination does not require using any paper, pen, pencil and calculator.<br><br>

                            2. Every student will take the examination on a Laptop/Desktop/Smart Phone<br><br>

                            3. On computer screen every student will be given objective type Multiple Choice Questions (MCQs).<br><br>

                            4. Each student will get questions and answers in different order selected randomly from a fixed Question Databank.<br><br>

                            5. The students just need to click on the Right Choice / Correct option from the multiple choices /options given with aeach question.<br><br>
                            
                            For Multiple Choice Questions, each question has four options, and the candidate has to click the appropriate option</p><br><br>

                            <span class="a">The sequence of steps to be followed by each examinee for appearing in Examination</span><br><br>

                            <p class="b">using Online Examination Portal will be as follows:<br><br>

                            a. The students will have to enter their Enrolment Number as Username and Password (which has been sent to their

                            registered mobile number and email-id).<br><br>

                            b. The student's details appear on the screen, which will be verified by the student.<br><br>

                            c. The student will get Instructions to guide through the test.<br><br>

                            d. The Time of the examination begins only when the 'Start Test' button is pressed.<br><br>

                            e. The student proceeds answering the questions one by one by clicking onsmall grey circle next to the chosen answer.<br><br>

                            f. The examinee can move to First, Last, Previous, Next and unanswered questions by clicking on the buttons with respective<br><br>
                            
                            labels displayed on screen throughout the test..<br><br>

                            g. The answers can be changed at any time during the test and are saved automatically.<br><br>

                            h. It is possible to Review the answered as well as the unanswered questions.<br><br>

                            i. The Time remaining is shown in the Right Top Corner of the screen.<br><br>

                            j. The system automatically shuts down when the time limit is over OR alternatively if examinee finishes the exam beforetime <br><br>
                            
                            can quit by pressing the 'End Test' button. The students don't click the "END TEST" Button until the student want to quit from Examination</p><br>

                            <p class="c">Important: Do not click the "Submit Test" button unless you want to leave early</p><br>

                            By proceeding with the online exam, you acknowledge that you have read, understood, and agreed to these terms and conditions. <br><br>

                            [VULCANTECH/Hemanth] <br><br>
                            [04-01-2024]</p>
                    </div>
                    <label class="checkbox-label" for="termsCheckbox">
                        <input type="checkbox" id="termsCheckbox"> I agree to the terms and conditions
                    </label><br><br>
                    <button id="startExamBtn" class="btn" name="submit" value="submit">Start Exam</button>
                </div>
            </div>


        </div>
    </center>

    <script>
    document.getElementById("startExamBtn").addEventListener("click", function() {
        var checkbox = document.getElementById("termsCheckbox");
        if (checkbox.checked) {
            // Show success alert if terms checkbox is checked
            Swal.fire("Success", "You have agreed to the terms and conditions. The exam will now start.", "success");
            // Proceed to take the test after some delay (for the user to see the alert)
            setTimeout(function() {
                window.location.href = "test.php"; // Replace with your exam page URL
            }, 2000); // 2000 milliseconds delay (2 seconds)
        } else {
            // Show error alert if terms checkbox is not checked
            Swal.fire("Error", "Please agree to the terms and conditions before starting the exam", "error");
        }
    });

    document.getElementById("termsCheckbox").addEventListener("click", function() {
        var checkbox = document.getElementById("termsCheckbox");
        if (checkbox.checked) {
            // Show alert if terms checkbox is checked
            Swal.fire("Agreement", "You have agreed to the terms and conditions.", "info");
        }
    });

    // Function to start the timer
    function startTimer(duration, display, submitButton) {
        var timer = duration,
            minutes, seconds;
        setInterval(function() {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            // Change timer color to green when last minute
            if (timer <= 60) {
                display.style.color = "green";
                submitButton.disabled = false;
            }

            if (--timer < 0) {
                timer = duration;
                window.location.href = 'student_page.php';
            }
        }, 1000);
    }

    // Start the timer when the page is loaded
    window.onload = function() {
        var twoMinutes = 60 * 2,
            display = document.querySelector('#timer'),
            submitButton = document.getElementById('startExamBtn');

        // Disable the submit button initially
        submitButton.disabled = true;

        startTimer(twoMinutes, display, submitButton);
    };

        document.addEventListener('click', () => {
        const element = document.documentElement;

        // Check if fullscreen is allowed
        if (element.requestFullscreen || element.mozRequestFullScreen || element.webkitRequestFullscreen || element.msRequestFullscreen) {
            // Use a user gesture to request fullscreen
            element.requestFullscreen = element.requestFullscreen || element.mozRequestFullScreen || element.webkitRequestFullscreen || element.msRequestFullscreen;
            element.requestFullscreen();

            // Exit fullscreen after a delay of 15 minutes (900,000 milliseconds)
            setTimeout(() => {
                document.exitFullscreen();
            }, 900000);
        } else {
            console.error('Fullscreen not supported');
        }
    });

    document.addEventListener('keydown', (event) => {
        const element = document.documentElement;

        if (event.key === 'Escape' && document.fullscreenElement) {
            // Prevent default behavior to disable exiting fullscreen using the "Esc" key
            event.preventDefault();

            // Exit fullscreen after a delay of 15 minutes (900,000 milliseconds)
            setTimeout(() => {
                document.exitFullscreen();
            }, 900000);
        }
    });

    let exitFullscreenTimeout;

    document.addEventListener('click', () => {
        if (document.fullscreenElement) {
            clearTimeout(exitFullscreenTimeout);
        }
    });
    </script>

</body>

</html>