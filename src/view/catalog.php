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
    <h1>Star Wars: Магазин игрушек</h1>
</header>
<main>
    <div class="catalog">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="card">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['productname']); ?>">
                    <h2><?php echo htmlspecialchars($product['productname']); ?></h2>
                    <h2><?php echo htmlspecialchars($product['description']); ?></h2>
                    <p>Цена: <?php echo htmlspecialchars($product['price']); ?> рублей.</p>
                    <form method="POST" action="/add-product">
                        <input type="hidden" name="product_id" value="<?php $product['id']; ?>">
                        <input type="number" name="amount" value="" min="1">
                        <button type="submit">Купить</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Нет доступных товаров для отображения.</p>
        <?php endif; ?>
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

