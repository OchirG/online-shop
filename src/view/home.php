<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Интернет-магазин Star Wars</title>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url('image/dartoboi.jpg');
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

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: rgb(255, 221, 0);
            text-decoration: none;
        }

        h1 {
            font-family: 'Alfa Slab One', cursive;
            font-size: 36px;
        }

        .promotions {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background-color: rgba(255, 255, 0, 0.17);
            border-radius: 10px;
        }

        .promotion-card {
            margin: 20px auto;
            padding: 20px;
            background-color: #444;
            border-radius: 8px;
            color: white;
            display: inline-block;
        }

        .catalog {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
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
            width: 100%;
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

        footer {
            text-align: center;
            padding: 10px;
            background-color: #222;
            color: white;
        }
    </style>
</head>
<body>
<header>
    <h1>Star Wars: Магазин игрушек</h1>
    <nav>
        <ul>
            <li><a href="/">Главная</a></li>
            <li><a href="/catalog">Каталог</a></li>
            <li><a href="/about">О нас</a></li>
            <li><a href="/contact">Контакты</a></li>
            <li><a href="/sale">Распродажа</a></li>
        </ul>
    </nav>
</header>
<main>
    <section class="promotions">
        <h2>Специальные предложения</h2>
        <div class="promotion-card">
            <h3>Ультра Скидки на Игрушки!</h3>
            <p>Скидка 20% на все товары до конца месяца!</p>
            <a href="/sale" class="button">Узнать больше</a>
        </div>
    </section>
    <div class="catalog">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="card">
                    <img src="<?php echo $product->getImage(); ?>" alt="<?php echo htmlspecialchars($product->getProductName()); ?>">
                    <h2><?php echo htmlspecialchars($product->getProductName()); ?></h2>
                    <h3><?php echo htmlspecialchars($product->getDescription()); ?></h3>
                    <p>Цена: <?php echo htmlspecialchars($product->getPrice()); ?> рублей.</p>
                    <form method="POST" action="/add-product">
                        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                        <input type="number" name="amount" value="1" min="1">
                        <button type="submit">Купить</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Нет доступных товаров для отображения.</p>
        <?php endif; ?>
    </div>
</main>
<footer>
    <p>&copy; 2024 Star Wars Магазин. Все права защищены.</p>
    <p>Контакты: support@starwars.com</p>
</footer>
</body>
</html>