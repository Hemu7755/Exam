<?php
require_once "config.php";
session_start();
$userid = $_SESSION['id'];
if (!isset($userid) || empty($userid)) {
    header("Location: sin-up.php");
    exit();
}

$userBranchQuery = mysqli_query($conn, "SELECT branch FROM student_login WHERE student_id = $userid");
$userBranch = mysqli_fetch_assoc($userBranchQuery)['branch'];

$examsQuery = mysqli_query($conn, "SELECT exam_name, subject_id, branch, time FROM exam WHERE status='activate' AND branch = '$userBranch'");
if (!$examsQuery) {
    die("Error: " . mysqli_error($conn));
}

$examData = mysqli_fetch_assoc($examsQuery);
if (!$examData) {
    die("No exam data found!");
}

$examName = $examData['exam_name'];
$subjectid = $examData['subject_id'];

$questions_query = mysqli_query($conn, "SELECT student_id, questions, questions_no, opt_1, opt_2, opt_3, opt_4, crt_ans, cmt FROM question WHERE status='1' AND student_id = '$subjectid' and exam_id='$examName'");
if (!$questions_query) {
    die("Error: " . mysqli_error($conn));
}

$questions = array();

while ($row = mysqli_fetch_assoc($questions_query)) {
    $questions[] = $row;
}

$questions_query = mysqli_query($conn, "SELECT student_id FROM question WHERE status='1' AND student_id = '$subjectid' and exam_id='$examName'");
$questiondata = mysqli_fetch_assoc($questions_query);
$student = $questiondata['student_id'];

$exam_query = mysqli_query($conn, "SELECT time, total_marks FROM exam WHERE status='activate' AND branch = '$userBranch' AND subject_id='$student'");
$examtime = mysqli_fetch_assoc($exam_query);
$time = $examtime['time'];
$marks = $examtime['total_marks'];
// echo "Data received: " . $marks;
// echo "Data received: " . $time;

