<?php
session_start();
require_once "connect.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin.php');
    exit;
}

if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die("Nieprawidlowy token CSRF.");
}

$login = trim($_POST['login'] ?? '');
$haslo = $_POST['haslo'] ?? '';

if ($login === '' || $haslo === '' || !is_string($login) || !is_string($haslo)) {
    die("Login i haslo sa wymagane.");
}

$stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE login = :login LIMIT 1");
$stmt->execute([':login' => $login]);
$user = $stmt->fetch();

if (!$user) {
    echo "Niepoprawny uzytkownik lub haslo!";
    exit;
}

$passwordValid = false;

if (password_verify($haslo, $user['pass'])) {
    $passwordValid = true;
} elseif ($user['pass'] === $haslo) {
    $passwordValid = true;
    $newHash = password_hash($haslo, PASSWORD_BCRYPT);
    $updateStmt = $pdo->prepare("UPDATE uzytkownicy SET pass = :hash WHERE id = :id");
    $updateStmt->execute([':hash' => $newHash, ':id' => $user['id']]);
}

if (!$passwordValid) {
    echo "Niepoprawny uzytkownik lub haslo!";
    exit;
}

session_regenerate_id(true);
$_SESSION['zalogowano'] = true;
$_SESSION['zalogowany_user'] = $user['login'];
$_SESSION['rola'] = $user['role'] ?? '';
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

header('Location: admin.php');
exit;
