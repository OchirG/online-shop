<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Star Wars: Информация о продукте</title>
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
            <li><a href="/cart">Моя корзина</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="product-details">
        <img src="<?php echo $product->getImage(); ?>" alt="<?php echo htmlspecialchars($product->getProductName()); ?>">
        <h2><?php echo htmlspecialchars($product->getProductName()); ?></h2>
        <h3><?php echo htmlspecialchars($product->getDescription()); ?></h3>
        <p>Цена: <?php echo htmlspecialchars($product->getPrice()); ?> рублей.</p>

        <form class="add-to-cart-form" action="/add-product" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
            <input type="number" name="amount" value="1" min="1">
            <button type="submit" class="add-to-cart">Купить</button>
        </form>

        <div class="review-form">
            <h3>Добавить отзыв</h3>
            <form action="/product/<?php echo $product->getId(); ?>" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                <textarea name="comment" required placeholder="Напишите ваш отзыв..."></textarea>
                <input type="number" name="rating" min="1" max="5" required placeholder="Оценка от 1 до 5">
                <button type="submit">Отправить отзыв</button>
            </form>
        </div>

        <div class="reviews">
            <h3>Отзывы о продукте</h3>
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-card">
                        <p><strong><?php echo htmlspecialchars($review->getUserName()); ?></strong> (Оценка:
                            <?php echo htmlspecialchars($review->getRating()); ?>)</p>
                        <p><?php echo htmlspecialchars($review->getComment()); ?></p>
                    </div>
                <?php endforeach; ?>
                <p>Средняя оценка: <?php echo htmlspecialchars($averageRating); ?> из 5</p>
            <?php else: ?>
                <p>Отзывы пока отсутствуют.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 Star Wars Магазин. Все права защищены.</p>
    <p>Контакты: support@starwars.com</p>
</footer>
</body>
</html>

<div id="errorModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); width:300px; background:white; border: 1px solid #ddd; border-radius: 8px; z-index: 1000;">
    <div style="padding: 20px;">
        <h4>Ошибка</h4>
        <p id="errorMessage"></p>
        <button onclick="closeModal()">Закрыть</button>
    </div>
</div>

<script>
    function closeModal() {
        document.getElementById("errorModal").style.display = "none";
    }
    document.querySelector('.review-form form').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                if (data.startsWith("Вы не можете оставить отзыв")) {
                    document.getElementById("errorMessage").innerText = data;
                    document.getElementById("errorModal").style.display = "block";
                } else {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                document.getElementById("errorMessage").innerText = "Произошла ошибка при отправке отзыва.";
                document.getElementById("errorModal").style.display = "block";
            });
    });
</script>




    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background: #000;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-details {
            margin-bottom: 20px;
        }

        .product-details img {
            width: 100%;
            max-width: 350px;
            display: block;
            margin: 0 auto;
        }

        .add-to-cart-form,
        .review-form {
            margin: 20px 0;
        }

        .reviews {
            margin-top: 40px;
        }

        .review-card {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background: #000;
            color: #fff;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>