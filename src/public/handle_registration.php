<?php
$name = $_POST["name"];
$email = trim($_POST["email"]);
$password = trim($_POST["psw"]);
$passwordRep = $_POST["psw-repeat"];

if (empty($name) || empty($email) || empty($password) || empty($passwordRep)) {
  die("Все поля должны быть заполнены.");
}

if (strlen($name) < 3 || strlen($name) > 30) {
    die("Имя должно содержать от 3 до 30 символов.");
}
if (strlen($password) < 6) {
    die("Пароль должен содержать минимум 6 символов.");
}
if ($password !== $passwordRep) {
    die("Пароли не совпадают.");
}
if (strpos($email, '@') === false) {
    die("Адрес электронной почты должен содержать символ '@'.");
}

$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name,:email,:password)");
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);


$stmt= $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
print_r($stmt->fetch());