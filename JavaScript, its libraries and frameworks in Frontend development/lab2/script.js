// Функция filterArray принимает массив и функцию обратного вызова (callback).
// Она проходит по массиву и добавляет в новый массив только те элементы, для которых callback возвращает true.
function filterArray(arr, callback) {
    const result = [];
    for (let i = 0; i < arr.length; i++) {
        if (callback(arr[i])) {
            result.push(arr[i]);
        }
    }
    return result;
}

// Функция isEven проверяет, является ли число четным.
const isEven = (num) => num % 2 === 0;

// Функция isOdd проверяет, является ли число нечетным.
const isOdd = (num) => num % 2 !== 0;

// Функция fetchData принимает URL и возвращает Promise.
// Она выполняет HTTP-запрос с помощью fetch и обрабатывает ответ.
function fetchData(url) {
    return new Promise((resolve, reject) => {
        fetch(url)
            .then(response => {
                if (response.status === 200) { // Если запрос успешен (статус 200)
                    return response.text(); // Преобразуем ответ в строку
                } else {
                    throw new Error(`Ошибка запроса: статус ${response.status}`); // Генерируем ошибку для других статусов
                }
            })
            .then(data => resolve(data)) // Разрешаем Promise с полученными данными
            .catch(error => reject(error.message)); // Отклоняем Promise в случае ошибки
    });
}

// Функция для фильтрации чисел и отображения результата
function runFilter() {
    const numbersInput = document.getElementById('numbers').value;
    const numbers = numbersInput.split(',').map(num => parseInt(num.trim()));
    
    const evenNumbers = filterArray(numbers, isEven);
    const oddNumbers = filterArray(numbers, isOdd);

    document.getElementById('evenNumbers').textContent = evenNumbers.length > 0 ? evenNumbers.join(', ') : "No even numbers found.";
    document.getElementById('oddNumbers').textContent = oddNumbers.length > 0 ? oddNumbers.join(', ') : "No odd numbers found.";
}

// Функция для выполнения запроса и отображения данных
function runFetchData() {
    const url = document.getElementById('url').value;

    fetchData(url)
        .then(data => {
            document.getElementById('fetchedData').textContent = data;
        })
        .catch(error => {
            document.getElementById('fetchedData').textContent = `Error: ${error}`;
        });
}
