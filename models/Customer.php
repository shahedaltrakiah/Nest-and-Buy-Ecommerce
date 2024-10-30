<?php

require 'models/Model.php';

class Customer extends Model
{
    public function __construct()
    {
        parent::__construct('customers');

    }

    public function register($data) {
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
    (first_name, last_name, email, 	phone_number, password) VALUES (?, ?, ?, ?, ?)");

        return $statement->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            password_hash($data['password'], PASSWORD_BCRYPT)
        ]);
    }

    public function login($email) {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email = ?");
        $statement->execute([$email]);  // Pass the $email parameter
        return $statement->fetch(\PDO::FETCH_ASSOC); // Adjust to fetch single user record
    }

    public function isEmailTaken($email)
    {
        // Prepare a statement to check if the email exists
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $this->table WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Fetch the count result
        $count = $stmt->fetchColumn();

        // Return true if email exists, false otherwise
        return $count > 0;
    }

}