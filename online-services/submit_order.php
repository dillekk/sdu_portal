<?php
session_start(); // Начинаем сессию

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Сохраняем данные в сессии
    $_SESSION['order_type'] = $_POST['order_type'];
    $_SESSION['language'] = $_POST['language'];
    $_SESSION['delivery_method'] = $_POST['delivery_method'];

    // Подключение к базе данных
    $servername = "localhost"; 
    $username = "root";       
    $password = "";            
    $dbname = "sdu_portal";        

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Получаем данные из сессии
    $order_type = $_SESSION['order_type'] ?? '';
    $language = $_SESSION['language'] ?? '';
    $delivery_method = $_SESSION['delivery_method'] ?? '';

    if (!empty($order_type) && !empty($language) && !empty($delivery_method)) {  
        // Вставляем данные в базу
        $sql = "INSERT INTO orders (type, language, delivery_method) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $order_type, $language, $delivery_method);
            if ($stmt->execute()) {
                // Перенаправление на страницу успеха
                header('Location: success_page.html');
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Please fill in all fields.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Online Services</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Battambang:wght@100;400;700;900&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css" />
</head>
<body>
    <!--  TOP BAR-->


    <span class="online-services">Online services</span>
    <div class="flex-row-d">
        <div class="rectangle-2">
            <span class="send-order">Send order</span>
        </div>
        <div class="rectangle-3"><span class="orders">Orders</span></div>
    </div>

    <form action="" method="POST">
        <div class="rectangle-service" id="form1">
            <div class="flex-row">
                <button type="button" class="rectangle-4">
                    <span class="title">Order type</span>
                </button>
                <div class="rectangle-5">
                    <select id="orderType" name="order_type" class="rectangle-6" onchange="updateDescription()">
                        <option value=""></option>
                        <option value="Transcript">Transcript</option>
                        <option value="Military Service(Certificate №3)">Military Service(Certificate №3)</option>
                        <option value="Information about Studying Place(University)">Information about Studying Place(University)</option>
                    </select>
                </div>
            </div>
            <div class="flex-row">
                <button class="rectangle-4">
                    <span class="title">Description of Document</span>
                </button>
                <div class="rectangle-5" id="description"></div>
            </div>      
            <div class="flex-row">
                <button type="button" class="rectangle-4">
                    <span class="title">Language</span>
                </button>
                <div class="rectangle-5">
                    <select name="language" class="rectangle-6">
                        <option value=""></option>
                        <option value="kz">Kazakh</option>
                        <option value="rus">Russian</option>
                        <option value="en">English</option>
                    </select>
                </div>
            </div>
            <div class="flex-row">
                <button type="button" class="rectangle-4">
                    <span class="title">Delivery Method</span>
                </button>
                <div class="rectangle-5">
                    <select name="delivery_method" class="rectangle-6">
                        <option value=""></option>
                        <option value="Advising Desk">Advising Desk</option>
                        <option value="Online">Online</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="rectangle-11"><span class="send">Send</span></button>
        </div>
    </form>

    <div class="rectangle-service" id="form2" style="display: none">
        <div class="rectangle-50">
            <div class="image"></div>
            <span class="order-successfully-sent">Order successfully sent!</span>
        </div>
    </div>

    <script>
        function updateDescription() {
            const orderType = document.getElementById("orderType").value;
            const description = document.getElementById("description");

            const descriptions = {
                "Transcript": "Grades",
                "Military Service(Certificate №3)": "Military Service Proof",
                "Information about Studying Place(University)": "University Enrollment Details"
            };

            description.textContent = descriptions[orderType] || "";
        }
    </script>
</body>
</html>
