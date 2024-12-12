<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактор тексту</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        textarea {
            width: 100%;
            height: 300px;
            margin-bottom: 10px;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1 style="align-content: center;">Редактор тексту</h1>

    <?php
    $filename = 'kniga.txt';

    // Якщо файл не існує, створюємо його
    if (!file_exists($filename)) {
        file_put_contents($filename, '');
    }

    // Збереження змін у файлі
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newContent = $_POST['content'] ?? '';
        file_put_contents($filename, $newContent);
        echo '<p style="color: green;">Файл успішно оновлено!</p>';
    }

    // Читання вмісту файлу
    $content = file_get_contents($filename);
    ?>

    <form method="post">
        <textarea name="content" required><?= htmlspecialchars($content) ?></textarea>
        <br>
        <button type="submit">Зберегти</button>
    </form>
</body>
</html>
