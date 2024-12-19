<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Товары</title>
    <link rel="stylesheet" href="styles/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Товары</h1>
    <table class="table table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Цена</th>
                <th>Количество на складе</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $pdo->query('SELECT * FROM Товары');
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['Название']}</td>
                    <td>{$row['Описание']}</td>
                    <td>{$row['Цена']}</td>
                    <td>{$row['КоличествоНаСкладе']}</td>
                  </tr>";
        }
        ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary mt-3">Назад</a>
</div>
</body>
</html>
