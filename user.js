// Проверка авторизации и вызов всплывающего окна
document.addEventListener("DOMContentLoaded", () => {
    const userLogin = document.getElementById("userLogin");

    fetch("profile.php")
        .then((response) => response.json())
        .then((data) => {
            if (data.login === "Guest") {
                // Если не авторизован, показать всплывающее окно через 4 секунды
                setTimeout(() => {
                    showRegistrationPopup();
                }, 4000);
            } else {
                // Установить логин пользователя
                userLogin.textContent = data.login;

                // Установить аватар пользователя
                const userAvatar = document.getElementById("userAvatar");
                userAvatar.src = data.avatar;
            }
        })
        .catch((error) => console.error("Ошибка загрузки профиля:", error));
});

// Функция для отображения всплывающего окна регистрации
function showRegistrationPopup() {
    const popup = document.createElement("div");
    popup.style.position = "fixed";
    popup.style.top = "50%";
    popup.style.left = "50%";
    popup.style.transform = "translate(-50%, -50%)";
    popup.style.width = "300px";
    popup.style.padding = "20px";
    popup.style.backgroundColor = "white";
    popup.style.boxShadow = "0 4px 6px rgba(0, 0, 0, 0.1)";
    popup.style.borderRadius = "10px";
    popup.style.textAlign = "center";
    popup.style.zIndex = "1000";

    popup.innerHTML = `
        <h2>Регистрация</h2>
        <p>Вы еще не зарегистрированы. Пройдите регистрацию!</p>
        <a href="register.html" style="display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">Регистрация</a>
    `;

    document.body.appendChild(popup);
}

// Функция для закрытия всплывающего окна
function closePopup(button) {
    const popup = button.parentElement;
    document.body.removeChild(popup);
}









function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

document.getElementById('registerForm').addEventListener('submit', (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);

    fetch('register.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => {
            if (response.redirected) {
                // Сервер перенаправляет пользователя на профиль
                window.location.href = response.url;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при регистрации.');
        });
});


fetch('profile.php')
    .then(response => response.json())
    .then(data => {
        if (data.avatar) {
            document.getElementById('userAvatar').src = data.avatar;
        }
    });

