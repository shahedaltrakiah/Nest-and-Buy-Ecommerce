<?php

require 'models/Model.php';

class Message extends Model {

    public function __construct()
    {
        parent::__construct('messages');

    }

    public function saveMessage($id) {
        $statement = $this->pdo->prepare("
            INSERT INTO $this->table (customer_id,content,created_at) 
            VALUES (:customer_id, :content, :status, NOW())
        ");

        // Bind parameters
        $statement->bindParam(':customer_id', $id);

        // Execute the query
        return $statement->execute();
    }

}