<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the course ID from the URL
$course_id = $_GET['id'];

// Prepare the SQL query
$sql = "
    SELECT DISTINCT 
        courses.id AS course_id,
        courses.name AS course_name,
        courses.code AS course_code,
        CONCAT(teachers.first_name, ' ', teachers.last_name) AS teacher_name
    FROM 
        courses
    LEFT JOIN 
        teachercourse ON courses.id = teachercourse.course_id
    LEFT JOIN 
        teachers ON teachercourse.teacher_id = teachers.id
    WHERE 
        courses.id = ?
";

$stmt = $conn->prepare($sql); // Prepare the query

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind the parameter
$stmt->bind_param("i", $course_id); // "i" indicates the parameter is an integer

// Execute the query
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CSS 465 Project Management (Assyl Abilakim)</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Battambang:wght@100;400;700;900&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="..\styles\dashboard_style.css" />
</head>
<body>
<!--  TOP BAR-->
<div class="top-bar">
    <div class="left-section">
        <a href="..\htmls\page.html">
            <img src="..\assets\logo_sdu_general.png" alt="Logo" class="logo-img">
        </a>
    </div>

    <ul class="nav" style="width: 20%; padding-left: 4%;">
        <li class="nav-item dropdown" style="margin-left: 10%;">
            <a class="nav-link" href="#" id="dropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell-o icon"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdown1">
                <li><a class="dropdown-item" href="#">Notification 1</a></li>
                <li><a class="dropdown-item" href="#">Notification 2</a></li>
                <li><a class="dropdown-item" href="#">Notification 3</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown" style="margin-left: -14%;">
            <a class="nav-link" href="#" id="dropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-comment-o icon"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdown2">
                <li><a class="dropdown-item" href="#">Message 1</a></li>
                <li><a class="dropdown-item" href="#">Message 2</a></li>
                <li><a class="dropdown-item" href="#">Message 3</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown" style="margin-left: -14%;">
            <a class="nav-link" href="#" id="dropdown3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user-o icon"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdown3">
                <li><a class="dropdown-item" href="..\htmls\profile.html">My Profile</a></li>
                <li><a class="dropdown-item" href="..\htmls\page.html">My Dashboard</a></li>
                <li><a class="dropdown-item" href="..\htmls\login.html">Log Out</a></li>
            </ul>
        </li>
    </ul>

</div>

<!--MAIN PART-->
<div class="main-container">
    <div class="rectangle-2">
        <div class="flex-row-ac">
            <div><a href="..\phps\coursepage.php?id=<?php echo $course_id; ?>" style="text-decoration: none; color: inherit"><span>Course</span></a></div>
            <div><a href="..\pdfs\syllabus.pdf"><span>Syllabus</span></a></div>
            <div><a href="..\htmls\grade.html" style="text-decoration: none; color: inherit" ><span>Grades</span></a></div>
        </div>

        <?php
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Fetch only one row
            echo "
        <div class='course-container'>
            <span class='coursepage-title'>" . htmlspecialchars($row['course_code']) . " - " . htmlspecialchars($row['course_name'])  . " (" . htmlspecialchars(isset($row['teacher_name']) ? $row['teacher_name'] : 'No teacher assigned') . ")" ."</span>
        </div>
    ";
        } else {
            echo "<p>No course found.</p>";
        }
        ?>

        <div class="progress-container">
            <span class="total">Total Grade: 15</span>
            <div class="progress-bar">
                <div class="divider"></div>
                <div class="progress-fill" ></div>
            </div>
            <span id="percentage">7%</span>
        </div>

        <button id="toggleAllBtn" class="btn rectangle-9">Expand All<i class="material-icons" style="height: 100%; margin: 3% 0 0 1%">arrow_downward</i></button>
        <div id="accordion" class="accordion">
            <div style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseOne">
                        <span class="general">General</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseOne" class="accordion-collapse collapse">
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-b"></div>
                        </div>
                        <span class="book-title">Absolute Beginner’s guide to Project Management - book</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseTwo">
                        <span class="general">2 September - 8 September</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseTwo" class="accordion-collapse collapse" >
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <a href="..\pdfs\l1.pdf"></a>
                        <span class="book-title">Lecture 1</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseThree">
                        <span class="general">9 September - 15 September</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseThree" class="accordion-collapse collapse" >
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Lecture 2</span>
                    </div>
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Practice 2</span>
                    </div>
                </div>
            </div>

            <div style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseFour">
                        <span class="general">16 September - 22 September</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseFour" class="accordion-collapse collapse">
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Lecture 3</span>
                    </div>
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Assignment 1</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseFive">
                        <span class="general">23 September - 29 September</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseFive" class="accordion-collapse collapse" >
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Lecture 4</span>
                    </div>
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Practice 4</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseSix">
                        <span class="general">30 September - 6 October</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseSix" class="accordion-collapse collapse" >
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Lecture 5</span>
                    </div>
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Assignment 2</span>
                    </div>
                </div>
            </div>

            <div style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseSeven">
                        <span class="general">7 October - 13 October</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseSeven" class="accordion-collapse collapse">
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Lecture 6</span>
                    </div>
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Practice 6</span>
                    </div>
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Assignment 3</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseEight">
                        <span class="general">14 October - 20 October</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseEight" class="accordion-collapse collapse" >
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Lecture 7</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseNine">
                        <span class="general">21 October - 27 October</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseNine" class="accordion-collapse collapse" >
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Lecture 8</span>
                    </div>
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Practice 8</span>
                    </div>
                </div>
            </div>

            <div style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseTen">
                        <span class="general">28 October - 3 November</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseTen" class="accordion-collapse collapse">
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-b"></div>
                        </div>
                        <span class="book-title">Well-versed’s guide to Project Management - book</span>
                    </div>
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Practice 9</span>
                    </div>
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Assignment 4</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseEleven">
                        <span class="general">4 November - 10 November</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseEleven" class="accordion-collapse collapse" >
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Lecture 10</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapseTwelve">
                        <span class="general">11 November - 17 November</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapseTwelve" class="accordion-collapse collapse" >
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Lecture 11</span>
                    </div>
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Practice 11</span>
                    </div>
                    <div style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Assignment 5</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapse13">
                        <span class="general">18 November - 24 November</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapse13" class="accordion-collapse collapse" >
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Practice 12</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapse14">
                        <span class="general">25 November - 1 December</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapse14" class="accordion-collapse collapse" >
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Lecture 13</span>
                    </div>
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Assignment 6</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapse15">
                        <span class="general">2 December - 8 December</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapse15" class="accordion-collapse collapse" >
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Practice 14</span>
                    </div>
                </div>
            </div>

            <div  style="margin: 2%">
                <div class="rectangle-b">
                    <a data-bs-toggle="collapse" href="#collapse16">
                        <span class="general">9 December - 15 December</span>
                        <div class="vector"></div>
                    </a>
                </div>
                <div id="collapse16" class="accordion-collapse collapse" >
                    <div class="card-body" style="width: 84%; margin: 3% 0 0 6%; display: flex; flex-direction: row; gap: 2%">
                        <div style="background-color: #1c2a5b; height: 1px; margin: 1% 0 1% 0"></div>
                        <div class="rectangle-d">
                            <div class="icon-e"></div>
                        </div>
                        <span class="book-title">Lecture 15</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--      FOOTER -->
