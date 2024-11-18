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
$itemsPerPage = 7;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($currentPage - 1) * $itemsPerPage;
$avl = mysqli_query($conn, "SELECT student_id,student_name,branch FROM student_login WHERE status='1'");
$unavl = mysqli_query($conn, "SELECT student_id,student_name FROM student_login WHERE status='0'");

if (isset($_POST['create_student'])) {
    $studentID = mysqli_real_escape_string($conn, $_POST['studentID']);
    $studentName = mysqli_real_escape_string($conn, $_POST['studentName']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $checkQuery = "SELECT * FROM student_login WHERE student_id = '$studentID' AND student_name = '$studentName'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $updateQuery = "UPDATE student_login SET status = '$status' WHERE binary student_id = '$studentID' AND binary student_name = '$studentName'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>
                    function showSuccessAlert() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Student status updated successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    showSuccessAlert();
                  </script>";
        } else {
            echo "<script>
                    function showErrorAlert() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error updating student: " . mysqli_error($conn) . "',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    showErrorAlert();
                  </script>";
        }
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
    <title>DELETE-STUDENT</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
        .box{
            width: 100%;
        }
        .box1 {
            background-color: lightgray;
            width: 40%;
            height: 89.6vh;
            text-align: justify;
        }

        .box2 {
            background-color: gray;
            width: 30%;
            height: 89.6vh;
            text-align: justify;
        }
        .box3 {
            background-color: gray;
            width: 30%;
            height: 89.6vh;
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

        .table-container {
            width: 90%;
            margin: auto;
        }

        table {
            width: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 1);
            margin-top: 50px;
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

        .id {
            justify-content: center;
            width: 100%;
            margin: 5px 0;
            padding: 30px;
        }
        .exam {
            padding: 40px;
            letter-spacing: 10px;
            background-color: black;
            color: #fff;
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
    <div class="absolute">
        <div class="absolute inset-0 justify-content">
            <div class="bg-shape1 bg-teal opacity-50 bg-blur"></div>
            <div class="bg-shape2 bg-primary opacity-50 bg-blur"></div>
            <div class="bg-shape3 bg-purple opacity-50 bg-blur"></div>
        </div>
    </div>
    <div class="row box">
        <div class="col-4 box2">
            <div class="row">
                <div class="table-container ">
                    <form action="" method="post">
                        <table>
                            <tr>
                                <th colspan="3">Unavalible-Student-Detailer</th>
                            </tr>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Branch</th>
                            </tr>
                            <?php
                            $itemsPerPage = 7;
                            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                            $start = ($currentPage - 1) * $itemsPerPage;

                            $query = "SELECT * FROM student_login where status='0' LIMIT $start, $itemsPerPage";
                            $data = mysqli_query($conn, $query);
                            while ($transaction = mysqli_fetch_assoc($data)) {
                            ?>
                                <tr>
                                    <td><?php echo $transaction['student_id']; ?></td>
                                    <td><?php echo $transaction['student_name']; ?></td>
                                    <td><?php echo $transaction['branch']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </form>
                </div>
            </div>
            <?php
            $totalCountQuery = "SELECT COUNT(*) as total FROM student_login WHERE status='0'";
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
        </div>

        <div class="col-4 box1">
            <center>
                <form class="row g-3 needs-validation id" novalidate="" action="" method="post">
                    <div class="row h1">DELETEING/RECOVEREY STUDENT FORM</div>
                    <div class="exam">

                    <div class="row g-3 m-3 position-relative">
                        <label for="validationTooltip01" class="form-label">STUDENT ID</label>
                        <input type="number" class="form-control" id="validationTooltip01" name="studentID" placeholder="enter the id" required="" fdprocessedid="wm0ph">
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                    </div>
                    <div class="row g-3 m-3 position-relative">
                        <label for="validationTooltip01" class="form-label">STUDENT name</label>
                        <input type="text" class="form-control" id="validationTooltip01" name="studentName" placeholder="enter the name" required="" fdprocessedid="wm0ph">
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                    </div>
                    <div class="row g-3 m-3 position-relative">
                        <label for="validationTooltip04" class="form-label">STATUS</label>
                        <select class="form-select" name="status" id="validationTooltip04" required="" fdprocessedid="qwz6cd">
                            <option selected="">choose...</option>
                            <option value="1">activate</option>
                            <option value="0">deactivate</option>
                        </select>
                        <div class="invalid-tooltip">
                            Please select a status.
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button class="but" type="submit" name="create_student" style="--clr:#6eff3e" fdprocessedid="7ikvy8"><span>CREATE</span><i></i></button>
                    </div>
                    </div>
                </form>
            </center>
        </div>
        <div class="col-4 box3">
            <div class="row">
                <div class="table-container ">
                    <form action="" method="post">
                        <table>
                            <tr>
                                <th colspan="3">Avaliable-Student-Detailer</th>
                            </tr>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Branch</th>
                            </tr>
                            <?php
                            $itemsPerPage = 7;
                            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                            $start = ($currentPage - 1) * $itemsPerPage;

                            $query = "SELECT * FROM student_login where status='1' LIMIT $start, $itemsPerPage";
                            $data = mysqli_query($conn, $query);
                            while ($transaction = mysqli_fetch_assoc($data)) {
                            ?>
                                <tr>
                                    <td><?php echo $transaction['student_id']; ?></td>
                                    <td><?php echo $transaction['student_name']; ?></td>
                                    <td><?php echo $transaction['branch']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </form>
                </div>
            </div>
            <?php
            $totalCountQuery = "SELECT COUNT(*) as total FROM student_login WHERE status='1'";
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
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://kit.fontawesome.com/5a54b76202.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>