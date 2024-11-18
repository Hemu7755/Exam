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
if (isset($_POST['Exam'])) {
    header("Location: exam.php");
}
if (isset($_POST['Exit'])) {
    session_destroy();
    header("Location: sin-up.php");
    exit();
}

$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($currentPage - 1) * $itemsPerPage;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitButton'])) {
    $subjectCode = $_POST["Subject"];
    $examName = $_POST["exam"];

    $query = "SELECT * FROM exam WHERE binary subject_id = '$subjectCode' AND binary exam_name = '$examName'";
    $result = mysqli_query($conn, $query);

    if (isset($_post['submitButton'])) {
        $subject = $_POST["Subject"];
        $exam = $_POST["exam"];
        $section = $_POST["section"];
        $question = $_POST["question"];
        $type = $_POST["type"];
        $option1 = $_POST["opt1"];
        $option2 = $_POST["opt2"];
        $option3 = $_POST["opt3"];
        $option4 = $_POST["opt4"];
        $correctAnswer = $_POST["crt"];
        $correctcmt = $_POST["cmts"];
        // $hId= $_POST['hidden'];

        $qry = mysqli_prepare($conn, "INSERT INTO question (student_id,exam_id,section, questions, type, opt_1, opt_2, opt_3, opt_4, crt_ans,cmt) VALUES ( '$subject', '$exam', '$section', '$question', '$type', '$option1', '$option2', '$option3', '$option4', '$correctAnswer', '$correctcmt')");
    $stmt = mysqli_prepare($conn, $qry);
        if ($stmt) {
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                        Swal.fire({
                          icon: 'success',
                          title: 'Exam created successfully',
                          showConfirmButton: false,
                          timer: 1500
                        });
                     </script>";
            } else {
                echo "<script>
                        Swal.fire({
                          icon: 'error',
                          title: 'Error creating exam',
                          text: 'Please try again later.',
                        });
                     </script>";
            }
    
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>
                    Swal.fire({
                      icon: 'error',
                      title: 'Error preparing SQL statement',
                      text: 'Please try again later.',
                    });
                 </script>";
        }
    }
}

        // if($hId){
        //     $updateqry = mysqli_prepare($conn, "UPDATE question SET student_id=?, exam_id=?, section=?, questions=?, type=?, opt_1=?, opt_2=?, opt_3=?, opt_4=?, crt_ans=?, cmt=? WHERE q_id=?");
        //     mysqli_stmt_bind_param($updateqry, "sssssssssssi", $subject, $exam, $section, $question, $type, $option1, $option2, $option3, $option4, $correctAnswer, $correctcmt, $hId);
        //     mysqli_stmt_execute($updateqry);

        //     if (mysqli_stmt_execute($updateqry)) {
        //         echo "";
        //     } else {
        //         echo "error: " . mysqli_error($conn);
        //     }
        // } else {
        //     // mysqli_stmt_bind_param($qry, "sssssssssss", $subject, $exam, $section, $question, $type, $option1, $option2, $option3, $option4, $correctAnswer, $correctcmt);
        //     mysqli_stmt_execute($qry);

        //     if($qry){
        //         echo "";
        //     } else {
        //         echo "insert error";
        //     }
        // }
//     }
// }

// if (isset($_POST['delete']) && !empty($_POST['delete'])) {
//     $id = mysqli_real_escape_string($conn, $_POST['delete']);
//     $deleteqry = mysqli_query($conn, "DELETE FROM question WHERE q_id=$id");

