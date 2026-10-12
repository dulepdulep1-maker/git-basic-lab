
const loginLink = document.getElementById("loginLink");
const logoutBtn = document.getElementById("logoutBtn");
const welcomeMessage = document.getElementById("welcomeMessage");
const mainButton = document.getElementById("mainButton");

function updatePage() {
    const username = localStorage.getItem("username");

    if (username) {
        if (loginLink) loginLink.hidden = true;
        if (logoutBtn) logoutBtn.hidden = false;

        if (welcomeMessage) {
            welcomeMessage.textContent =
                "Halo, " + username + "! Kamu sudah login.";
        }

        if (mainButton) mainButton.hidden = true;
    } else {
        if (loginLink) loginLink.hidden = false;
        if (logoutBtn) logoutBtn.hidden = true;

        if (welcomeMessage) {
            welcomeMessage.textContent =
                "Silakan login untuk mencoba fitur website.";
        }

        if (mainButton) mainButton.hidden = false;
    }
}

if (logoutBtn) {
    logoutBtn.addEventListener("click", function () {
        localStorage.removeItem("username");
        updatePage();
        alert("Kamu berhasil logout.");
    });
}

updatePage();
