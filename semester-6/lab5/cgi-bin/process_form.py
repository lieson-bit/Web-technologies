#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import cgi       # For handling form data
import cgitb     # For error reporting
import codecs    # For encoding handling
import os        # For file system operations
import html

cgitb.enable()  # Enable error reporting

# Ensure stdout uses UTF-8
import sys
sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())

# Create directories if they don't exist
if not os.path.exists("uploads"):
    os.makedirs("uploads")
if not os.path.exists("profile_pics"):
    os.makedirs("profile_pics")

# Get form data
form = cgi.FieldStorage()

# Extract values and decode to UTF-8
def get_utf8_value(field_name, default="(unknown)"):
    value = form.getvalue(field_name, default)
    return value.encode("latin1").decode("utf-8") if isinstance(value, str) else default

# Extract values
surname = get_utf8_value('surname')
name = get_utf8_value('name')
patron = get_utf8_value('patron')
group = get_utf8_value('group')
question1 = get_utf8_value('question1')
question2 = form.getlist('question2')
email = get_utf8_value('email')

# Convert checkboxes list to UTF-8
question2 = [q.encode("latin1").decode("utf-8") for q in question2]

# Handle file upload
uploaded_filename = "(no file uploaded)"
file_content = ""
if "file" in form:
    uploaded_file = form["file"]
    if uploaded_file.filename:
        file_path = os.path.join("uploads", uploaded_file.filename)
        try:
            with open(file_path, "wb") as f:
                f.write(uploaded_file.file.read())
            uploaded_filename = uploaded_file.filename
            # Read file content for display
            try:
                with open(file_path, "r", encoding="utf-8") as f:
                    file_content = f.read()
            except:
                file_content = "[Binary file - content not displayable]"
        except Exception as e:
            uploaded_filename = f"Error saving file: {e}"

# Handle profile picture upload
profile_pic = ""
if "profile_pic" in form:
    pic_file = form["profile_pic"]
    if pic_file.filename:
        pic_path = os.path.join("profile_pics", pic_file.filename)
        try:
            with open(pic_path, "wb") as f:
                f.write(pic_file.file.read())
            profile_pic = pic_file.filename
        except Exception as e:
            profile_pic = f"Error saving profile picture: {e}"

# Save data to a UTF-8 file
try:
    with open("result.txt", "a", encoding="utf-8") as f:
        f.write(f"{surname}|{name}|{patron}|{group}|{question1}|{','.join(question2)}|{email}\n")
except Exception as e:
    print("Content-Type: text/plain\r\n\r\n")
    print(f"Error saving data: {e}")
    exit()

# Prepare profile picture HTML
if profile_pic and not profile_pic.startswith("Error"):
    profile_html = f'<img src="../profile_pics/{html.escape(profile_pic)}" class="profile-pic" alt="Profile Picture">'
else:
    profile_html = '<div class="profile-pic" style="background:#eee; display:flex; align-items:center; justify-content:center;">No Image</div>'

# Prepare file content HTML
if uploaded_filename != "(no file uploaded)":
    escaped_filename = html.escape(uploaded_filename)
    file_link_html = f'<a href="#" onclick="toggleFileContent(\'{escaped_filename}\'); return false;">{uploaded_filename}</a>'
    file_content_html = f"""
    <div id="file-content-{escaped_filename}" class="file-content">
        <pre>{html.escape(file_content)}</pre>
        <button onclick="hideFileContent('{escaped_filename}')" class="toggle-btn">Hide</button>
    </div>
    """
else:
    file_link_html = uploaded_filename
    file_content_html = ""

# Generate response
print("Content-Type: text/html; charset=utf-8\r\n\r\n")
print(f"""<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат анкеты</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        .profile-container {{
            display: flex;
            gap: 20px;
            margin: 20px 0;
            align-items: center;
        }}
        .profile-pic {{
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4CAF50;
        }}
        .profile-info {{
            flex-grow: 1;
        }}
        .file-content {{
            display: none;
            background: #f8f8f8;
            padding: 10px;
            border: 1px solid #ddd;
            margin-top: 10px;
            border-radius: 5px;
        }}
        .toggle-btn {{
            margin-left: 10px;
            padding: 2px 5px;
            font-size: 0.8em;
        }}
        .file-display-section {{
            margin-top: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 5px;
        }}
    </style>
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
        <!-- Profile Section -->
        <div class="profile-container">
            <div>
                {profile_html}
            </div>
            <div class="profile-info">
                <h2>{name} {surname}</h2>
                <p>Группа: {group}</p>
                <p>Email: {email}</p>
            </div>
        </div>

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
                <td>{file_link_html}</td>
            </tr>
        </table>
        
        <p>{name[0]}. {patron[0]} {surname} - студент, предпочитает {question1} и использует {', '.join(question2)}.</p>
        
        <!-- File content display section -->
        {file_content_html if uploaded_filename != "(no file uploaded)" else ""}
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

    <script>
        function toggleFileContent(filename) {{
            const contentDiv = document.getElementById(`file-content-${{encodeURIComponent(filename)}}`);
            if (contentDiv.style.display === 'block') {{
                contentDiv.style.display = 'none';
            }} else {{
                contentDiv.style.display = 'block';
            }}
        }}
        
        function hideFileContent(filename) {{
            document.getElementById(`file-content-${{encodeURIComponent(filename)}}`).style.display = 'none';
        }}
    </script>
</body>
</html>""")