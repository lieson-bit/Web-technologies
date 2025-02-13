<?php 
echo <<<END
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta
            charset="UTF-8"
            name="viewport"
            content="width=device-width, initial-scale=1.0" />
        <title>Таблица из БД</title>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="icon" href="images/icon.ico" type="image/x-icon">
        <script type="text/javascript" src="js/events.js"></script>
        <style>       
    .dbTable{
        width:max-content;
        border-collapse: collapse;
        text-align: center;
        border: 1mm solid black;
        background:white;
        margin:20px;
    }

    .dbTable td{
        position:relative;
        min-height:40px;
        height:max-content;
        width:max-content;
        padding:0px;
        margin:0px;
    }

    .dbTable th{
        width:max-content;
        padding:10px;
        background: #a7cbf2;
    }
    .trAddRow{
     height:20px;
    }
    .InputSubmit{
    height:20px;
    position:absolute;
    width:100%;
    height:100%;
    left:0px;
    top:0px;
    padding:0px;
    margin: 0px;
    background:#00ABE4;
    }
    .addRowInput{
    height:20px;
    position:absolute;
    width:99%;
    height:95%;
    left:0px;
    top:0px;
    padding:0px;
    margin: 0px;
    }
    .deleteButton{
    height:20px;
    position:absolute;
    width:100%;
    height:100%;
    left:0px;
    top:0px;
    padding:0px;
    margin: 0px;
    background:#00ABE4;
    background:#CD5C5C;
    
    }
        </style>
    </head>
    <body>
        <header class="header">
            <h1>Форма звука</h1>
            <img src="images/logo.png" width="50" height="50" alt="logo" />
            <p>Таблица из БД</p>
        </header>
        <nav>
            <!-- навигация по сайту -->
            <ul class="ulNav">
                <li><a href="index.html">Главная</a></li>
                <li><a href="second.html">Воспроизведение и аудиоредакторы</a></li>
                <li><a href="source.html">Использованные источники</a>
                    <ul class="dropdown">
                    <li><a href="https://habr.com/ru/companies/leader-id/articles/531672/">Принципы обработки студийного звука и легенды динамической компрессии</a></li>
                    <li><a href="https://dic.academic.ru/dic.nsf/ruwiki/196715">Аудиоредакторы</a></li>
                    <li><a href="https://htmlbook.ru/html">Справочник по HTML</a></li>
                </ul>
                </li>                
                <li><a href="js1.html">лр3</a></li>
                <li><a href="form.html">анкета</a></li>
                <li><a href="db.php" class="active">таблица из БД</a></li>
            </ul>        
        </nav>
        <main class="main">
END;

  
echo <<<END
    <div class="FormConteiner">
    <table border=1 class="dbTable">
    <tr>
    <th colspan=5>Создатели</th>
    <th colspan=5>Аудиоредактор</th>
    <th rowspan=2>Действие</th>
    </tr>
    <tr>
    <th>Тип компании</th>
    <th>Название</th>
    <th>Штаб-квартира</th>
    <th>Дата основания</th>
    <th>Ключевые люди</th>
    <th>Название</th>
    <th>Лицензия</th>
    <th>Windows</th>
    <th>MacOS</th>
    <th>Linux</th>
    </tr>
END;

            $connection = new mysqli("localhost", "root", "Orlov476qwer!", "web");
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
            $sql = "select * from audioeditor
right join developer on audioeditor.id_developer = developer.id_developer;";
            $result = $connection->query($sql);

            if (!$result) {
                die("Invalid query: " . $connection->error);
            } 

            while($row = $result->fetch_assoc()) {
               printf("
                    <form method='POST' action='eraseRow.php'>
                    <input type='hidden' name='idRow' value='%s'>
                    <tr>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td ><input class='deleteButton' type='submit' value='удалить'></td>
                </tr>                </form>",$row["id_audioEditor"],$row["typeCompany"],$row["developer_name"],$row["headquarter"],$row["dateOfFoundation"],$row["keyPeople"],$row["audioEditor_Name"],$row["licence"],$row["Windows"],$row["MacOS"],$row["Linux"]);
            }
echo <<<END
<form method="POST" action="addRow.php"  onsubmit="return addFormValid(this);">
<tr class="trAddRow">
<td><input class="addRowInput" type="text" name="typeCompany" id="typeCompany"/></td>
<td><input class="addRowInput"  type="text" name="developer_name" id="developer_name"/></td>
<td><input class="addRowInput"  type="text" name="headquarter" id="headquarter"/></td>
<td><input class="addRowInput"  type="text" name="dateOfFoundation" id="dataOfFoundation"/></td>
<td><input class="addRowInput"  type="text" name="keyPeople" id="keyPeople"/></td>
<td><input class="addRowInput"  type="text" name="audioEditor_Name" id="audioEditor_Name"/></td>
<td><input class="addRowInput"  type="text" name="licence" id="licence"/></td>
<td><input class="addRowInput"  type="text" name="Windows" id="Windows"/></td>
<td><input class="addRowInput"  type="text" name="MacOS" id="MacOS"/></td>
<td><input class="addRowInput"  type="text" name="Linux" id="Linux"/></td>
<td><input class="InputSubmit"  type="submit" value="добавить"></td>
</tr>
</form>
END;

echo "</table>
</div>
";



echo <<<END
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
END;
?>