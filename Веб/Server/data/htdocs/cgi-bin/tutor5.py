#!/usr/bin/python
#вывод в таблицу
import cgi, sys
form = cgi.FieldStorage() # извлечь данные из формы
print("Content-type: text/html\r\n\r\n") # плюс пустая строка
print("""
    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0" />
        <title>Анкета</title>
        <link rel="stylesheet" href="\\css\\styles.css">
        <link rel="icon" href="\\images\\icon.ico" type="image/x-icon">
        <script src="\\js\\events.js"></script>
    </head>
    <body>
        <header class="header">
            <h1>Форма звука</h1>
            <img src="\\images\\logo.png" width="50" height="50" alt="logo" />
            <p>Анкета</p>
        </header>
        <nav>
            <!-- навигация по сайту -->
            <ul class="ulNav">
                <li><a href="\\index.html">Главная</a></li>
                <li><a href="\\second.html">Воспроизведение и аудиоредакторы</a></li>
                <li><a href="\\source.html">Использованные источники</a>
                    <ul class="dropdown">
                    <li><a href="https://habr.com/ru/companies/leader-id/articles/531672/">Принципы обработки студийного звука и легенды динамической компрессии</a></li>
                    <li><a href="https://dic.academic.ru/dic.nsf/ruwiki/196715">Аудиоредакторы</a></li>
                    <li><a href="https://htmlbook.ru/html">Справочник по HTML</a></li>
                </ul>
                </li>                
                <li><a href="\\js1.html">лр3</a></li>
                <li><a href="\\form.html" class="active">анкета</a></li>
                <li><a href="#">таблица из БД</a></li>
            </ul>        
        </nav>
        <hr />
        <main class="main">
""")
html1 = """
<H3>Опрос по теме</H3>
<div class="FormConteiner">
<style>
.SubmitTable{
    width:max-content;
    border-collapse: collapse;
    text-align: center;
    border: 1mm solid black;
    background:white;
    margin:20px;
    }
.SubmitTable td{
padding:10px;
}
.TableHead{
    background: #a7cbf2;
}
</style>
<table border =1 class="SubmitTable"> <tr  class="TableHead">
"""
print (html1)
# печать заголовка таблицы
ll = ['Фамилия','Имя','Отчество','Группа','Какая характеристика определяет высоту воспринимаемого звука?', 'Что из представленного является аудиоредактором?']
for head in ll:
    ss = '<td>'+head+'</td>'
    print (ss)
print ('</tr> <tr>')

data = ['','','','','','']
str = "";
i=0
result = ""
for field in ('surname', 'name', 'patron', 'group', 'question1','question2'):
    if not field in form:
        data[i] = '(unknown)'
    else:
        if not isinstance(form[field], list):
            data[i] = form[field].value
        else:
            values = [x.value for x in form[field]]
            data[i] = ' and '.join(values)
    i+=1
for el in data:
    print ('<td> %s </td>'% el)
    result +=el + "|"
    
with open("result.txt", "a") as file:
        file.write(result + "\n")  

print ('</tr> </table> </div>')

print('<dl>')
i=0
for field in ('surname', 'name', 'patron', 'group', 'question1','question2'):
    if not field in form:
        str = '(unknown)'
    else:
        if not isinstance(form[field], list):
            str = form[field].value
        else:
            str = [x.value for x in form[field]]
            str = ' and '.join(values)
    print("<dt><strong>"+ll[i]+ "</strong></dt>")
    print("<dd>"+str+"</dd>")
    i+=1
print('</dl>')


print("""
</main>
        
        <footer class="footer">
            <h2>Контакты</h2>
            <p >С <a onclick="showAuthor()" id="author">автором</a> сайта можно связаться:</p>
            <address>
                По эл. почте:
                <a href="mailto:vladimir@mail.ru">vladimir@mail.ru</a><br />
                По телефону: <a href="tel:+78005553535">+7(800)555-35-35</a>
            </address>
            <p>
                Данный сайт создан
                <time datetime="2023-09-23">23 сентября 2023 года.</time>
            </p>
        </footer>
    </body>
</html>
""")
