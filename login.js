
const loginForm = document.getElementById("loginForm");
const errorMessage = document.getElementById("errorMessage");

loginForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const username = document
        .getElementById("username")
        .value.trim();

    const password = document
        .getElementById("password")
        .value;

    if (!username || !password.trim()) {
        errorMessage.textContent =
            "Username dan password wajib diisi.";
        return;
    }

    localStorage.setItem("username", username);

    window.location.href = "index.html";
});
