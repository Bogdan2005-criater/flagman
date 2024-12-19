DB_NAME="InternetShop"
DB_USER="root"
DB_PASS=""
DB_HOST="localhost"

echo "=== Настройка базы данных для проекта ==="

mysql -u $DB_USER -p$DB_PASS -e "
CREATE DATABASE IF NOT EXISTS $DB_NAME;
USE $DB_NAME;

CREATE TABLE IF NOT EXISTS Клиенты (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ФИО VARCHAR(255) NOT NULL,
    Телефон VARCHAR(15),
    Email VARCHAR(255) UNIQUE NOT NULL,
    Адрес TEXT
);

CREATE TABLE IF NOT EXISTS Товары (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Название VARCHAR(255) NOT NULL,
    Описание TEXT,
    Цена DECIMAL(10, 2) NOT NULL,
    КоличествоНаСкладе INT NOT NULL
);

CREATE TABLE IF NOT EXISTS Заказы (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_Клиента INT NOT NULL,
    ДатаЗаказа DATETIME DEFAULT CURRENT_TIMESTAMP,
    Статус VARCHAR(50) DEFAULT 'Ожидает',
    FOREIGN KEY (ID_Клиента) REFERENCES Клиенты(ID)
);

CREATE TABLE IF NOT EXISTS СтрокиЗаказов (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_Заказа INT NOT NULL,
    ID_Товара INT NOT NULL,
    Количество INT NOT NULL,
    Сумма DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (ID_Заказа) REFERENCES Заказы(ID),
    FOREIGN KEY (ID_Товара) REFERENCES Товары(ID)
);

INSERT IGNORE INTO Клиенты (ФИО, Телефон, Email, Адрес) VALUES
    ('Иван Иванов', '1234567890', 'ivanov@example.com', 'Москва, ул. Пушкина, д.1'),
    ('Петр Петров', '0987654321', 'petrov@example.com', 'Санкт-Петербург, ул. Ленина, д.2');

INSERT IGNORE INTO Товары (Название, Описание, Цена, КоличествоНаСкладе) VALUES
    ('Ноутбук', 'Высокопроизводительный ноутбук', 50000, 10),
    ('Смартфон', 'Современный смартфон', 30000, 15),
    ('Монитор', 'Игровой монитор', 15000, 20);

INSERT IGNORE INTO Заказы (ID_Клиента, Статус) VALUES
    (1, 'Обработан'),
    (2, 'Доставлен');

INSERT IGNORE INTO СтрокиЗаказов (ID_Заказа, ID_Товара, Количество, Сумма) VALUES
    (1, 1, 2, 100000),
    (2, 2, 1, 30000);

CREATE TABLE IF NOT EXISTS Логи (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Таблица VARCHAR(50),
    Действие VARCHAR(50),
    Дата DATETIME DEFAULT CURRENT_TIMESTAMP
);

DELIMITER //
CREATE TRIGGER IF NOT EXISTS Лог_Добавление_Клиентов
AFTER INSERT ON Клиенты
FOR EACH ROW
BEGIN
    INSERT INTO Логи (Таблица, Действие) VALUES ('Клиенты', 'Добавление');
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER IF NOT EXISTS Проверка_Остатков
BEFORE INSERT ON СтрокиЗаказов
FOR EACH ROW
BEGIN
    DECLARE ТоварыНаСкладе INT;
    SELECT КоличествоНаСкладе INTO ТоварыНаСкладе FROM Товары WHERE ID = NEW.ID_Товара;
    IF NEW.Количество > ТоварыНаСкладе THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Недостаточно товара на складе';
    END IF;
END;
//
DELIMITER ;

SHOW TABLES;
"

echo "=== Настройка завершена ==="
