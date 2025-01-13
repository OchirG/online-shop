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
        <?php foreach ($products as $product): ?>
            <li>
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['productname']) ?>" style="width: 100px; height: auto;">
                <?= htmlspecialchars($product['productname']) ?> - <?= $product['amount'] ?> шт. по <?= $product['price'] ?> рублей
            </li>
        <?php endforeach; ?>
    </ul>
    <h2>Итого: <?php echo $product['amount']*$product['price'] ?> рублей</h2>
<?php endif; ?>
<form method="POST" action="/remove-product">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    <button type="submit">Удалить из корзины</button>
</form>
<a href="/catalog">Продолжить покупки</a>
<a href="/logout">Выйти</a>
<a href="/order">Оформить заказ</a>

</body>
</html>

<style>
    /* styles.css */

    /* Основные стили для страницы корзины */
    body {
        background-image: url('<?php echo 'image/starwars1.jpg'; ?>');
        font-family: Arial, sans-serif;
        background-color: rgba(248, 249, 250, 0.98);
        color: #03060b;
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
        background: rgba(255, 255, 255, 0.61);
        border: 1px solid rgba(221, 221, 221, 0.66);
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