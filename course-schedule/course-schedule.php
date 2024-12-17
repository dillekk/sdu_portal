<?php
session_start();
$host = 'localhost';
$dbname = 'sdu_portal';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

$total_price = 0;

// Проверяем, есть ли ID пользователя в сессии
if (!isset($_SESSION['user_id'])) {
    echo "No student ID in session.";
    exit(); // Завершаем выполнение скрипта, если student_id нет в сессии
}

$student_id = $_SESSION['user_id']; // Получаем student_id из сессии

// Получаем информацию о студенте
$sql = "SELECT * FROM student WHERE id = :student_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['student_id' => $student_id]);

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "Пользователь не найден.";
    exit();
}

$sql_courses = "
    SELECT 
        courses.code,
        MAX(CASE WHEN teachercourse.type = 'N' THEN teachercourse.group_number ELSE '-' END) AS N,
        MAX(CASE WHEN teachercourse.type = 'P' THEN teachercourse.group_number ELSE '-' END) AS P,
        MAX(CASE WHEN teachercourse.type = 'L' THEN teachercourse.group_number ELSE '-' END) AS L,
        courses.name AS course_name,
        courses.cr,
        courses.ects,
        'First Time' AS status,
        courses.price
    FROM student_course_registration
    INNER JOIN courses ON student_course_registration.course_id = courses.id
    LEFT JOIN teachercourse ON teachercourse.course_id = courses.id
    WHERE student_course_registration.student_id = :student_id
    GROUP BY courses.code, courses.name, courses.cr, courses.ects, courses.price
    ORDER BY courses.code
";

$stmt_courses = $pdo->prepare($sql_courses);
$stmt_courses->execute(['student_id' => $student_id]);
$courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);

// Подсчитываем общую стоимость
foreach ($courses as $course) {
    $total_price += $course['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Course Registration</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Battambang:wght@100;400;700;900&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css" />
</head>
<body>
<!--  TOP BAR-->
<div class="top-bar">
    <div class="left-section">
        <a href="page.html">
            <img src="assets/logo_sdu_general.png" alt="Logo" class="logo-img">
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
<div style="padding-top: 10%; " ></div>

<h1>Course Registration (2024-2025) Fall</h1>
<div class="term-selection">
    <label for="term">Year and term:</label>
    <select id="term">
        <option value="1">2024-2025 1 Term</option>
    </select>
    <button>Show</button>
</div>
<table>
    <thead>
    <tr>
        <th>Code</th>
        <th>N</th>
        <th>P</th>
        <th>L</th>
        <th>Course Name</th>
        <th>cr</th>
        <th>ects</th>
        <th>Status</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?= htmlspecialchars($course['code']) ?></td>
                <td><?= htmlspecialchars($course['N']) ?></td>
                <td><?= htmlspecialchars($course['P']) ?></td>
                <td><?= htmlspecialchars($course['L']) ?></td>
                <td><?= htmlspecialchars($course['course_name']) ?></td>
                <td><?= htmlspecialchars($course['cr']) ?></td>
                <td><?= htmlspecialchars($course['ects']) ?></td>
                <td><?= htmlspecialchars($course['status']) ?></td>
                <td><?= number_format($course['price'], 0, '.', ',') ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="9">This student is not registered for courses.</td>
        </tr>
    <?php endif; ?>
    <!-- Строка для общей стоимости -->
    <tr>
        <td colspan="8" style="text-align: right; font-weight: bold;">Total Price</td>
        <td><?= number_format($total_price, 0, '.', ',') ?> KZT</td>
    </tr>
    </tbody>
</table>

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
                <span class="nodes">FACULTY OF ENGINEERING AND NATURAL SCIENCES</span>
            </a>
        </div>

        <div class="flex-columns">
            <span class="titles">CONTACTS</span>
            <a href="https://www.instagram.com/sdu.kz/">
                <span class="nodes">Instagram</span>
            </a>
            <a href="https://www.facebook.com/SDU.Kazakhstan">
                <span class="nodes">Facebook</span>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>