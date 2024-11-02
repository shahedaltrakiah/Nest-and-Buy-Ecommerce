<?php

class Model
{
    protected $pdo;

    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
        $server_name = $_ENV['DB_SERVER'];
        $database_name = $_ENV['DB_DATABASE'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        $dsn = "mysql:host=$server_name;dbname=$database_name";

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function all ()
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table");
        $statement->execute();
        return $statement->fetchAll(\pdo::FETCH_ASSOC);
    }

    public function find($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE id = :id");
        $statement -> bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch(\pdo::FETCH_ASSOC);

    }

    public function create($data)
    {
        $keys = implode(',', array_keys($data));
        $tags = ':' . implode(', :', array_keys($data));  // Fixed spacing issue here
        $sql = "INSERT INTO $this->table ($keys) VALUES ($tags)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    public function update($id, $data)
    {
        // Add the id to the data array so it can be bound to the SQL statement
        $data['id'] = $id;
    
        // Prepare the fields for the SQL statement
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=:' . $key . ',';
        }
    
        $fields = rtrim($fields, ','); // Remove trailing comma
        $sql = "UPDATE $this->table SET $fields WHERE id = :id"; // Ensure the query has :id
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data); // Execute with the modified data array
    }
    

    public function delete($id)
    {
        $statement = $this->pdo->prepare( "DELETE FROM $this->table WHERE id = :id");
        $statement -> bindValue(':id', $id);
        $statement->execute();

    }

}