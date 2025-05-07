// Выбираем все элементы <p>
const paragraphs = document.getElementsByTagName('p');

// Перебираем каждый элемент и изменяем его стиль
for (let i = 0; i < paragraphs.length; i++) {
    paragraphs[i].style.color = "blue";
    paragraphs[i].style.border = "2px solid red";
    paragraphs[i].style.padding = "10px";
}