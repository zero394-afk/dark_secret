<?php
include '../Classes/Database.php';

class ContactForm {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function handleFormSubmission($name, $email, $message) {
        // Sanitize input
        $name = $this->conn->real_escape_string($name);
        $email = $this->conn->real_escape_string($email);
        $message = $this->conn->real_escape_string($message);

        $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";

        if ($this->conn->query($sql) === TRUE) {
            echo "Message sent successfully!";
            $this->sendEmailNotification($name, $email, $message);
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    private function sendEmailNotification($name, $email, $message) {
        $to = "admin@bakeeasebakery.com";
        $subject = "New Contact Message";
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $email_message = "Name: $name<br>Email: $email<br>Message: $message";

        if (mail($to, $subject, $email_message, $headers)) {
            echo 'Email notification sent successfully!';
        } else {
            echo 'Email notification could not be sent.';
        }
    }
}
