<?php
namespace App\Model;

use PDO;
use App\Core\Database;

class Order
{
    public static function create(array $items): array
    {
        $db = Database::getInstance();

        // Insert the order
        $stmt = $db->prepare("INSERT INTO orders () VALUES ()");
        $stmt->execute();
        $orderId = $db->lastInsertId();

        // Insert each order item using addItem()
        foreach ($items as $item) {
            self::addItem($orderId, $item);
        }

        // Return the full order
        return self::fetchById($orderId);
    }

    public static function addItem(int $orderId, array $item): void
    {
        $db = Database::getInstance();

        $stmt = $db->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, selected_options)
            VALUES (:order_id, :product_id, :quantity, :selected_options)
        ");

        $stmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $item['productId'],
            ':quantity' => $item['quantity'],
            ':selected_options' => json_encode($item['selectedOptions'] ?? []),
        ]);
    }

    public static function fetchById(string $id): array
    {
        $db = Database::getInstance();

        $stmt = $db->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) return [];

        $stmtItems = $db->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
        $stmtItems->execute([':order_id' => $id]);
        $order['items'] = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        return $order;
    }
}

// namespace App\Model;

// use PDO;
// use App\Core\Database;

// class Order {

//     public static function create(): int
//     {
//         $db = Database::getInstance();

//         $stmt = $db->prepare("INSERT INTO orders () VALUES ()");
//         $stmt->execute();

//         return (int) $db->lastInsertId();
//     }

//     public static function addItem(
//         int $orderId,
//         int $productId,
//         int $quantity,
//         array $selectedOptions
//     ): void
//     {
//         $db = Database::getInstance();

//         $stmt = $db->prepare("
//             INSERT INTO order_items 
//             (order_id, product_id, quantity, selected_options)
//             VALUES (:order_id, :product_id, :quantity, :selected_options)
//         ");

//         $stmt->bindValue(':order_id', $orderId);
//         $stmt->bindValue(':product_id', $productId);
//         $stmt->bindValue(':quantity', $quantity);
//         $stmt->bindValue(':selected_options', json_encode($selectedOptions));

//         $stmt->execute();
//     }

//     public static function fetchAll(): array
//     {
//         $db = Database::getInstance();

//         $ordersStmt = $db->query("SELECT * FROM orders ORDER BY created_at DESC");
//         $orders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);

//         foreach ($orders as &$order) {

//             $itemsStmt = $db->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
//             $itemsStmt->bindValue(':order_id', $order['id']);
//             $itemsStmt->execute();
//             $order['items'] = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);
//         }

//         return $orders;
//     }
// }

// namespace App\Model;

// use PDO;

// class OrderModel
// {
//     private static PDO $connection;

//     public static function setConnection(PDO $pdo): void
//     {
//         self::$connection = $pdo;
//     }

//     public static function createOrder(): int
//     {
//         $stmt = self::$connection->prepare(
//             "INSERT INTO orders () VALUES ()"
//         );

//         $stmt->execute();

//         return (int) self::$connection->lastInsertId();
//     }

//     public static function addOrderItem(
//         int $orderId,
//         int $productId,
//         int $quantity,
//         array $selectedOptions
//     ): void {
//         $stmt = self::$connection->prepare(
//             "INSERT INTO order_items 
//             (order_id, product_id, quantity, selected_options)
//             VALUES (:order_id, :product_id, :quantity, :selected_options)"
//         );

//         $stmt->execute([
//             'order_id' => $orderId,
//             'product_id' => $productId,
//             'quantity' => $quantity,
//             'selected_options' => json_encode($selectedOptions),
//         ]);
//     }
// }