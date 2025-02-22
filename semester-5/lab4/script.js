document.addEventListener("DOMContentLoaded", () => {
    // Load text for the left card
    fetch('/images/left.txt')
        .then(response => response.text())
        .then(data => {
            document.getElementById('left-text').innerHTML = data;
        });

    // Load text for the center card
    fetch('/images/center.txt')
        .then(response => response.text())
        .then(data => {
            document.getElementById('center-text').innerHTML = data;
        });

    // Load text for the right card
    fetch('images/right.txt')
        .then(response => response.text())
        .then(data => {
            document.getElementById('right-text').innerHTML = `<div class="card-content">${data}</div>`;
        });
});


