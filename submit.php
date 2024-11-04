<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_REQUEST['name'])) {

    // Отримання даних з форми
    $name = htmlspecialchars($_REQUEST['name']);
    $email = htmlspecialchars($_REQUEST['email']);
    $style = htmlspecialchars($_REQUEST['style']);
    $years = htmlspecialchars($_REQUEST['years']);
    $experience = htmlspecialchars($_REQUEST['experience']);

    // Формування поточної дати і часу для імені файлів
    $timestamp = date("Y-m-d_H-i-s");

    // Абсолютний шлях до папки
    $dir = $_SERVER['DOCUMENT_ROOT'] . "/lab7/survey/";
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    // Назви файлів для збереження результатів (txt та json)
    $filename_txt = $dir . "survey_" . $timestamp . ".txt";
    $filename_json = $dir . "survey_" . $timestamp . ".json";

    // Створення контенту для текстового файлу
    $content_txt = "Ім'я: $name\nEmail: $email\nУлюблений стиль одягу: $style\nСкільки років як клієнт: $years\nОпис досвіду: $experience\n";
    file_put_contents($filename_txt, $content_txt);

    // Створення контенту для json-файлу
    $content_json = [
        'name' => $name,
        'email' => $email,
        'style' => $style,
        'years' => $years,
        'experience' => $experience,
    ];
    file_put_contents($filename_json, json_encode($content_json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    echo json_encode([
        "status" => "success",
        "message" => "Дякуємо за ваш відгук, $name!",
        "timestamp" => date("Y-m-d H:i:s")
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Будь ласка, заповніть форму."]);
}

?>




