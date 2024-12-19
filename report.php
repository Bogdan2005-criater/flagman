<?php
// Включение соединения с базой данных
include 'db.php';

// Получение данных для отчёта
$clients = $pdo->query("SELECT * FROM Клиенты")->fetchAll(PDO::FETCH_ASSOC);
$products = $pdo->query("SELECT * FROM Товары")->fetchAll(PDO::FETCH_ASSOC);
$orders = $pdo->query("SELECT * FROM Заказы")->fetchAll(PDO::FETCH_ASSOC);

// Функция для отображения данных в таблице
function renderTable($data, $columns) {
    echo "<table class='table table-striped mt-3'><thead class='table-dark'><tr>";
    foreach ($columns as $col) {
        echo "<th>{$col}</th>";
    }
    echo "</tr></thead><tbody>";
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>{$value}</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отчёт о выполненной работе</title>
    <link rel="stylesheet" href="styles/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
        <h1 class="text-center">Отчёт о выполненной работе</h1>

    <h3><a href="#1">1.ER-диаграмму базы данных</a></h3>
    <h3><a href="#2">2.Скрипты создания и наполнения базы данных.</a></h3>
    <h3><a href="#3">3.Описание настроек прав доступа.</a></h3>
    <h3><a href="#4">4.Скрипты для резервного копирования.</a></h3>
    <h3><a href="#5">5.Примеры защищенных SQL-запросов.</a></h3>
    <h3><a href="#6">6.Скриншоты создания и работы базы данных</a></h3>
=    

    <section class="mt-5" id="1">
        <h2>1. ER-диаграмма базы данных <a href="https://github.com/Bogdan2005-criater/flagman/blob/main/Untitled.pdf">ПДФ файл в гитхабе</a></h2>
        <img src="Снимок экрана от 2024-12-19 22-06-57.png" alt="ER-диаграмма базы данных" class="img-fluid mt-3">
    </section>

    <section class="mt-5" id="2">
        <h2>2. Скрипты создания и наполнения базы данных</h2>
        <pre class="mt-3">
CREATE TABLE Клиенты (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ФИО VARCHAR(255) NOT NULL,
    Телефон VARCHAR(15),
    Email VARCHAR(255) UNIQUE NOT NULL,
    Адрес TEXT
);

CREATE TABLE Товары (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Название VARCHAR(255) NOT NULL,
    Описание TEXT,
    Цена DECIMAL(10, 2) NOT NULL,
    КоличествоНаСкладе INT NOT NULL
);

-- (Остальной код, описан в https://github.com/Bogdan2005-criater/flagman/blob/main/setup_database.sh)
        </pre>
        <h1><a href="https://github.com/Bogdan2005-criater/flagman/blob/main/setup_database.sh">setup_database.sh</a></h1>
    </section>

    <section class="mt-5" id="3">
        <h2>3. Описание настроек прав доступа</h2>
        <p>
            В базе данных настроены три роли:
            <ul>
                <li><strong>Администратор:</strong> Полный доступ ко всем таблицам и действиям.</li>
                <li><strong>Менеджер:</strong> Доступ только к чтению заказов и обновлению статусов.</li>
                <li><strong>Клиент:</strong> Доступ только к своим заказам.</li>
            </ul>
        </p>
    </section>

    <section class="mt-5" id="4">
        <h2>4. Скрипты для резервного копирования</h2>
        <pre class="mt-3">
#!/bin/bash
mysqldump -u root -p InternetShop > backup_$(date +%F).sql
        </pre>
    </section>

    <section class="mt-5" id="5">
        <h2>5. Примеры защищенных SQL-запросов</h2>
        <p>Для предотвращения SQL-инъекций используются подготовленные запросы:</p>
        <pre class="mt-3">
$stmt = $pdo->prepare("SELECT * FROM Клиенты WHERE ID = :id");
$stmt->execute([':id' => $client_id]);
$result = $stmt->fetchAll();
        </pre>
    </section>

    <section class="mt-5" >
        <h2>6. Скриншоты работы с базой данных</h2>
        <h3>Таблица клиентов</h3>
        <?php renderTable($clients, ['ID', 'ФИО', 'Телефон', 'Email', 'Адрес']); ?>
        
        <h3>Таблица товаров</h3>
        <?php renderTable($products, ['ID', 'Название', 'Описание', 'Цена', 'КоличествоНаСкладе']); ?>
        
        <h3>Таблица заказов</h3>
        <?php renderTable($orders, ['ID', 'ID Клиента', 'Дата Заказа', 'Статус']); ?>
    </section>
    
    <section class="mt-5" id="6">
        <h3>Скрины работы</h3>
        <pre class="mt-3">
        <img src="Снимок экрана от 2024-12-19 21-53-03.png" alt="ER-диаграмма базы данных" class="img-fluid mt-3">

        </pre>
    </section>
    
    <a href="index.php" class="btn btn-secondary mt-3">Назад</a>
</div>
</body>
</html>
