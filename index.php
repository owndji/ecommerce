<?php
require_once 'vendor/autoload.php'; // Load Faker via Composer

$faker = Faker\Factory::create(); // Create a data generator
$pdo = new PDO('mysql:host=localhost;dbname=lecommerce', 'root', '');

// Generate 10 users
for ($i = 0; $i < 10; $i++) {
    $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([
        $faker->userName,
        $faker->unique()->safeEmail,
        password_hash('password', PASSWORD_BCRYPT) // Secure passwords
    ]);
}

// Generate 20 products
for ($i = 0; $i < 20; $i++) {
    $stmt = $pdo->prepare("INSERT INTO product (name, description, price, stock) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $faker->word,
        $faker->sentence,
        $faker->randomFloat(2, 10, 100), // Price between 10 and 100
        $faker->numberBetween(1, 50) // Stock between 1 and 50
    ]);
}

echo "Data inserted successfully!";
?>
