<?php
$dsn = 'mysql:host=localhost;dbname=test_3.8';
$username = "root";
$password = "1";
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
// Проверка, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $username = $_POST['username'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    // Проверка на корректность данных
    if (empty($username) || empty($rating) || empty($comment)) {
        die("All fields are required.");
    }
    // Подготовленный запрос для вставки данных в базу
    $sql = "INSERT INTO reviews (username, rating, comment) VALUES (:username,
    :rating, :comment)";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':rating' => $rating,
            ':comment' => $comment
        ]);
        echo "Review saved successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Подключение к базе данных
$dsn = "mysql:host=localhost;dbname=test_3.8";
$username = "root";
$password = "";
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
// Обработка запроса на отмену заказа
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из запроса
    $order_id = $_POST['order_id'];
    $user_id = $_POST['user_id'];
    $cancellation_reason = $_POST['cancellation_reason'];
    // Проверяем, что все необходимые поля заполнены
    if (empty($order_id) || empty($user_id) || empty($cancellation_reason)) {
        die("All fields are required.");
    }
    // Подготовка SQL-запроса для сохранения данных об отмене заказа
    $sql = "INSERT INTO order_cancellations (order_id, user_id, cancellation_reason)
VALUES (:order_id, :user_id, :cancellation_reason)";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':order_id' => $order_id,
            ':user_id' => $user_id,
            ':cancellation_reason' => $cancellation_reason
        ]);
        echo "Order cancellation saved successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$dsn = "mysql:host=localhost;dbname=test_3.8";
$username = "root";
$password = "";
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
// Получаем идентификатор товара
$product_id = $_GET['product_id'];
// Подготовка SQL-запроса для выборки отзывов о товаре
$sql = "SELECT username, rating, comment, created_at
FROM reviews
WHERE product_id = :product_id
ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['product_id' => $product_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Отображаем отзывы
if ($reviews) {
    foreach ($reviews as $review) {
        echo "<div>";
        echo "<strong>" . htmlspecialchars($review['username']) . "</strong><br>";
        echo "Rating: " . htmlspecialchars($review['rating']) . "/5<br>";
        echo "Comment: " . htmlspecialchars($review['comment']) . "<br>";
        echo "Date: " . htmlspecialchars($review['created_at']) . "<br>";
        echo "</div><hr>";
    }
} else {
    echo "No reviews for this product.";
}
?>
