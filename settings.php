<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require_once 'db.php';
$userId = $_SESSION['user_id'];

// Получение текущих данных пользователя
$query = "SELECT first_name, last_name, middle_name, email, avatar FROM users WHERE id = $1";
$result = pg_query_params($conn, $query, [$userId]);

if (!$result || pg_num_rows($result) === 0) {
    die("Пользователь не найден.");
}

$user = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки пользователя</title>
    <link rel="stylesheet" href="settings.css">
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <div class="settings-container">
        <form id="updateForm" action="uppdate.php" method="POST" enctype="multipart/form-data">
            <h2 class="reg-title">Изменение данных</h2>

            <!-- Поле для имени -->
            <input
                type="text"
                id="first_name"
                name="first_name"
                placeholder="Имя"
                value="<?php echo htmlspecialchars($user['first_name']); ?>"
                required />

            <!-- Поле для фамилии -->
            <input
                type="text"
                id="last_name"
                name="last_name"
                placeholder="Фамилия"
                value="<?php echo htmlspecialchars($user['last_name']); ?>"
                required />

            <!-- Поле для отчества -->
            <input
                type="text"
                id="middle_name"
                name="middle_name"
                placeholder="Отчество"
                value="<?php echo htmlspecialchars($user['middle_name']); ?>" />

            <!-- Поле для email -->
            <input
                type="text"
                id="email"
                name="email"
                placeholder="email"
                value="<?php echo htmlspecialchars($user['email']); ?>"
                required />

            <!-- Поле для загрузки аватара -->
            <label for="avatarUpload">Загрузить новый аватар:</label>
            <input type="file" id="avatarUpload" name="avatar" accept="image/*" />

            <!-- Предпросмотр аватара -->
            <div id="avatarPreviewContainer">
                <img
                    id="avatarPreview"
                    src="<?php echo htmlspecialchars($user['avatar']); ?>"
                    alt="Текущий аватар"
                    style="display: block; max-width: 150px; margin-bottom: 10px;" />
                <button type="button" id="removeAvatar">Удалить аватар</button>
            </div>

            <!-- Кнопка для сохранения -->
            <button type="submit" style="margin-top: 10px;">Сохранить</button>
            <p class="into">
                Вернуться на <a href="index.html">главную</a>
            </p>
        </form>

    </div>
</body
    </html>