<?php
// config.php
$host = 'localhost';
$dbname = 'dove_bakes_db';
$username = 'root'; // default xampp username
$password = '';     // default xampp password

$default_cakes = [
    [
        'id' => 1,
        'name' => 'Chocolate Fudge Cake',
        'description' => 'Rich layers of dark chocolate cake covered in smooth fudge frosting.',
        'price' => 2900.00,
        'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=600&q=80',
        'availability' => 1
    ],
    [
        'id' => 2,
        'name' => 'Vanilla Dream Cake',
        'description' => 'Light and fluffy vanilla sponge with Madagascar vanilla bean buttercream.',
        'price' => 2600.00,
        'image' => 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?auto=format&fit=crop&w=600&q=80',
        'availability' => 1
    ],
    [
        'id' => 3,
        'name' => 'Red Velvet Delight',
        'description' => 'Classic moist red velvet with signature tangy cream cheese frosting.',
        'price' => 3100.00,
        'image' => 'https://images.unsplash.com/photo-1616541823729-00fe0aacd32c?auto=format&fit=crop&w=600&q=80',
        'availability' => 1
    ]
];

// Provide a mock PDO class for fallback
class MockPDO {
    private $cakes;
    public function __construct($c) { $this->cakes = $c; }
    public function query($sql) {
        return new MockPDOStatement($this->cakes);
    }
    public function prepare($sql) {
        return new MockPDOStatement($this->cakes);
    }
}
class MockPDOStatement {
    private $data;
    public function __construct($d) { $this->data = $d; }
    public function fetchAll() { return $this->data; }
    public function execute($params = []) { return true; }
}

try {
    // Attempt to connect to MySQL
    $tempPdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $tempPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    
    // Now connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Initialize tables if they don't exist
    $schema = "
    CREATE TABLE IF NOT EXISTS cakes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        image VARCHAR(255),
        availability BOOLEAN DEFAULT 1
    );

    CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL
    );

    CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_name VARCHAR(255) NOT NULL,
        customer_email VARCHAR(255) NOT NULL,
        total_amount DECIMAL(10, 2) NOT NULL,
        payment_method VARCHAR(50) NOT NULL,
        status VARCHAR(50) DEFAULT 'Pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT,
        cake_id INT,
        quantity INT,
        price DECIMAL(10, 2),
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (cake_id) REFERENCES cakes(id) ON DELETE SET NULL
    );
    ";
    $pdo->exec($schema);

    // Seed admin if not exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM admins");
    if ($stmt->fetchColumn() == 0) {
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO admins (username, password_hash) VALUES ('admin', '$hash')");
    }

    // Seed initial products if cakes table is empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM cakes");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("
            INSERT INTO cakes (name, description, price, image, availability) VALUES 
            ('Chocolate Fudge Cake', 'Rich layers of dark chocolate cake covered in smooth fudge frosting.', 2900.00, 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=600&q=80', 1),
            ('Vanilla Dream Cake', 'Light and fluffy vanilla sponge with Madagascar vanilla bean buttercream.', 2600.00, 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?auto=format&fit=crop&w=600&q=80', 1),
            ('Red Velvet Delight', 'Classic moist red velvet with signature tangy cream cheese frosting.', 3100.00, 'https://images.unsplash.com/photo-1616541823729-00fe0aacd32c?auto=format&fit=crop&w=600&q=80', 1)
        ");
    }

} catch(Exception $e) {
    // If MySQL connection fails, fallback to MockPDO to allow local execution without DB
    $pdo = new MockPDO($default_cakes);
}
?>
