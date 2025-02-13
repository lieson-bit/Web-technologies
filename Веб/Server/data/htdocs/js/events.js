function showAuthor() {
    alert("Орлов Владимир Иванович группа Z0431");
}

var idTimeZone = 1;
function showTime(idZone = -1) {
    if (idZone != -1) idTimeZone = idZone;
    var datecur, hour, minute;
    var time = "";
    datecur = new Date(new Date().toLocaleString("en-US", { timeZone: "UTC" }));
    switch (idTimeZone) {
        case 0:
            datecur = addHours(datecur, -4);
            document.getElementsByTagName("h3")[2].innerText =
                "Время по Нью-Йорку";
            break;
        case 1:
            datecur = addHours(datecur, 3);
            document.getElementsByTagName("h3")[2].innerText =
                "Время по Москве";
            break;
        case 2:
            datecur = addHours(datecur, 8);
            document.getElementsByTagName("h3")[2].innerText =
                "Время по Пекину";
            break;
        default:
            datecur = addHours(datecur, 3);
    }
    hour = datecur.getHours();
    minute = datecur.getMinutes();
    sec = datecur.getSeconds();
    time = (hour < 10 ? "0" : "") + hour + ":";
    time += (minute < 10 ? "0" : "") + minute + ":";
    time += (sec < 10 ? "0" : "") + sec;
    tmr = document.getElementsByTagName("time");
    tmr[0].innerText = time;
    setTimeout(showTime, 1000);
}

function addHours(date, h) {
    date.setTime(date.getTime() + h * 60 * 60 * 1000);
    return date;
}

function addRow() {
    var tbodyRef = document.getElementsByTagName("tbody")[0];
    var newRow = tbodyRef.insertRow();
    newRow.className = "Added";
    for (let i = 0; i < document.getElementsByTagName("th").length; i++) {
        var newCell = newRow.insertCell();
        var newText = document.createTextNode(
            document.getElementsByTagName("input")[i].value
        );
        newCell.appendChild(newText);
    }
}
function eraseRow() {
    var row = document.getElementsByClassName("Added");
    for (let i = row.length - 1; i >= 0; i--) {
        row[i].remove();
    }
}

function changeColor() {
    var elem = document.getElementsByTagName("time")[0];
    elem.style.color = getRandomColor();
}

function changeSize() {
    var elem = document.getElementsByTagName("time")[0];
    elem.style.fontSize = Math.floor(Math.random() * (60 - 10 + 1) + 10) + "px";
}

function getRandomColor() {
    var letters = "0123456789ABCDEF";
    var color = "#";
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function addEvents() {
    var btn = document.getElementsByTagName("button")[5];
    var elem = document.getElementById("hrefTop");
    showTime();
    btn.addEventListener("click", changeColor);
    btn.addEventListener("click", changeSize);
}

function addElemList() {
    var dl = document.getElementsByTagName("dl")[0];
    var dt = document.createElement("dt");
    var strong = document.createElement("strong");
    dt.appendChild(strong);
    strong.innerText = document.getElementsByTagName("input")[0].value;
    
    var dd = document.createElement("dd");
    dd.innerText = document.getElementsByTagName("input")[1].value;
    dl.appendChild(dt);
    dl.appendChild(dd);
}

function eraseElemList(){
    var term = document.getElementsByTagName("input")[0].value;
    if(term == "")
        alert("Введите данные в строку термин, для удаления элемента списка");
    else{
        var delElem = document.getElementsByTagName('dt');
        for(let i=0;i<delElem.length;i++){
            if(delElem[i].innerText == term){
                delElem[i].remove();
                document.getElementsByTagName('dd')[i].remove();
                i=0;
            }
        }
    }
}

function formVal(form) {
    
    if(form.surname.value.length < 4 || form.surname.value.length > 30){
        alert("строка фамилии должна содержать от 4 до 30 символов");
        form.surname.focus();
        return false;
    }
    
    if(!form.surname.value.match(/^[a-zA-Zа-яА-Я]+$/i)){
        alert("Строка фамилии должна содержать только буквы.");
        form.surname.focus();
        return false;
    }     
    
    if(form.name.value.length < 4 || form.surname.value.length > 30){
        alert("строка имени должна содержать от 4 до 30 символов");
        form.surname.focus();
        return false;
    }
    
    if(!form.name.value.match(/^[a-zA-Zа-яА-Я]+$/i)){
        alert("Строка имени должна содержать только буквы.");
        form.surname.focus();
        return false;
    }  
    
    if(form.patron.value.length < 4 || form.surname.value.length > 30){
        alert("строка отчества должна содержать от 4 до 30 символов");
        form.surname.focus();
        return false;
    }
    
    if(!form.patron.value.match(/^[a-zA-Zа-яА-Я]+$/i)){
        alert("Строка отчества должна содержать только буквы.");
        form.surname.focus();
        return false;
    }  
    
    if ( form.group.selectedIndex == 0 )
        {
                alert ( "Пожалуйста, выберите Вашу группу." );
                return false;
        }
    if (form.question1[0].checked == false && form.question1[1].checked == false && form.question1[2].checked == false)
        {
                alert ( "Пожалуйста, выберите вариант ответа" );
                return false;
        }
    if (form.question2[0].checked == false && form.question2[1].checked == false && form.question2[2].checked == false && form.question2[3].checked == false){
        alert ( "Пожалуйста, выберите вариант ответа/ответов" );
        return false;
    }
    return true;
}

function addFormValid(form){
    if(form.typeCompany.value =="" || form.developer_name.value =="" || form.headquarter.value =="" || form.dateOfFoundation.value =="" || form.keyPeople.value =="" || form.audioEditor_Name.value =="" || form.licence.value =="" || form.Windows.value =="" || form.MacOS.value =="" || form.Linux.value ==""){
        alert("Не все поля заполнены");
        return false;
    }
    if(form.typeCompany.value.length  > 45 || form.developer_name.value.length  > 45 || form.headquarter.value.length  > 45 || form.dateOfFoundation.value.length  > 45 || form.keyPeople.value.length  > 45 || form.audioEditor_Name.value.length  > 45 || form.licence.value.length  > 45){
         alert("Значение поля превышает допустимый размер 45 символа");
        return false;
    }
    
    
    if(form.Windows.value.length  > 3){
         alert("Значение поля Windows превышает допустимый размер 3 символа");
        form.Windows.focus();
        return false;
    }
    if(form.MacOS.value.length > 3){
         alert("Значение поля MacOS превышает допустимый размер 3 символа");
        form.MacOS.focus();
        return false;
    }
    if(form.Linux.value.length  > 3){
         alert("Значение поля Linux превышает допустимый размер 3 символа");
        form.Linux.focus();
        return false;
    }
    return true;
}
