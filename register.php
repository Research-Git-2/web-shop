<?php
session_start();
require_once('db.php');

$f_name = $_POST["first_name"];
$l_name = $_POST["last_name"];
$m_name = $_POST["middle_name"];
$login = $_POST["login"];
$password = $_POST["password"];
$repeat_password = $_POST["repeat_password"];
$email = $_POST["email"];

// Проверка паролей
if ($password !== $repeat_password) {
    die("Error: Passwords do not match.");
}

// Проверка обязательных полей
if (empty($f_name) || empty($l_name) || empty($login) || empty($password) || empty($email)) {
    die("Error: All fields are required.");
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Обработка аватара
$avatarPath = 'uploads/default.jpg'; // Значение по умолчанию
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
            $avatarPath = $destPath; // Путь к загруженному файлу
        } else {
            die("Error: Unable to save the uploaded file.");
        }
    } else {
        die("Error: Invalid file format.");
    }
}

// Сохранение пользователя в базе данных
$sql = "INSERT INTO users (first_name, last_name, middle_name, login, password, email, avatar) 
        VALUES ($1, $2, $3, $4, $5, $6, $7) RETURNING id, avatar";
$result = pg_query_params($conn, $sql, [$f_name, $l_name, $m_name, $login, $hashed_password, $email, $avatarPath]);

if (!$result) {
    die("Error in SQL query: " . pg_last_error());
}

// Сохраняем данные пользователя в сессии
$user = pg_fetch_assoc($result);
$_SESSION['user_id'] = $user['id'];
$_SESSION['avatar'] = $user['avatar'];
$_SESSION['login'] = $login;

// Перенаправляем на index2.html
header("Location: index.html");
exit;
?>
