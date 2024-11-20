<?php

session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: /login');
}

$products = [];
$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
$stmt = $pdo->query("SELECT * FROM products");

$stmt->execute();
$products = $stmt->fetchAll();

if (empty($products)) {
    echo "Нет товаров в каталоге";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Интернет-магазин Star Wars</title>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Star Wars: Магазин товаров</h1>
</header>
<main>
    <div class="catalog">
        <?php foreach ($products as $product): ?>
            <div class="card">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['productname']; ?>">
                <h2><?php echo $product['description']; ?></h2>
                <p>Цена: <?php echo $product['price']; ?> рублей.</p>
                <button>Купить</button>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>

<style>
    body {
        background-image: url('<?php echo 'image/dartoboi.jpg'; ?>');
        margin: 0;
        font-family: 'Arial', sans-serif;
        background-color: rgba(0, 0, 0, 0.1);
        color: rgb(255, 221, 0);
    }

    header {
        text-align: center;
        padding: 20px;
        background-color: #222;
    }

    h1 {
        font-family: 'Alfa Slab One', cursive;
        font-size: 36px;
    }

    .catalog {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px; /* Расстояние между карточками */
        padding: 20px;
    }

    .card {
        background-color: rgba(255, 255, 0, 0.17);
        border: 2px solid gold;
        border-radius: 10px;
        width: 200px; /* Ширина карточек */
        text-align: center;
        box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
    }

    .card img {
        width: 100%; /* Ширина изображения занимает 100% карточки */
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card h2 {
        margin: 10px 0;
    }

    .card p {
        padding: 0 10px;
    }

    button {
        margin: 10px;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: gold;
        color: black;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #ffd700;
    }
</style>
