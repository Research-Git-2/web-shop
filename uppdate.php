<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require_once 'db.php';
$userId = $_SESSION['user_id'];

// Получение новых данных из формы
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$middle_name = $_POST['middle_name'] ?? '';
$email = $_POST['email'] ?? '';
$avatarPath = null;

// Проверка обязательных полей
if (empty($first_name) || empty($last_name) || empty($email)) {
    die("Все обязательные поля должны быть заполнены.");
}

// Обработка загрузки нового аватара
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileTmpPath = $_FILES['avatar']['tmp_name'];
    $fileName = basename($_FILES['avatar']['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExt, $allowedExts)) {
        $newFileName = uniqid('avatar_', true) . '.' . $fileExt;
        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $avatarPath = $destPath;
        } else {
            die("Ошибка при сохранении файла.");
        }
    } else {
        die("Недопустимый формат файла.");
    }
}

// Обновление данных пользователя
$query = "UPDATE users SET first_name = $1, last_name = $2, middle_name = $3, email = $4";
$params = [$first_name, $last_name, $middle_name, $email];

if ($avatarPath) {
    $query .= ", avatar = $5";
    $params[] = $avatarPath;
}

// Добавляем условие WHERE для обновления только текущего пользователя
$query .= " WHERE id = $" . (count($params) + 1);
$params[] = $userId;

$result = pg_query_params($conn, $query, $params);

if ($result) {
    if ($avatarPath) {
        $_SESSION['avatar'] = $avatarPath; // Обновляем аватар в сессии
    }
    header("Location: settings.php?success=1");
    exit;
} else {
    die("Ошибка обновления данных: " . pg_last_error($conn));
}
?>