//     if ($deleteqry) {
//         echo "";
//     } else {
//         echo "error: " . mysqli_error($conn);
//     }
// }



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUESTION'S</title>
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

        .ex {
            margin-top: 50px;
            padding: 20px;
            text-align: center;
            letter-spacing: 10px;
            width: 70%;
            height: 100vh;
            background-color: black;
            color: #fff;
        }

        .mrt {
            margin-left: 180px;
            width: 80%;
        }

        .table-container {
            margin: auto;
        }

        table {
            width: 95%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 1);
            margin-top: 30px;
        }

        table,
        th,
        td {
            border: 1px solid white;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            color: black;
            background-color: white;
        }

        td {
            border: 2px solid black;
            font-weight: 600;
        }

        th {
            background-color: black;
            color: white;
            border: 2px solid white;
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
                        <button class="but" style="--clr:black" type="submit" id="Exam" name="Exam"><span>Back</span><i></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <center>
        <div class="row ex" id="create">
            <form class="row g-3 needs-validation" action="" novalidate="" method="post" id="questionForm">
                <div class="row display-4 mrt">CREATE QUESTIONS</div>
                <input type="text" name="hidden" id="hidden">

                <div class="col-md-4 position-relative">
                    <label for="validationTooltip11" class="form-label">Exam name</label>
                    <input type="text" class="form-control" id="validationTooltip11" name="exam" placeholder="enter the exam name" required="" fdprocessedid="wm0ph">
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-4 position-relative">
                    <label for="validationTooltip01" class="form-label">Subject Code</label>
                    <select class="form-select" name="Subject" id="validationTooltip01" required="" fdprocessedid="qwz6cd">
                        <option selected="">Choose...</option>
                        <option value="11">11 IOT</option>
                        <option value="22">22 PYTHON</option>
                        <option value="33">33 JS</option>
                        <option value="44">44 HTML</option>
                    </select>
                    <div class="invalid-tooltip">
                        Please select a Subject.
                    </div>
                </div>
                <div class="col-md-4 position-relative">
                    <label for="validationTooltip02" class="form-label">Section</label>
                    <select class="form-select" name="section" id="validationTooltip02" required="" fdprocessedid="qwz6cd">
                        <option selected="">Choose...</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                    <div class="invalid-tooltip">
                        Please select a Section.
                    </div>
                </div>
                <div class="col-md-8 position-relative">
                    <label for="validationTooltip03" class="form-label">QUESTION</label>
                    <textarea class="form-control" id="validationTooltip03" name="question" placeholder="enter the question" required="" fdprocessedid="wm0ph"></textarea>
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-4 position-relative">
                    <label for="validationTooltip04" class="form-label">TYPE</label>
                    <select class="form-select" name="type" id="validationTooltip04" required="" fdprocessedid="qwz6cd">
                        <option selected="">Choose...</option>
                        <option value="check">MULTILE CHOOSE CHECK</option>
                        <option value="text">TEXT BUTTON</option>
                        <option value="radio">RADIO BUTTON</option>
                    </select>
                    <div class="invalid-tooltip">
                        Please select a type.
                    </div>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="validationTooltip05" class="form-label">OPTION-1</label>
                    <input type="text" class="form-control" id="validationTooltip05" name="opt1" placeholder="enter the option-1" required="" fdprocessedid="wm0ph">
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="validationTooltip06" class="form-label">OPTION-2</label>
                    <input type="text" class="form-control" id="validationTooltip06" name="opt2" placeholder="enter the option-2" required="" fdprocessedid="wm0ph">
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="validationTooltip07" class="form-label">OPTION-3</label>
                    <input type="text" class="form-control" id="validationTooltip07" name="opt3" placeholder="enter the option-3" required="" fdprocessedid="wm0ph">
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="validationTooltip08" class="form-label">OPTION-4</label>
                    <input type="text" class="form-control" id="validationTooltip08" name="opt4" placeholder="enter the option-4" required="" fdprocessedid="wm0ph">
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-4 position-relative">
                    <label for="validationTooltip09" class="form-label">CORRECT ANSWER</label>
                    <select class="form-select" name="crt" id="validationTooltip09" required="" fdprocessedid="qwz6cd">
                        <option selected="">Choose...</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                    <div class="invalid-tooltip">
                        Please select a correct answer.
                    </div>
                </div>
                <div class="col-md-8 position-relative">
                    <label for="validationTooltip10" class="form-label">COMMENT</label>
                    <textarea class="form-control" id="validationTooltip10" name="cmts" placeholder="enter the commont" required="" fdprocessedid="wm0ph"></textarea>
                    <div class="valid-tooltip">
                        Looks good!
                    </div>
                </div>
                <center>
                    <div class="col-12">
                        <button class="but" type="submit" name="submitButton" style="--clr:#6eff3e;" fdprocessedid="7ikvy8" id="submitButton"><span>SUBMIT</span><i></i></button>
                    </div>
                </center>
                <input type="hidden" name="delete" id="delete" value="">
            </form>
        </div>
        <div class="row">
            <div class="table-container" id="questionTable">
                <form action="" method="post">
                    <table>
                        <tr>
                            <th colspan="14">QUESTION'S</th>
                        </tr>
                        <tr>
                            <th>S.no</th>
                            <th>subject id</th>
                            <th>Exam Name</th>
                            <th>Section</th>
                            <th>Questions</th>
                            <th>type</th>
                            <th>Option-1</th>
                            <th>Option-2</th>
                            <th>Option-3</th>
                            <th>Option-4</th>
                            <th>Correct Answer</th>
                            <th>Comment</th>
                            <th>Edit</th>
                            <th>Remove</th>
                        </tr>
                        <?php
                        $i = 1;
                        $itemsPerPage = 10;
                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $start = ($currentPage - 1) * $itemsPerPage;
                        $query = "SELECT * FROM question WHERE status='1' LIMIT $start, $itemsPerPage";

                        $result = mysqli_query($conn, $query);

                        while ($transaction = mysqli_fetch_assoc($result)) {

                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $transaction['student_id']; ?></td>
                                <td><?php echo $transaction['exam_id']; ?></td>
                                <td><?php echo $transaction['section']; ?></td>
                                <td><?php echo $transaction['questions']; ?></td>
                                <td><?php echo $transaction['type']; ?></td>
                                <td><?php echo $transaction['opt_1']; ?></td>
                                <td><?php echo $transaction['opt_2']; ?></td>
                                <td><?php echo $transaction['opt_3']; ?></td>
                                <td><?php echo $transaction['opt_4']; ?></td>
                                <td><?php echo $transaction['crt_ans']; ?></td>
                                <td><?php echo $transaction['cmt']; ?></td>
                                <td>Edit</td>
                                <td>Delete</td>
                                <!-- <td onclick="updatequestion(<?php echo $transaction ['q_id'];?>,'<?php echo $transaction ['student_id'];?>','<?php echo $transaction ['exam_id'];?>','<?php echo $transaction ['section'];?>','<?php echo $transaction ['questions'];?>','<?php echo $transaction ['type'];?>','<?php echo $transaction ['opt_1'];?>','<?php echo $transaction['opt_2'];?>','<?php echo $transaction['opt_3'];?>','<?php echo $transaction ['opt_4'];?>','<?php echo $transaction ['crt_ans'];?>','<?php echo $transaction ['cmt'];?>')">Edit</td>
                                <td onclick="deletequestion('<?php echo $transaction ['q_id'];?>')">Delete</td> -->
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </form>
            </div>
        </div>
        <?php
        $totalCountQuery = "SELECT COUNT(*) as total FROM question WHERE status='1'";
        $totalCountResult = mysqli_query($conn, $totalCountQuery);
        $totalCountRow = mysqli_fetch_assoc($totalCountResult);
        $totalCount = $totalCountRow['total'];
        $totalPages = ceil($totalCount / $itemsPerPage);

        if ($totalCount > $itemsPerPage) {
        ?>
            <div class="row p-3 m-0 border-0 bd-example m-0 border-0">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php
                        for ($page = 1; $page <= $totalPages; $page++) {
                        ?>
                            <li class="page-item <?php echo ($page == $currentPage) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        <?php
        }
        ?>

    </center>

    <script type="text/javascript">

    function updatequestion(a,b,c,d,e,f,g,h,i,j,k,l)
        {
            document.getElementById("hidden").value = a;
            document.getElementById("validationTooltip11").value = b;
            document.getElementById("validationTooltip01").value = c;
            document.getElementById("validationTooltip02").value = d;
            document.getElementById("validationTooltip03").value = e;
            document.getElementById("validationTooltip04").value = f;
            document.getElementById("validationTooltip05").value = g;
            document.getElementById("validationTooltip06").value = h;
            document.getElementById("validationTooltip07").value = i;
            document.getElementById("validationTooltip08").value = j;
            document.getElementById("validationTooltip09").value = k;
            document.getElementById("validationTooltip10").value = l;
        }
        function deletequestion(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure you want to delete this record?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete').val(id);
                    $('form').submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your imaginary file is safe :)",
                        icon: "error"
                    });
                }
            });
        }
    </script>
</body>

</html>