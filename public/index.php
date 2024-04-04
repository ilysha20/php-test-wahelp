<?php

$servername = "database";
$username = "mysql";
$password = "mysql";
$dbname = "test";
$port = 3306;

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$csv_file = "../storage/mock_users.csv";

$num_records = 0;

// открываем фаил mock_users.csv
if (($handle = fopen($csv_file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $number = $data[0];
        $name = $data[1];

        // SQL запрос для добавления данных в базу данных
        $sql = "INSERT INTO users (number, name) VALUES ('$number', '$name')";

        if ($conn->query($sql) === TRUE) {
            $num_records++;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    fclose($handle);
} else {
    echo "Error opening file";
}

$conn->close();

echo "<br> Импорт из файла CSV выполнен успешно. Всего добавлено записей: $num_records";

$conn = new mysqli($servername, $username, $password, $dbname, $port);

$mailing_title = "Вас привествует компания ...";
$mailing_content = "Мы предлогаем для вас ...";

// Заносим в базу данных mailings рассылку
$sql_create_mailing = "INSERT INTO mailings (title, content) VALUES ('$mailing_title', '$mailing_content')";
$conn->query($sql_create_mailing);
$mailing_id = $conn->insert_id;

$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);

while ($row = $result_users->fetch_assoc()) {
    $user_id = $row['id'];

    // Проверяем, чтобы не отправлять сообщения повторно уже отправленным пользователям
    $sql_check_sent = "SELECT id FROM sent_messages WHERE mailing_id = $mailing_id AND user_id = $user_id";
    $result_check_sent = $conn->query($sql_check_sent);

    if ($result_check_sent->num_rows == 0) {
        // Добавляем пользователя в очередь рассылки
        $sql_add_to_queue = "INSERT INTO sent_messages (mailing_id, user_id) VALUES ($mailing_id, $user_id)";
        $conn->query($sql_add_to_queue);
    }
}

echo "<br> Пользователи добавлены в очередь рассылки.";

$conn->close();
