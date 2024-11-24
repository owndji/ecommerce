<?php
require_once 'vendor/autoload.php'; // Load Faker via Composer

$faker = Faker\Factory::create();
$pdo = new PDO('mysql:host=localhost;dbname=lecommerce', 'root', ''); // Change here if your database name or password is different

// Generate 10 users
for ($i = 0; $i < 10; $i++) {
    $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([
        $faker->userName,
        $faker->unique()->safeEmail,
        password_hash('password', PASSWORD_BCRYPT) // Encrypt passwords
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

// Generate 15 addresses for users
for ($i = 0; $i < 15; $i++) {
    $stmt = $pdo->prepare("INSERT INTO address (user_id, street, city, postal_code, country) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $faker->numberBetween(1, 10), // Randomly associate with a user
        $faker->streetAddress,
        $faker->city,
        $faker->postcode,
        $faker->country
    ]);
}

// Generate photos for products
for ($i = 0; $i < 20; $i++) {
    $stmt = $pdo->prepare("INSERT INTO photo (product_id, photo_url) VALUES (?, ?)");
    $stmt->execute([
        $faker->numberBetween(1, 20), // Random product ID
        $faker->imageUrl(640, 480, 'product') // Random image URL
    ]);
}

// Generate reviews for products
for ($i = 0; $i < 50; $i++) {
    $stmt = $pdo->prepare("INSERT INTO rate (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $faker->numberBetween(1, 20), // Random product ID
        $faker->numberBetween(1, 10), // Random user ID
        $faker->numberBetween(1, 5),  // Rating between 1 and 5
        $faker->sentence()            // Random comment
    ]);
}


// Generate payment methods for users
// Encryption key
$encryption_key = "your-secret-key"; // Change to a secure key

// Function to encrypt data
function encrypt_data($data, $key) {
    return openssl_encrypt($data, 'AES-128-CTR', $key, 0, '1234567891011121'); // Static IV for simplicity
}

// Generate payment methods
for ($i = 0; $i < 10; $i++) {
    $encrypted_card = encrypt_data($faker->creditCardNumber(), $encryption_key);
    $stmt = $pdo->prepare("INSERT INTO payment (user_id, method, encrypted_data) VALUES (?, ?, ?)");
    $stmt->execute([
        $faker->numberBetween(1, 10), // User ID
        $faker->randomElement(['Credit Card', 'IBAN']), // Payment method
        $encrypted_card
    ]);
}

// Generate orders and carts
for ($i = 0; $i < 15; $i++) {
    // Orders
    $stmt = $pdo->prepare("INSERT INTO `order` (user_id, address_id, total_amount, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $faker->numberBetween(1, 10), // User ID
        $faker->numberBetween(1, 15), // Address ID
        $faker->randomFloat(2, 20, 200), // Total between 20 and 200
        $faker->randomElement(['pending', 'delivered', 'cancelled']) // Random status
    ]);

    // Carts
    $stmt = $pdo->prepare("INSERT INTO cart (user_id) VALUES (?)");
    $stmt->execute([$faker->numberBetween(1, 10)]);
}
echo "Data inserted successfully!";
?>
