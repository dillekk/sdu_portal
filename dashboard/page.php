<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Default username for XAMPP/WAMP/MAMP
$password = ""; // Default password is empty
$dbname = "student_portal"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch courses along with teacher name and year range
$sql = "
SELECT DISTINCT 
    courses.id AS course_id,
    courses.name AS course_name,
    courses.code AS course_code,
    courses.year_range,
    CONCAT(teachers.first_name, ' ', teachers.last_name) AS teacher_name
FROM 
    courses
LEFT JOIN 
    teachercourse ON courses.id = teachercourse.course_id
LEFT JOIN 
    teachers ON teachercourse.teacher_id = teachers.id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | SDU UNIVERSITY</title>
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
<div style="padding-top: 10% ">
    <span class="my-courses">My courses</span>
</div>
<!--      SEARCH BAR-->
<div class="rectangle-4">
    <span class="search-icon"><i class="material-icons" style="font-size: smaller">search</i></span>
    <label>
        <input type="text" class="search-input" placeholder="Find...">
    </label>
</div>
<!--COURSE LIST-->
<div class="flex-list-column">

        <?php
        if ($result->num_rows > 0) {
            $counter = 0;
            echo "<div class='flex-list-row'>";

            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='rectangle'>
                    <a href='coursepage.php?id=" . $row['course_id'] . "'>
                        <span class='course-title'>" . $row['course_code'] . "  " . $row['course_name'] . "</span><div style='height: 2%'></div>
                        <span class='course-teacher'>" . (isset($row['teacher_name']) ? $row['teacher_name'] : 'N/A') . "</span>
                        <span class='fall'>" . $row['year_range'] . "</span>
                    </a>
                </div>
                ";
                $counter++;
                if ($counter % 3 == 0) {
                    echo "</div><div class='flex-list-row'>";
                }
            }
            echo "</div>";
        } else {
            echo "<p>No courses available</p>";
        }
        ?>

</div>

<!--    <div class="flex-list-row">-->
<!--        <div class="rectangle">-->
<!--            <a href="coursepage.html" style="text-decoration: none; color: inherit">-->
<!--                <span class="course-title">CSS 481 Industrial practice 3</span>-->
<!--                <span class="course-teacher">(Kuanyshbek Mamay)</span>-->
<!--                <span class="fall">Fall 2024 (2024-2025)</span>-->
<!--            </a>-->
<!--        </div>-->
<!--        <div class="rectangle">-->
<!--            <a href="coursepage.html" style="text-decoration: none; color: inherit">-->
<!--                <span class="course-title">INF 394 Introduction to Geographic Information Systems</span>-->
<!--                <span class="course-teacher">(Meirman Yzdykbayev)</span>-->
<!--                <span class="fall">Fall 2024 (2024-2025)</span>-->
<!--            </a>-->
<!--        </div>-->
<!--        <div class="rectangle">-->
<!--            <a href="coursepage.html" style="text-decoration: none; color: inherit">-->
<!--                <span class="course-title">INF 440 Digital Image Processing</span>-->
<!--                <span class="course-teacher">(Magzhan Kairanbay)</span>-->
<!--                <span class="fall">Fall 2024 (2024-2025)</span>-->
<!--            </a>-->
<!--        </div>-->
<!--    </div>-->


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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
