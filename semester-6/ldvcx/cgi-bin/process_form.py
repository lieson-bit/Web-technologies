#!/usr/bin/env python3
#!C:\Users\1\anaconda3\python.exe
# -*- coding: utf-8 -*-

import cgi
import cgitb
import codecs
import os

cgitb.enable()  # Enable error reporting

# Ensure stdout uses UTF-8
import sys
sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())

# Create the 'uploads' directory if it doesn't exist
if not os.path.exists("uploads"):
    os.makedirs("uploads")

# Get form data
form = cgi.FieldStorage()

# Extract values and decode to UTF-8
def get_utf8_value(field_name, default="(unknown)"):
    value = form.getvalue(field_name, default)
    return value.encode("latin1").decode("utf-8") if isinstance(value, str) else default

# Extract values
surname = form.getvalue('surname', '(unknown)').encode("latin1").decode("utf-8")
name = form.getvalue('name', '(unknown)').encode("latin1").decode("utf-8")
patron = form.getvalue('patron', '(unknown)').encode("latin1").decode("utf-8")
group = form.getvalue('group', '(unknown)').encode("latin1").decode("utf-8")
question1 = form.getvalue('question1', '(unknown)').encode("latin1").decode("utf-8")
question2 = form.getlist('question2')
email = form.getvalue('email', '(unknown)').encode("latin1").decode("utf-8")

# Convert checkboxes list to UTF-8
question2 = [q.encode("latin1").decode("utf-8") for q in question2]

# Handle file upload
uploaded_filename = "(no file uploaded)"  # Default if no file is uploaded


if "file" in form:
    uploaded_file = form["file"]
    if uploaded_file.filename:
        file_path = f"uploads/{uploaded_file.filename}"  # Save to 'uploads/' directory
        try:
            with open(file_path, "wb") as f:
                f.write(uploaded_file.file.read())
            uploaded_filename = uploaded_file.filename  # Store filename for display
        except Exception as e:
            uploaded_filename = f"Error saving file: {e}"

# Save data to a UTF-8 file
try:
    with open("result.txt", "a", encoding="utf-8") as f:
        f.write(f"{surname}|{name}|{patron}|{group}|{question1}|{','.join(question2)}|{email}\n")
except Exception as e:
    print("Content-Type: text/plain\r\n\r\n")
    print(f"Error saving data: {e}")
    exit()

# Generate response
print("Content-Type: text/html; charset=utf-8\r\n\r\n")
print(f"""
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат анкеты</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

    <!-- Шапка сайта -->
    <header>
        <a href="#" class="logo-container">
            <img src="../images/logo.png" alt="Logo Image" class="logo-image">
            <span class="logo-text">Промышленные роботы</span>
        </a> 
        <p>Результат анкеты</p>
    </header>

    <!-- Горизонтальная линия для разделения контента -->
    
    <!-- Навигация -->
    <nav align="center">
        <a href="../index.html">Главная</a>
        <a href="../second.html">Промышленный робот</a>
        <a href="../source.html">Использованные источники</a>
        <a href="#">ЛР3</a>
        <a href="../form.html">Анкета</a>
        <a href="#">Таблица из БД</a>
    </nav>

    <main>
        <h2>Ваши данные:</h2>
        <table border="1">
            <tr>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Группа</th>
                <th>Предпочитаемый язык</th>
                <th>Используемые технологии</th>
                <th>Email</th>
                <th>Загруженный файл</th>
            </tr>
            <tr>
                <td>{surname}</td>
                <td>{name}</td>
                <td>{patron}</td>
                <td>{group}</td>
                <td>{question1}</td>
                <td>{', '.join(question2)}</td>
                <td>{email}</td>
                <td>{uploaded_filename}
            </tr>
        </table>
        <p>{name[0]}. {patron[0]} {surname} - студент, предпочитает {question1} и использует {', '.join(question2)}.</p>
    </main>

    <footer>
        <table width="100%" border="0">
            <tr>
                <td>
                    <address>
                        <h2>Контакты</h2>
                        <address>
                            По эл. почте: <a href="mailto:lieson.mwale22.ru">{email}</a><br />
                        </address>
                        <p>Данный сайт создан 14 февраля 2025 года</p>
                    </address>
                </td>
            </tr>
            <tr>
                <td>&copy; 2025 Команда "Анкета робототехники"</td>
            </tr>
        </table>
    </footer>

</body>
<script src="script.js" defer></script>
</html>
""")
