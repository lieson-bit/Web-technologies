// Save username in cookies for 1 day
function saveName() {
    const userName = document.getElementById("nameInput").value.trim();
    if (userName) {
        document.cookie = `username=${encodeURIComponent(userName)}; expires=${new Date(Date.now() + 86400000).toUTCString()}; path=/`;
        localStorage.setItem("visitCount", localStorage.getItem("visitCount") ? parseInt(localStorage.getItem("visitCount")) + 1 : 1);
        window.location.href = "welcome.html"; // Redirect to welcome page
    }
}

// Get cookie by name
function getCookie(name) {
    const cookies = Object.fromEntries(
        document.cookie.split("; ").map(cookie => cookie.split("="))
    );
    return cookies[name] ? decodeURIComponent(cookies[name]) : "";
}

// Display greeting message
function displayGreeting() {
    const userName = getCookie("username");
    const greetingElement = document.getElementById("greetingMessage");
    if (greetingElement) {
        greetingElement.textContent = userName ? `Привет, ${userName}!` : `Привет, незнакомец!`;
    }
}

// Track user visits using localStorage
function trackVisits() {
    const visitCount = Number(localStorage.getItem("visitCount") || 0);
    document.getElementById("sessionCountMessage").textContent = `Вы посетили эту страницу ${visitCount} раз(а).`;
}

// Event Listeners
document.addEventListener("DOMContentLoaded", () => {
    // Attach event listener for save button
    const saveButton = document.getElementById("saveButton");
    if (saveButton) {
        saveButton.addEventListener("click", saveName);
    }

    // Display greeting on welcome page
    displayGreeting();

    // Attach event listener for visit count button
    const checkVisitsButton = document.getElementById("checkVisits");
    if (checkVisitsButton) {
        checkVisitsButton.addEventListener("click", trackVisits);
    }
});