$totalQuestions = count($questions);
$viewedCount = 0;
$unviewedCount = $totalQuestions;
$answeredCount = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/5a54b76202.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <title>Test started</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
        }

        body {
            background-color: ghostwhite;
            min-height: 100vh;
            width: 100%;
        }

        .header {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 10vh;
            padding: .5em 1%;
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            font-size: 2rem; /* Adjust font size for smaller screens */
            color: black;
            margin-left: 1.1rem;
            border: none;
            transition: .5s ease;
        }

        .box {
            margin: 20px;
            padding: 15px;
        }

        .box1 {
            font-weight: bold;
        }

        .box2 {
            background-color: white;
            border-radius: 20px;
            padding: 10px;
            margin-top: 20px;
        }

        .box3 {
            justify-content: end;
            margin: 10px;
        }

        .a {
            background-color: green;
            width: 1px;
            border-radius: 10px;
            margin:0 10px;
        }

        .b {
            background-color: red;
            width: 1px;
            margin:0 10px;
            border-radius: 10px;
        }

        .c {
            background-color: gray;
            width: 1px;
            margin:0 10px;
            border-radius: 10px;
        }

        .question {
            padding: 20px;
            font-size: 1.5em;
            display: none;
        }

        .list-group-item {
            border: none !important;
            outline: none !important;
        }

        .btn-group .btn {
            margin-right: 10px;
            border-radius: 15px;
        }

        .question-button.answered {
            background-color: green;
        }

        .question-button.unanswered {
            background-color: red;
        }

        .type {
            justify-content: space-between;
        }

        .box5 {
            justify-content: center;
            margin: 20px;
            text-align: center;
            align-items: center;
        }
        .box6{
            width: 15%;
            height: 100px;
            font-size: 1.5em;
            text-align: end;
            margin-top: 20px;
        }

        @media only screen and (min-width: 768px) {
            .navbar {
                font-size: 4rem;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="logo">
            <h1>Online Examination Portal</h1>
        </div>
        <nav class="navbar">
            <div id="timer">Timer</div>
        </nav>
    </header>
    <div class="row box ">
        <div class="col-2">
            <div class="row box1">
                <?php
                $data = mysqli_query($conn, "SELECT student_id, student_name,gender,student_mail,phone_no, branch FROM student_login WHERE student_id='$userid'");

                if ($data) {
                    $userData = mysqli_fetch_assoc($data);
                ?>
                    <div class="row">
                        <p>USER ID : <?php echo $userData['student_id']; ?></p>
                        <p>NAME : <?php echo $userData['student_name']; ?></p>
                        <p>BRANCH : <?php echo $userData['branch']; ?></p>
                        <p>GENDER : <?php echo $userData['gender']; ?></p>
                        <p>E-MAIL : <?php echo $userData['student_mail']; ?></p>
                        <p>PHONE NUMBER : +91 <?php echo $userData['phone_no']; ?></p>
                    </div>
                <?php
                } else {
                    echo "<p>No user data found!</p>";
                }
                ?>
            </div>
        </div>
        <div class="col-8">
            <div class="row box2">
                <h3>Select Question:</h3>


                <div class="btn-group" role="group">
                    <?php
                    for ($j = 1; $j <= count($questions); $j++) :
                    ?>
                        <button type="button" style="border: 1px solid black;" class="btn btn-light rounded question-button" data-question="<?php echo $j; ?>"><?php echo $j; ?></button>
                    <?php
                    endfor;
                    ?>
                </div>
            </div>
            <div class="row box3">
                <div class="a"></div> Answered Questions
                <div class="b"></div> Pending Questions
                <div class="c"></div> Questions need to review
            </div>
            <div class="row box4">
                <div class="type">
                    <h2>Exam Questions</h2>
                </div>
                <ul class="list-group">
                    <?php
                    $i = 1;
                    foreach ($questions as $question) :
                    ?>
                        <li class="list-group-item question" id="question-<?php echo $i; ?>">
                            <strong>Question <?php echo $i; ?> :</strong> <?php echo $question['questions']; ?><br><br>
                            <label><input type="radio" name="answer-<?php echo $i; ?>" value="A"> <?php echo $question['opt_1']; ?></label><br>
                            <label><input type="radio" name="answer-<?php echo $i; ?>" value="B"> <?php echo $question['opt_2']; ?></label><br>
                            <label><input type="radio" name="answer-<?php echo $i; ?>" value="C"> <?php echo $question['opt_3']; ?></label><br>
                            <label><input type="radio" name="answer-<?php echo $i; ?>" value="D"> <?php echo $question['opt_4']; ?></label><br><br>
                            <button type="button" class="btn btn-outline-success save-next-button">Save and Next</button>
                        </li>
                    <?php
                        $i++;
                    endforeach;
                    ?>
                </ul>
            </div>
            <div class="row box5">
                <div class="col-4">
                    <button type="button" class="btn btn-outline-info previous-button"> <- Previous Question </button>
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-outline-info submit-button" disabled>Submit Exam</button>
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-outline-info next-button">Next Question -></button>
                </div>
            </div>
        </div>
        <div class="row box6">

            <div><?php echo $totalQuestions; ?> :Total Questions</div>
            <div style="color: gray;"><span id="viewedCount"><?php echo $viewedCount; ?></span> :Viewed</div>
            <div style="color: red;"><span id="unviewedCount"><?php echo $unviewedCount; ?></span> :Unviewed</div>
            <div style="color: green;"><span id="answeredCount"><?php echo $answeredCount; ?></span> :Answered</div>
        </div>
    </div>
    <form id="examForm" method="post" action="">
        <input type="hidden" name="answers" value="">
    </form>
    <?php
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Assuming you have a database connection already established
        require_once "config.php";

        // Retrieve the answers from the POST data
        $answers = json_decode($_POST['answers'], true);


        // Validate and process the submitted answers
        $totalQuestions = count($questions);
        $correctAnswers = 0;

        foreach ($questions as $index => $question) {
            $userAnswer = $answers[$index] ?? ''; // Validate the existence of the answer
            $correctAnswer = $question['crt_ans'];

            // Check if the user's answer is correct
            if ($userAnswer === $correctAnswer) {
                $correctAnswers++;
            }
        }

        // Calculate marks
        $totalMarks = $marks; // Assuming you want to give 100 marks for the exam
        $marksPerQuestion = $totalMarks / $totalQuestions;
        $marksObtained = $correctAnswers * $marksPerQuestion;

        // Insert result into the database
        $insertResultQuery = "INSERT INTO result (student_id, student_name, exam_name, subject_id, marks) VALUES ('$userid', '$userData[student_name]', '$examName', '$subjectid', '$marksObtained')";
        $result = mysqli_query($conn, $insertResultQuery);

        if (!$result) {
            die("Error inserting result: " . mysqli_error($conn));
        }

        // Display exam results in a modal
        echo '<div id="resultModal" class="modal fade" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resultModalLabel">Exam Result</h5>
                        </div>
                        <div class="modal-body">
                            <p>Total Marks: ' . $totalMarks . '</p>
                            <p>Marks Obtained: ' . $marksObtained . '</p>
                            <p>Correct Answers: ' . $correctAnswers . '</p>
                            <p>Wrong Answers: ' . ($totalQuestions - $correctAnswers) . '</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="window.location.href=\'student_page.php\'">OK</button>
                        </div>
                    </div>
                </div>
            </div>';

        echo '<script>
                $(document).ready(function () {
                    $("#resultModal").modal("show");
                });
            </script>';
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <script>
        let currentQuestionNumber = 1;
        let viewedCount = 0;
        let answeredCount = 0;

        function updateCounts() {
            const totalQuestions = <?php echo count($questions); ?>;
            const selectedRadio = document.querySelector(`input[name="answer-${currentQuestionNumber}"]:checked`);

            // Update viewed count
            viewedCount = document.querySelectorAll('.question-button.answered, .question-button.unanswered').length;
            document.getElementById('viewedCount').textContent = viewedCount;

            // Update unviewed count
            const unviewedCount = totalQuestions - viewedCount;
            document.getElementById('unviewedCount').textContent = unviewedCount;

            // Update answered count
            answeredCount = document.querySelectorAll('.question-button.answered').length;
            document.getElementById('answeredCount').textContent = answeredCount;
        }

        function showQuestion(questionNumber) {
            document.querySelectorAll('.question').forEach(question => {
                question.style.display = 'none';
            });

            const currentQuestion = document.getElementById(`question-${questionNumber}`);
            if (currentQuestion) {
                currentQuestion.style.display = 'block';
            }

            document.querySelectorAll('.question-button').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`.question-button[data-question="${questionNumber}"]`).classList.add('active');
        }

        // Add event listener for the next button
        const nextButton = document.querySelector('.next-button');
        nextButton.addEventListener('click', () => {
            currentQuestionNumber = (currentQuestionNumber % <?php echo count($questions); ?>) + 1;
            showQuestion(currentQuestionNumber);
            updateCounts();
        });

        // Add event listener for the previous button
        const previousButton = document.querySelector('.previous-button');
        previousButton.addEventListener('click', () => {
            currentQuestionNumber = (currentQuestionNumber - 2 + <?php echo count($questions); ?>) % <?php echo count($questions); ?> + 1;
            showQuestion(currentQuestionNumber);
            updateCounts();
        });

        document.querySelectorAll('.question-button').forEach(button => {
            button.addEventListener('click', () => {
                currentQuestionNumber = parseInt(button.getAttribute('data-question'));
                showQuestion(currentQuestionNumber);
                updateCounts();
            });
        });
        document.querySelector('.question').style.display = 'block';
        document.querySelector('.question-button[data-question="1"]').classList.add('active');

        const saveNextButtons = document.querySelectorAll('.save-next-button');
        saveNextButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                const currentQuestionNumber = document.querySelector('.question-button.active').getAttribute('data-question');
                const currentQuestion = document.getElementById(`question-${currentQuestionNumber}`);
                let nextQuestionNumber, nextQuestion;

                if (index + 1 === saveNextButtons.length) {
                    nextQuestionNumber = 1; // Loop back to the first question
                } else {
                    nextQuestionNumber = index + 2;
                }
                nextQuestion = document.getElementById(`question-${nextQuestionNumber}`);

                if (currentQuestion && nextQuestion) {
                    currentQuestion.style.display = 'none';
                    nextQuestion.style.display = 'block';
                }

                document.querySelector(`.question-button[data-question="${currentQuestionNumber}"]`).classList.remove('active');
                document.querySelector(`.question-button[data-question="${nextQuestionNumber}"]`).classList.add('active');

                const selectedRadio = currentQuestion.querySelector('input[type="radio"]:checked');
                if (selectedRadio) {
                    document.querySelector(`.question-button[data-question="${currentQuestionNumber}"]`).classList.remove('unanswered');
                    document.querySelector(`.question-button[data-question="${currentQuestionNumber}"]`).classList.add('answered');
                } else {
                    document.querySelector(`.question-button[data-question="${currentQuestionNumber}"]`).classList.add('unanswered');
                }
                updateCounts();
            });
        });

        // Add event listener for the submit button
        const submitButton = document.querySelector('.submit-button');
        submitButton.addEventListener('click', () => {
            submitExam();
            updateCounts();
        });
        updateCounts();
        document.querySelectorAll('.question-button').forEach(button => {
            button.addEventListener('click', () => {
                const currentQuestionNumber = document.querySelector('.question-button.active').getAttribute('data-question');
                const currentQuestion = document.getElementById(`question-${currentQuestionNumber}`);
                const nextQuestionNumber = button.getAttribute('data-question');
                const nextQuestion = document.getElementById(`question-${nextQuestionNumber}`);

                const selectedRadio = currentQuestion.querySelector('input[type="radio"]:checked');
                if (selectedRadio === null) {
                    document.querySelector(`.question-button[data-question="${currentQuestionNumber}"]`).classList.add('unanswered');
                }

                document.querySelectorAll('.question').forEach(question => {
                    question.style.display = 'none';
                });
                if (nextQuestion) {
                    nextQuestion.style.display = 'block';
                }
                document.querySelectorAll('.question-button').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
        });

        // Countdown Timer
        const timerDisplay = document.getElementById('timer');
        let timerSeconds = 3 * 60; // 2 hours
        let timerInterval;

        function countdown() {
            const hours = Math.floor(timerSeconds / 3600);
            const minutes = Math.floor((timerSeconds % 3600) / 60);
            const seconds = timerSeconds % 60;

            timerDisplay.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (timerSeconds > 120) {
                timerDisplay.style.color = "green";
            }
            if (timerSeconds === 2 * 60) {
                timerDisplay.style.color = "red";
                showAlert('Last 2 minutes remaining!', 'info');
            } else if (timerSeconds === 1 * 60) {
                timerDisplay.style.color = "red";

                showAlert('Last 1 minute remaining!', 'warning');
            } else if (timerSeconds === 30) {
                timerDisplay.style.color = "darkred";

                // Blink effect for the last 30 seconds
                setInterval(() => {
                    timerDisplay.style.visibility = (timerDisplay.style.visibility === 'hidden') ? 'visible' : 'hidden';
                }, 500);

                showAlert('Last 30 seconds remaining!', 'info');
                // Enable the submit button
                submitButton.disabled = false;
            } else if (timerSeconds <= 0) {
                clearInterval(timerInterval);
                showFinalAlert();
                submitExam();
            }

            timerSeconds--;
        }

        function showAlert(message, icon) {
            Swal.fire({
                title: message,
                icon: icon,
                timer: 3000,
                showConfirmButton: false
            });
        }

        function showFinalAlert() {
            Swal.fire({
                title: 'Time up!',
                icon: 'info',
                timer: 3000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'student_page.php';
            });
        }

        function submitExam() {
            // Collect and submit the answers
            const answers = [];
            for (let i = 1; i <= <?php echo count($questions); ?>; i++) {
                const selectedRadio = document.querySelector(`input[name="answer-${i}"]:checked`);
                if (selectedRadio) {
                    answers.push(selectedRadio.value);
                } else {
                    answers.push(''); // Add an empty string for unanswered questions
                }
            }

            // Update the hidden input with the answers
            document.querySelector('input[name="answers"]').value = JSON.stringify(answers);

            // Submit the form
            $.ajax({
                type: 'POST',
                url: 'process_exam.php', // Replace with the actual script processing the form
                data: $('#examForm').serialize(),
                success: function(response) {
                    // Handle the success response
                    console.log(response); // Log the response for debugging purposes
                    // Redirect to student_page.php
                    window.location.href = 'student_page.php';
                },
                error: function(error) {
                    // Handle the error
                    console.error(error);
                }
            });
        }
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

        // Start the countdown
        timerInterval = setInterval(countdown, 1000);
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>

</html>