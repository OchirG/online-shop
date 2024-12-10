<?php
class Cart {
    private $pdo;
    private $userId;

    public function __construct($pdo, $userId) {
        $this->pdo = $pdo;
        $this->userId = $userId;
    }

    public function getCartItems() {
        $stmt = $this->pdo->prepare("
            SELECT p.productname, p.price, p.image, up.amount
            FROM user_products up
            JOIN products p ON up.product_id = p.id
            WHERE up.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $this->userId]);
        return $stmt->fetchAll();
    }

    public function getTotal($cartItems) {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['amount'];
        }
        return $total;
    }
}

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
$userId = $_SESSION['user_id'];

$cart = new Cart($pdo, $userId);
$products = $cart->getCartItems();
$total = $cart->getTotal($products);
?>

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
        <?php foreach ($products as $item): ?>
            <li>
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['productname']) ?>" style="width: 100px; height: auto;">
                <?= htmlspecialchars($item['productname']) ?> - <?= $item['amount'] ?> шт. по <?= $item['price'] ?> рублей
            </li>
        <?php endforeach; ?>
    </ul>
    <h2>Итого: <?= $total ?> рублей</h2>
<?php endif; ?>
<a href="/catalog">Продолжить покупки</a>
<a href="/logout">Выйти</a>
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