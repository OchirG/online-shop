<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
</head>
<body>
<h1>Ваша корзина</h1>

<?php if (empty($products)): ?>
    <p>Ваша корзина пуста.</p>
<?php else: ?>
    <ul>
        <?php
        $total = 0;
        foreach ($products as $product):
            $price = $product->getPrice();
            $amount = $product->getAmount();
            $total += $amount * $price;
            ?>
            <li>
                <img src="<?= htmlspecialchars($product->getImage()) ?>" alt="<?= htmlspecialchars($product->getProductName()) ?>" style="width: 100px; height: auto;">
                <?= htmlspecialchars($product->getProductName()) ?> - <?= $amount ?> шт. по <?= $price ?> рублей

                <form method="POST" action="/remove_product" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                    <button type="submit">Удалить из корзины</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <h2>Итого: <?= $total ?> рублей</h2>
<?php endif; ?>

<a href="/catalog">Продолжить покупки</a>
<a href="/logout">Выйти</a>
<a href="/order">Оформить заказ</a>

</body>
</html>

<style>


    body {
        background-image: url('<?php echo 'image/starwars1.jpg'; ?>');
        font-family: Arial, sans-serif;
        background-color: rgba(248, 249, 250, 0.98);
        color: #2c76f3;
        margin: 0;
        padding: 20px;
    }

    h1 {
        color: #007bff;
    }

    h2 {
        color: #28a745;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    li {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(221, 221, 221, 0.44);
        margin: 10px 0;
        padding: 10px;
        border-radius: 5px;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 15px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    a:hover {
        background-color: #0056b3;
    }
</style>