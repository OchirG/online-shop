<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Интернет-магазин Star Wars</title>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        button.cart-button {
            margin-left: 15px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: gold;
            color: black;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button.cart-button:hover {
            background-color: #ffd700;
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

        .cart-message {
            display: none;
            color: green;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
    <h1>Star Wars: Магазин игрушек</h1>
    <nav>
        <ul>
            <li><a href="/home">Главная</a></li>
            <li><a href="/catalog">Каталог</a></li>
            <li><a href="/about">О нас</a></li>
            <li><a href="/contact">Контакты</a></li>
            <li><a href="/sale">Распродажа</a></li>
            <li><button class="cart-button" onclick="window.location.href='/cart'">Моя корзина</button></li>
        </ul>
    </nav>
</header>
<main>
    <div class="catalog">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="card">
                    <img src="<?php echo $product->getImage(); ?>" alt="<?php echo htmlspecialchars($product->getProductName()); ?>">
                    <h2><?php echo htmlspecialchars($product->getProductName()); ?></h2>
                    <h3><?php echo htmlspecialchars($product->getDescription()); ?></h3>
                    <p>Цена: <?php echo htmlspecialchars($product->getPrice()); ?> рублей.</p>
                    <form class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                        <input type="number" name="amount" value="1" min="1">
                        <button type="button" class="add-to-cart">Купить</button>
                    </form>
                    <li><a href="/product/<?php echo $product->getId(); ?>">Подробнее</a></li>
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

<script>
    $(document).ready(function() {
        $('.add-to-cart').click(function() {
            var form = $(this).closest('.add-to-cart-form');
            var productId = form.find('input[name="product_id"]').val();
            var amount = form.find('input[name="amount"]').val();

            $.ajax({
                url: '/add-product',
                type: 'POST',
                data: {
                    product_id: productId,
                    amount: amount
                },
                success: function(response) {
                    $('#cart-message').fadeIn().delay(2000).fadeOut();
                },
                error: function(xhr, status, error) {
                    alert('Ошибка при добавлении товара в корзину. Попробуйте ещё раз.');
                }
            });
        });
    });
</script>
</body>
</html>