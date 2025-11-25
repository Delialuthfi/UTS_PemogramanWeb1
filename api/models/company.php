<?php

class Company {
    private $conn;
    private $table_name = "companies";
    
    public $id;
    public $name;
    public $category;
    public $description;
    public $image_url;
    public $founded_year;
    public $employees;
    public $website;
    public $created_at;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // READ all companies
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // READ single company
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->name = $row['name'];
            $this->category = $row['category'];
            $this->description = $row['description'];
            $this->image_url = $row['image_url'];
            $this->founded_year = $row['founded_year'];
            $this->employees = $row['employees'];
            $this->website = $row['website'];
            $this->created_at = $row['created_at'];
            
            return $row;
        }
        
        return false;
    }
    
    // CREATE company
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (name, category, description, image_url, founded_year, employees, website) 
                  VALUES (:name, :category, :description, :image_url, :founded_year, :employees, :website)";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
        $this->founded_year = htmlspecialchars(strip_tags($this->founded_year));
        $this->employees = htmlspecialchars(strip_tags($this->employees));
        $this->website = htmlspecialchars(strip_tags($this->website));
        
        // Bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image_url", $this->image_url);
        $stmt->bindParam(":founded_year", $this->founded_year);
        $stmt->bindParam(":employees", $this->employees);
        $stmt->bindParam(":website", $this->website);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // UPDATE company
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, 
                      category = :category, 
                      description = :description, 
                      image_url = :image_url, 
                      founded_year = :founded_year, 
                      employees = :employees, 
                      website = :website 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
        $this->founded_year = htmlspecialchars(strip_tags($this->founded_year));
        $this->employees = htmlspecialchars(strip_tags($this->employees));
        $this->website = htmlspecialchars(strip_tags($this->website));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image_url", $this->image_url);
        $stmt->bindParam(":founded_year", $this->founded_year);
        $stmt->bindParam(":employees", $this->employees);
        $stmt->bindParam(":website", $this->website);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // DELETE company
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>