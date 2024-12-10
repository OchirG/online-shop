<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
}

function validateAddProductForm(array $addProductForm): array|false {

    $errors = [];

    if (isset($addProductForm['product_id'])) {
        $productId = $addProductForm['product_id'];
        if (empty($productId)) {
            $errors['product_id'] = 'Идентификатор продукта не может быть пустым';
        } elseif ($productId < 1) {
            $errors['product_id'] = 'Идентификатор продукта должен быть положительным';
        } elseif (!is_numeric($productId)) {
            $errors['product_id'] = 'Идентификатор продукта должен быть числом';
        }else {
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE id = :id");
            $stmt->execute([
                'id' => $productId
            ]);
            $exists = $stmt->fetchColumn();
            if (!$exists) {
                $errors['product_id'] = 'Продукт с таким идентификатором не существует';
            }
        }
    }


    if (isset($addProductForm['amount'])) {
        $amount = $addProductForm['amount'];
        if (empty($amount)) {
            $errors['amount'] = 'Количество продуктов не должно быть пустым';
        } elseif ($amount < 1) {
            $errors['amount'] = 'Количество продуктов должно быть положительным';
        } elseif (!is_numeric($amount)) {
            $errors['amount'] = 'Количество продуктов должно быть числом';
        }
    }

    return $errors;
}


$errors = validateAddProductForm($_POST);

if (empty($errors)) {
    $userId = $_SESSION['user_id'];
    $productId = $_POST['product_id'];
    $amount = $_POST['amount'];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("
        INSERT INTO user_products (user_id, product_id, amount)
        VALUES (:user_id, :product_id, :amount)
        ON CONFLICT (user_id, product_id) 
        DO UPDATE SET amount = user_products.amount + excluded.amount;
    ");
    if ($stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount])) {
        header('Location: /cart');
    } else {
        echo 'Ошибка при добавлении продукта.';
    }
}

require_once './get_add_product.php';









