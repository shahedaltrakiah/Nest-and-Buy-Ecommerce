<?php

require 'models/Model.php';

class Message extends Model {

    public function __construct()
    {
        parent::__construct('messages');

    }

    public function saveMessage() {
        // Prepare the SQL statement
        $statement = $this->pdo->prepare("
        INSERT INTO $this->table (customer_id, content, created_at) 
        VALUES (:customer_id, :content, NOW())
    ");

        // Bind parameters
        $statement->bindParam(':customer_id', $_SESSION['user']['id'], PDO::PARAM_INT);
        $statement->bindParam(':content', $_POST['message'], PDO::PARAM_STR);

        // Execute and return the result
        return $statement->execute();
    }


}