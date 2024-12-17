<?php
session_start();
// Параметры подключения к базе данных
$host = 'localhost';
$dbname = 'sdu_portal';
$user = 'root';
$password = '';

// Подключение к базе данных через PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

// Проверяем, есть ли ID пользователя в сессии
if (!isset($_SESSION['user_id'])) {
    echo "No student ID in session.";
    exit(); // Завершаем выполнение скрипта, если student_id нет в сессии
}
// SQL query to join tables
$sql = "SELECT c.name, c.code, t.first_name, tc.week_day, tc.start_time
        FROM teachercourse tc
        JOIN courses c ON tc.course_id = c.id
        JOIN teachers t ON tc.teacher_id = t.id";

$sql_grades = "
    SELECT 
        courses.id,
        grades.student_id,
        grades.term
FROM grades
JOIN courses ON grades.course_id = courses.id
WHERE grades.student_id = :student_id AND grades.term = : '2024-2025 1 Term'
AND grades.term = :term
ORDER BY courses.code
";
$result = $pdo->query($sql);
$schedule = [];

if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $day = strtolower($row['week_day']);
        $hour = $row['start_time'];
        $course_info = $row['code'] . " " . $row['name'] . "<br>" . $row['first_name'];
        $schedule[$day][$hour] = $course_info;
    }
}

$days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
$hours = [
    "08:30:00", "09:30:00", "10:30:00", "11:30:00", "12:30:00",
    "13:30:00", "14:30:00", "15:30:00", "16:30:00", "17:30:00",
    "18:30:00", "19:30:00"
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Course Schedule</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Battambang:wght@100;400;700;900&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="course-schedule/index.css" />
</head>
<body>
<!--  TOP BAR-->
<div class="top-bar">
    <div class="left-section">
        <a href="page.html">
            <img src="course-schedule/assets/logo_sdu_general.png" alt="Logo" class="logo-img">
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
                <li><a class="dropdown-item" href="../profile/profile.php">My Profile</a></li>
                <li><a class="dropdown-item" href="../dashboard/page.php">My Dashboard</a></li>
                <li><a class="dropdown-item" href="../login/login.php">Log Out</a></li>
            </ul>
        </li>
    </ul>
</div>

<!--MAIN PART-->
<div style="padding-top: 10%; " >
</div>

<table class="timetable1">
    <thead>
    <tr>
        <th>Day/Hour</th>
        <?php foreach ($days as $day): ?>
            <th><?php echo ucfirst($day); ?></th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($hours as $hour): ?>
        <tr>
            <td><?php echo substr($hour, 0, 5); ?></td> <!-- Display hour (HH:MM) -->
            <?php foreach ($days as $day): ?>
                <td>
                    <?php
                    // Display course info if it exists for the day and hour
                    echo isset($schedule[$day][$hour]) ? $schedule[$day][$hour] : '';
                    ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<!--      FOOTER -->
<div class="rectangle-140">
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
<script>
    // JavaScript to toggle between the two tables
    document.getElementById('tableToggleCheckbox').addEventListener('change', function() {
        const table1 = document.getElementById('table1');
        const table2 = document.getElementById('table2');

        if (this.checked) {
            table1.style.display = 'none';
            table2.style.display = 'block';
        } else {
            table1.style.display = 'block';
            table2.style.display = 'none';
        }
    });
</script>
</body>
</html>