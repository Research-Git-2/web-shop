<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style2.css">
    <script src="script2.js"></script>
</head>

<body>
    <div class="form-container">
        <form id="loginForm" action="login.php" method="post">
            <h2 class="title">Вход</h2>
            <input type="text" placeholder="login" name="login">
            <input type="password" placeholder="password" name="password">
            <button type="submit">Вход</button>
            <p class="reg">Не зарегистрированы? <a href="#" onclick="toggleForms()">Регистрация</a></p>
        </form>

        <form id="registerForm" action="register.php" method="post" enctype="multipart/form-data" style="display: none;">
            <h2 class="reg-title">Регистрация</h2>
            <input type="text" placeholder="first name" name="first_name">
            <input type="text" placeholder="last name" name="last_name">
            <input type="text" placeholder="middle name" name="middle_name">
            <input type="text" placeholder="login" name="login">
            <input type="password" placeholder="password" name="password">
            <input type="password" placeholder="repeat password" name="repeat_password">
            <input type="text" placeholder="email" name="email">

            <label for="avatarUpload">Загрузить аватар:</label>
            <input type="file" id="avatarUpload" name="avatar" accept="image/*">
            <div id="avatarPreviewContainer">
                <img id="avatarPreview" src="#" alt="Preview" style="max-width: 150px; max-height: 150px; display: block; margin-bottom: 10px;">
                <button type="button" id="removeAvatar">Удалить аватар</button>
            </div>

            <button type="submit">Регистрация</button>
            <p class="into">Уже зарегистрированы? <a href="#" onclick="toggleForms()">Вход</a></p>
        </form>

        <script>
            const avatarUpload = document.getElementById('avatarUpload');
            const avatarPreviewContainer = document.getElementById('avatarPreviewContainer');
            const avatarPreview = document.getElementById('avatarPreview');
            const removeAvatarButton = document.getElementById('removeAvatar');

            avatarUpload.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        avatarPreview.src = e.target.result;
                        avatarPreviewContainer.style.display = 'block';
                    };

                    reader.readAsDataURL(file);
                } else {
                    resetAvatarPreview();
                }
            });

            removeAvatarButton.addEventListener('click', () => {
                resetAvatarPreview();
            });

            function resetAvatarPreview() {
                avatarUpload.value = '';
                avatarPreview.src = '#';
                avatarPreviewContainer.style.display = 'none';
            }
        </script>
    </div>
</body>

</html>