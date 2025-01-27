<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление продукта</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>

<h1>Добавить продукт в корзину</h1>

<form action="/add-product" method="post">
    <div>
        <label for="product_id">Идентификатор продукта:</label>
        <input type="text" id="product_id" name="product_id" required>
        <span class="error"><?php if (isset($errors['product_id'])) echo $errors['product_id']; ?></span>
    </div>
    <div>
        <label for="amount">Количество:</label>
        <input type="number" id="amount" name="amount" min="1" required>
        <span class="error"><?php if (isset($errors['amount'])) echo $errors['amount']; ?></span>
    </div>
    <div>
        <button type="submit">Добавить в корзину</button>
    </div>
</form>

<a href="/cart">Перейти в корзину</a>

</body>
</html>



<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-image: url('<?php echo 'image/addproduct.jpg'; ?>');
    }

    h1 {
        color: #333;
        text-align: center;
    }

    form {
        background: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 400px;
        width: 100%;
    }

    div {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="number"] {
        width: calc(100% - 20px);
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    input[type="text"]:focus,
    input[type="number"]:focus {
        border-color: #007BFF;
        outline: none;
    }

    button {
        background-color: #007BFF;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error {
        color: red;
        font-size: 14px;
    }

    a {
        text-align: center;
        margin-top: 15px;
        display: block;
    }
</style>