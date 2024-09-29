<?php
require_once "Database.php";
require_once "Product.php"; // Include the Product class as we'll need to fetch product data

class Cart extends Database {
    public function getCartItems() {
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $cartItems = [];
            $product = new Product(); // Create a Product object

            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $productData = $product->getProduct($productId);
                if ($productData) {
                    $cartItems[] = [
                        'product_id' => $productId,
                        'name' => $productData['name'],
                        'price' => $productData['price'],
                        'quantity' => $quantity,
                        'subtotal' => $productData['price'] * $quantity
                    ];
                } 
                // If productData is null, the product might not exist anymore, so we skip it.
            }
            return $cartItems;
        } else {
            return []; // Return an empty array if the cart is empty
        }
    }

    public function getCartTotal() {
        $total = 0;
        $cartItems = $this->getCartItems(); 

        foreach ($cartItems as $item) {
            $total += $item['subtotal'];
        }
        return $total;
    }
}