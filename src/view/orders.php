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
            flex-direction: row; /* Горизонтальное расположение */
            flex-wrap: wrap; /* Позволяет элементам переходить на следующую строку */
            justify-content: center; /* Центрирование элементов */
            gap: 20px; /* Расстояние между заказами */
            padding: 20px;
        }

        .card {
            background-color: rgba(255, 255, 0, 0.17);
            border: 2px solid gold;
            border-radius: 10px;
            width: 200px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .card:hover {
        }

        .card-content {
            padding: 10px;
        }

        .card img {
            width: 80%;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            margin: 0 auto;
        }

        .card h2 {
            margin: 5px 0;
            font-size: 18px;
        }

        .card h3 {
            margin: 5px 0;
            font-size: 14px;
        }

        .card p {
            font-size: 12px;
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
            <details class="card">
                <summary>
                    <h2>Заказ №<?php echo htmlspecialchars($order->getId()); ?></h2>
                </summary>
                <div id="order-content-<?php echo $order->getId(); ?>" class="card-content">
                    <?php if (!empty($order->getProducts())): ?>
                        <?php foreach ($order->getProducts() as $product): ?>
                            <div>
                                <img src="<?php echo htmlspecialchars($product->getImage()); ?>" alt="<?php echo htmlspecialchars($product->getProductName()); ?>">
                                <h2><?php echo htmlspecialchars($product->getProductName()); ?></h2>
                                <h3><?php echo htmlspecialchars($product->getDescription()); ?></h3>
                                <p>Цена: <?php echo htmlspecialchars($product->getOrderPrice()); ?> рублей.</p>
                                <form method="POST" action="/add-product">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product->getId()); ?>">
                                    <p>Количество: <?php echo $product->getOrderAmount(); ?></p>
                                </form>
                            </div>
                        <?php endforeach; ?>
                        <h2>Итого: <?php echo htmlspecialchars($order->getTotal()); ?> рублей</h2>
                    <?php else: ?>
                        <p>Нет доступных продуктов в данном заказе.</p>
                    <?php endif; ?>
                </div>
            </details>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Нет доступных заказов.</p>
    <?php endif; ?>
</div>

</body>
</html>
