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

// Modify the query to include the term condition
$sql_grades = "
    SELECT 
        courses.code,
        courses.name AS course_name,
        courses.cr AS cr,
        courses.ects AS ects,
        grades.student_id,
        grades.term,
        grades.total_grade,
    CASE 
        WHEN grades.grade >= 95 THEN 'A'      
        WHEN grades.grade >= 90 THEN 'A-'     
        WHEN grades.grade >= 85 THEN 'B+'     
        WHEN grades.grade >= 80 THEN 'B'      
        WHEN grades.grade >= 75 THEN 'B-'     
        WHEN grades.grade >= 70 THEN 'C+'     
        WHEN grades.grade >= 65 THEN 'C'      
        WHEN grades.grade >= 60 THEN 'C-'     
        WHEN grades.grade >= 55 THEN 'D+'     
        WHEN grades.grade >= 50 THEN 'D'      
        WHEN grades.grade >= 25 THEN 'FX'     
        ELSE 'F' 
    END AS letter_grade
FROM grades
JOIN courses ON grades.course_id = courses.id
WHERE grades.student_id = :student_id
ORDER BY courses.code
";

// Prepare the statement and execute with the term as a parameter
$stmt_grades = $pdo->prepare($sql_grades);
$stmt_grades->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$stmt_grades->execute();
$grades = $stmt_grades->fetchAll(PDO::FETCH_ASSOC);

$gradesByTerm = [];
foreach ($grades as $grade) {
    $gradesByTerm[$grade['term']][] = $grade;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Grades List</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Battambang:wght@100;400;700;900&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../grades-list/index.css" />
</head>
<body>
<!--  TOP BAR-->
<div class="top-bar" style="width: 95%; ">
    <div class="left-section">
        <a href="../dashboard/page.html">
            <img src="../dashboard/assets/images/logo_sdu_general.png" alt="Logo" class="logo-img">
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

<!--MAIN CONTENT-->
<div style="padding-top: 3%; margin-left: 10%;">
    <span class="grades-list">Transcript</span>
    <?php if (!empty($gradesByTerm)): ?>

        <?php foreach ($gradesByTerm as $term => $termGrades): ?>
            <h4><?php echo htmlspecialchars($term); ?></h4>
            <table class="timetable1" style="width: 80%; margin-bottom: 4%">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Course Name</th>
                    <th>Credits</th>
                    <th>ECTS</th>
                    <th>Total Grade</th>
                    <th>Letter Grade</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($termGrades as $grade): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($grade['code']); ?></td>
                        <td><?php echo htmlspecialchars($grade['course_name']); ?></td>
                        <td><?php echo htmlspecialchars($grade['cr']); ?></td>
                        <td><?php echo htmlspecialchars($grade['ects']); ?></td>
                        <td><?php echo htmlspecialchars($grade['total_grade']); ?></td>
                        <td><?php echo htmlspecialchars($grade['letter_grade']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">This student has no grades recorded.</p>
    <?php endif; ?>
</div>

<!-- FOOTER -->
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    const dropdownButton = document.getElementById('dropdownMenu2');
    const termText = document.querySelector('.term-5');

    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            const selectedText = this.textContent;
            dropdownButton.textContent = selectedText; // Change dropdown button text
            termText.textContent = selectedText; // Change term-5 text
        });
    });
</script>
</body>
</html>



