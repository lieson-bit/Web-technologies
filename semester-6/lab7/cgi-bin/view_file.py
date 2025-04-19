#!C:\Users\1\anaconda3\python.exe
# -*- coding: utf-8 -*-

import os
import codecs

# Enable UTF-8 output
import sys
sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())

# Define the file path
file_path = "result.txt"

# Print HTTP headers
print("Content-Type: text/html; charset=utf-8\r\n\r\n")

# Start HTML output
print("""
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сохраненные данные</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <a href="#" class="logo-container">
            <img src="../images/logo.png" alt="Logo Image" class="logo-image">
            <span class="logo-text">Промышленные роботы</span>
        </a> 
        <p>Сохраненные данные</p>
    </header>

    <nav align="center">
        <a href="../index.html">Главная</a>
        <a href="../second.html">Промышленный робот</a>
        <a href="../source.html">Использованные источники</a>
        <a href="#">ЛР3</a>
        <a href="../form.html">Анкета</a>
        <a href="#">Таблица из БД</a>
    </nav>

    <main>
        <h2>Сохраненные анкеты</h2>
        <table border="1">
            <tr>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Группа</th>
                <th>Предпочитаемый язык</th>
                <th>Используемые технологии</th>
                <th>Email</th>
            </tr>
""")

# Read and display file content
if os.path.exists(file_path):
    with open(file_path, "r", encoding="utf-8") as f:
        for line in f:
            data = line.strip().split("|")
            if len(data) == 7:  # Ensure correct format
                print("<tr><td>" + "</td><td>".join(data) + "</td></tr>")
else:
    print("<tr><td colspan='7'>Нет данных</td></tr>")

# End HTML
print("""
        </table>
    </main>

    <footer>
        <p>&copy; 2025 Команда "История робототехники"</p>
    </footer>
</body>
</html>
""")
