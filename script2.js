function toggleForms() {
  var loginForm = document.getElementById("loginForm");
  var registerForm = document.getElementById("registerForm");

  if (loginForm.style.display === "none") {
    loginForm.style.display = "block";
    registerForm.style.display = "none";
  } else {
    loginForm.style.display = "none";
    registerForm.style.display = "block";
  }

  resetAvatarPreview();
}