<div class="rectangle-14">
    <div class="line-15"></div>
    <div class="flex-container">
        <div class="flex-columns">
            <span class="titles">SDU UNIVERSITY</span>
            <a href="https://sdu.edu.kz/language/en/about-us-3/">
                <span class="nodes">About us</span>
            </a>
            <a href="https://sdukzlinks.tilda.ws/">
                <span class="nodes">Connect to us</span>
            </a>
        </div>

        <div class="flex-columns">
            <span class="titles">FACULTIES</span>
            <a href="https://sdu.edu.kz/language/en/business-school/">
                <span class="nodes">SDU BUSINESS SCHOOL</span>
            </a>
            <a href="https://sdu.edu.kz/language/en/engineering-and-natural-sciences/">
                <span class="nodes">FACULTY OF ENGINEERING <br />AND NATURAL SCIENCES</span>
            </a>
            <a href="https://sdu.edu.kz/language/en/education-and-humanities/">
                <span class="nodes">FACULTY OF EDUCATION <br />AND HUMANITIES</span>
            </a>
            <a href="https://sdu.edu.kz/language/en/law-social-science/">
                <span class="nodes">FACULTY OF LAW AND <br />SOCIAL SCIENCES</span>
            </a>
        </div>

        <div class="flex-columns">
            <span class="titles">RULES</span>
            <a href="https://sdu.edu.kz/language/en/rules/">
                <span class="nodes">Charter</span>
            </a>
            <a href="https://sdu.edu.kz/language/en/rules/">
                <span class="nodes">Safety rules</span>
            </a>
        </div>

        <div class="flex-columns">
            <span class="titles">ADDRESS</span>
            <span class="nodes">Almaty region, Karasai district.</span>
            <span class="nodes">040900, city of Kaskelen, st. <br />Abylai Khan 1/1</span>
        </div>
    </div>
    <div class="line-17"></div>
    <div class="flex-row-daab">
        <div>
            <i class="material-icons" >language</i>
            <span class="nodes">SDU UNIVERSITY</span>
        </div>
        <div>
            <i class="material-icons" >phone</i>
            <span class="nodes">Mobile: + 7 727 307 9565</span>
        </div>
        <div>
            <i class="material-icons" >mail_outline</i>
            <span class="nodes">cdl@sdu.edu.kz</span>
        </div>
    </div>
    <span class="copyright-reserved">Copyright © All right reserved SDU University</span>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#toggleAllBtn').click(function() {
            const isExpanded = $('.accordion-collapse.show').length === $('.accordion-collapse').length; // Check if any item is expanded

            if (isExpanded) {
                // If any item is expanded, collapse all and change button text
                $('.accordion-collapse').collapse('hide');
                $(this).text('Expand All');
            } else {
                // If all items are collapsed, expand all and change button text
                $('.accordion-collapse').collapse('show');
                $(this).text('Close All');
            }
        });
    });
</script>

</body>
</html>
