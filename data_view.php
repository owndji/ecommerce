<?php
require 'connection.php'; // Include the connection file

// Queries to fetch the data
$photos = $pdo->query("SELECT * FROM photo")->fetchAll(PDO::FETCH_ASSOC);
$rates = $pdo->query("SELECT * FROM rate")->fetchAll(PDO::FETCH_ASSOC);
$payments = $pdo->query("SELECT * FROM payment")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Visualization</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Link to CSS -->
</head>
<body>
    <h1>Data Visualization</h1>

    <h2>Photos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>URL</th>
        </tr>
        <?php foreach ($photos as $photo) : ?>
            <tr>
                <td><?= htmlspecialchars($photo['photo_id']) ?></td>
                <td><?= htmlspecialchars($photo['product_id']) ?></td>
                <td><a href="<?= htmlspecialchars($photo['photo_url']) ?>" target="_blank">View</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Product Reviews</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>User</th>
            <th>Rating</th>
            <th>Comment</th>
        </tr>
        <?php foreach ($rates as $rate) : ?>
            <tr>
                <td><?= htmlspecialchars($rate['rate_id']) ?></td>
                <td><?= htmlspecialchars($rate['product_id']) ?></td>
                <td><?= htmlspecialchars($rate['user_id']) ?></td>
                <td><?= htmlspecialchars($rate['rating']) ?></td>
                <td><?= htmlspecialchars($rate['comment']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Payment Methods</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Method</th>
            <th>Encrypted Data</th>
        </tr>
        <?php foreach ($payments as $payment) : ?>
            <tr>
                <td><?= htmlspecialchars($payment['payment_id']) ?></td>
                <td><?= htmlspecialchars($payment['user_id']) ?></td>
                <td><?= htmlspecialchars($payment['method']) ?></td>
                <td><?= htmlspecialchars($payment['encrypted_data']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
