// Массив студентов группы 1
const group1 = [
    { name: "Alice", score: 85 }, { name: "Bob", score: 90 },
    { name: "Charlie", score: 78 }, { name: "David", score: 92 },
    { name: "Eve", score: 88 }, { name: "Frank", score: 79 },
    { name: "Grace", score: 95 }, { name: "Hank", score: 81 },
    { name: "Ivy", score: 74 }, { name: "Jack", score: 84 }
];

// Массив студентов группы 2
const group2 = [
    { name: "Liam", score: 76 }, { name: "Mia", score: 91 },
    { name: "Noah", score: 89 }, { name: "Olivia", score: 83 },
    { name: "Parker", score: 94 }, { name: "Quinn", score: 70 },
    { name: "Riley", score: 85 }, { name: "Sophia", score: 80 },
    { name: "Theo", score: 97 }, { name: "Uma", score: 65 }
];

// Функция для выбора студентов, набравших >= 80 баллов
function selectStudents() {
    // Фильтруем студентов, у которых оценка >= 80
    const selectedGroup1 = group1.filter(student => student.score >= 80);
    const selectedGroup2 = group2.filter(student => student.score >= 80);

    // Объединяем два массива
    const selectedStudents = selectedGroup1.concat(selectedGroup2);

    // Вычисляем количество выбранных студентов в каждой группе
    const totalSelectedGroup1 = selectedGroup1.length;
    const totalSelectedGroup2 = selectedGroup2.length;
    const totalSelected = selectedStudents.length;

    // Вычисляем средний балл для выбранных студентов
    const totalScore = selectedStudents.reduce((sum, student) => sum + student.score, 0);
    const avgScore = totalScore / selectedStudents.length;

    // Формируем сообщение о результатах
    let resultMessage = `
        В группе 1 выбрано ${totalSelectedGroup1} студентов.<br>
        В группе 2 выбрано ${totalSelectedGroup2} студентов.<br>
        Всего выбрано студентов: ${totalSelected}.<br>
        Средний балл выбранных студентов: ${avgScore.toFixed(2)}.<br>
    `;

    // Отображаем выбранных студентов в модальном окне
    displayModal(selectedStudents);

    // Отображаем сообщение с результатами
    document.getElementById("result").innerHTML = resultMessage;
}

// Функция для отображения модального окна с выбранными студентами
function displayModal(students) {
    const modal = document.getElementById("studentModal");
    const studentList = document.getElementById("selectedStudentsList");
    
    // Очищаем предыдущий список студентов
    studentList.innerHTML = '';

    // Создаем элементы списка для каждого выбранного студента
    students.forEach(student => {
        const listItem = document.createElement("li");
        listItem.textContent = `${student.name} - ${student.score} баллов`;
        studentList.appendChild(listItem);
    });

    // Показываем модальное окно
    modal.style.display = 'block';
}

// Функция для закрытия модального окна
function closeModal() {
    document.getElementById("studentModal").style.display = 'none';
}
