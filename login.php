<?php
session_start();
require_once('db.php');

$login = $_POST["login"] ?? null;
$password = $_POST["password"] ?? null;

if (empty($login) || empty($password)) {
    die("Error: All fields are required.");
}

$sql = "SELECT id, password, avatar FROM users WHERE login = $1";
$result = pg_query_params($conn, $sql, [$login]);

if (pg_num_rows($result) == 0) {
    die("Error: User not found.");
}

$row = pg_fetch_assoc($result);

// Проверяем хэш пароля
if (!password_verify($password, $row["password"])) {
    die("Error: Invalid password.");
}

// Сохраняем информацию о пользователе в сессии
$_SESSION['user_id'] = $row['id'];
$_SESSION['avatar'] = $row['avatar'];

// Перенаправляем пользователя
header("Location: index.html");
exit;
