// Шаг 1: Получить размер матрицы от пользователя
let n = parseInt(prompt("Введите количество строк (n):"));
let m = parseInt(prompt("Введите количество столбцов (m):"));

if (isNaN(n) || isNaN(m) || n <= 0 || m <= 0) {
    alert("❌ Пожалуйста, введите корректные положительные числа.");
} else {
    let matrix = [];

    // Шаг 2: Спросить пользователя, хочет ли он вводить значения вручную или заполнить автоматически
    let choice = prompt("Введите '1', чтобы ввести значения вручную, или '2', чтобы заполнить случайными числами:");

    if (choice === "1") {
        // Ввод вручную
        for (let i = 0; i < n; i++) {
            let row = prompt(`Введите ${m} чисел через пробел для строки ${i + 1}:`).split(" ").map(Number);
            while (row.length !== m || row.some(isNaN)) {
                row = prompt(`❌ Некорректный ввод! Введите ${m} чисел, разделенных пробелами:`).split(" ").map(Number);
            }
            matrix.push(row);
        }
    } else {
        // Автозаполнение случайными числами от -10 до 10
        for (let i = 0; i < n; i++) {
            let row = Array.from({ length: m }, () => Math.floor(Math.random() * 21) - 10);
            matrix.push(row);
        }
    }

    // Шаг 3: Форматирование исходной матрицы для отображения
    let originalMatrixText = "\n📌 **Исходная матрица:**\n" +
        matrix.map(row => row.map(num => num.toString().padStart(4)).join(" ")).join("\n");

    // Шаг 4: Удаление строк с более чем 3 отрицательными числами
    let filteredMatrix = matrix.filter(row => row.filter(num => num < 0).length <= 3);

    // Шаг 5: Форматирование отфильтрованной матрицы для отображения
    let filteredMatrixText = filteredMatrix.length
        ? "\n📌 **Отфильтрованная матрица (удалены строки с более чем 3 отрицательными числами):**\n" +
          filteredMatrix.map(row => row.map(num => num.toString().padStart(4)).join(" ")).join("\n")
        : "❌ Не осталось допустимых строк.";

    // Шаг 6: Отобразить результат в поле вывода
    document.getElementById('myrezult').value = `${originalMatrixText}\n\n${filteredMatrixText}`;
}





let canvas = document.getElementById("drawingCanvas");
let ctx = canvas.getContext("2d");

// Draw the outer blue-edged rectangle
ctx.strokeStyle = "darkblue";
ctx.lineWidth = 4;
ctx.strokeRect(30, 30, 320, 320); // Adjusted size for more space around the grid

// Function to draw an individual square with thicker dark blue borders and spacing
function drawSquare(x, y, color) {
    ctx.fillStyle = color;
    ctx.fillRect(x, y, 40, 40); // Smaller squares (40x40)
    ctx.strokeStyle = "darkblue"; // Dark blue for the border
    ctx.lineWidth = 4; // Thicker border
    ctx.strokeRect(x, y, 40, 40); // Draw square border
}

// Loop to draw the 5x5 grid with larger spaces between squares
for (let row = 0; row < 5; row++) {
    for (let col = 0; col < 5; col++) {
        let x = 50 + col * 60; // Increased spacing between columns
        let y = 50 + row * 60; // Increased spacing between rows
        let color = col < 3 ? "blue" : "yellow"; // Choose color based on column
        drawSquare(x, y, color);
    }
}

