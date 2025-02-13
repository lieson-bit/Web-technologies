// Task 2: External script with multiple abilities
console.log("Task 2: External script loaded.");

// Display a message with last name and group number
document.getElementById('output').innerHTML += `<p>Моя фамилия: Иванов, номер группы: 456.</p>`;

// Calculate the square of a number (example additional function)
function squareNumber(num) {
    return num * num;
}
document.getElementById('output').innerHTML += `<p>Квадрат числа 7: ${squareNumber(7)}</p>`;

// Generate a random number between 1 and 100
function randomNumber() {
    return Math.floor(Math.random() * 100) + 1;
}
document.getElementById('output').innerHTML += `<p>Случайное число: ${randomNumber()}</p>`;

fetch('long_message.txt')
    .then(response => response.text())
    .then(data => {
        document.getElementById('output').innerHTML += `<p>${data}</p>`;
    });
