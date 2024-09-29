<?php
class Database {
    private $servername = "localhost"; // Your database server name (usually localhost)
    private $username = "root"; // Your database username 
    private $password = ""; // Your database password
    private $dbname = "dark_secret"; // Your database name

    protected $conn; // Connection variable to be accessed by child classes

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Unable to connect to database: " . $this->dbname . " : " . $this->conn->connect_error);
        }
    }
    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function escape_string($value) {
        return $this->conn->real_escape_string($value);
    }

    public function close() {
        $this->conn->close();
    }
    public function getConnection() {
        $this->conn = new mysqli('localhost', 'username', 'password', 'database');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }

    public function construct() {
        $this->conn = new Database(); // Assuming Database is a class that handles DB connections
    }

    public function getProduct($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProduct($productId, $name, $description, $price, $image) {
        $stmt = $this->conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$name, $description, $price, $image, $productId]);
    }
}
?>