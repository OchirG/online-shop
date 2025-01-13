<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы</title>
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
            flex-direction: column;
            align-items: center;
            gap: 10px; /* Расстояние между заказами */
            padding: 20px;
        }

        .card {
            background-color: rgba(255, 255, 0, 0.17);
            border: 2px solid gold;
            border-radius: 10px;
            width: 200px; /* Уменьшенная ширина карточек */
            padding: 10px; /* Отступы внутри карточки */
            text-align: center;
            cursor: pointer; /* Указываем, что карточка кликабельна */
            transition: transform 0.2s; /* Анимация при наведении */
        }

        .card:hover {
            transform: scale(1.05); /* Увеличение карточки при наведении */
        }

        .card-content {
            display: none; /* Скрываем содержимое по умолчанию */
            padding: 10px;
        }

        .card img {
            width: 100%; /* Ширина изображения занимает 100% карточки */
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card h2 {
            margin: 10px 0;
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
</head>
<body>

<header>
    <h1>Мои Заказы</h1>
    <a href="/catalog">Продолжить покупки</a>
</header>

<div class="catalog">
    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <div class="card" onclick="toggleOrder(<?php echo $order['id']; ?>)">
                <h2>Заказ №<?php echo htmlspecialchars($order['id']); ?></h2>
                <div id="order-content-<?php echo $order['id']; ?>" class="card-content">
                    <?php if (!empty($order['products'])): ?>
                        <?php foreach ($order['products'] as $product): ?>
                            <div>
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['productname']); ?>">
                                <h2><?php echo htmlspecialchars($product['productname']); ?></h2>
                                <h3><?php echo htmlspecialchars($product['description']); ?></h3>
                                <p>Цена: <?php echo htmlspecialchars($product['price']); ?> рублей.</p>
                                <form method="POST" action="/add-product">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                    <input type="number" name="amount" value="<?php echo htmlspecialchars($product['order_amount']); ?>" min="1">
                                    <button type="submit">Купить</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Нет доступных продуктов в данном заказе.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Нет доступных заказов.</p>
    <?php endif; ?>
</div>

<script>
    function toggleOrder(orderId) {
        const content = document.getElementById('order-content-' + orderId);
        if (content.style.display === 'block') {
            content.style.display = 'none';
        } else {
            content.style.display = 'block';
        }
    }
</script>

</body>
</html>

