<?php
session_start();
require_once "connect.php";

if (empty($_SESSION['zalogowano'])) {
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin.php');
    exit;
}

if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die("Nieprawidlowy token CSRF.");
}

$tytul_posta = trim($_POST['tytul'] ?? '');
$tresc_posta = trim($_POST['tresc'] ?? '');
$autor_posta = trim($_POST['autor'] ?? '');
$data_publikacji = trim($_POST['data_publikacji'] ?? '');

if ($tytul_posta === '' || $tresc_posta === '' || $autor_posta === '' || $data_publikacji === '') {
    die("Wszystkie pola sa wymagane.");
}

$nazwa_pliku = null;

if (isset($_FILES['plik']) && $_FILES['plik']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['plik']['error'] !== UPLOAD_ERR_OK) {
        die("Wystapil blad przy przesylaniu pliku.");
    }

    $tmp_name = $_FILES['plik']['tmp_name'];
    $original_name = basename($_FILES['plik']['name']);
    $file_size = $_FILES['plik']['size'];

    $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    if (!in_array($extension, $allowed_ext)) {
        die("Nie mozesz zalaczyc plikow tego typu!");
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $tmp_name);
    finfo_close($finfo);

    $allowed_mime = ['image/jpeg', 'image/png'];
    if (!in_array($mime, $allowed_mime)) {
        die("Plik nie jest prawidlowym obrazem.");
    }

    if ($file_size >= 500000) {
        die("Twoj plik jest za duzy!");
    }

    $random_name = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = 'uploads/' . $random_name;

    if (!move_uploaded_file($tmp_name, $destination)) {
        die("Wystapil blad przy zapisie pliku.");
    }

    $nazwa_pliku = $random_name;
}

$sql = "INSERT INTO posty (tytul, zawartosc, zdjecie, autor, data_publikacji)
        VALUES (:tytul, :zawartosc, :zdjecie, :autor, :data)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':tytul'      => $tytul_posta,
    ':zawartosc'  => $tresc_posta,
    ':zdjecie'    => $nazwa_pliku,
    ':autor'      => $autor_posta,
    ':data'       => $data_publikacji,
]);

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATARI Muzeum - Dodano post</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <h2>ATARI Muzeum</h2>
    </header>
    <content>
        <nav></nav>
        <main>
            <p>Pomyslnie dodano posta!</p>
            <p><a href="admin.php">Powrot do panelu administratora</a></p>
        </main>
        <aside></aside>
    </content>
</body>
</html>
