<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Клиенты</title>
    <link rel="stylesheet" href="styles/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Клиенты</h1>
    <table class="table table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Адрес</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $pdo->query('SELECT * FROM Клиенты');
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['ФИО']}</td>
                    <td>{$row['Телефон']}</td>
                    <td>{$row['Email']}</td>
                    <td>{$row['Адрес']}</td>
                  </tr>";
        }
        ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary mt-3">Назад</a>
</div>
</body>
</html>
