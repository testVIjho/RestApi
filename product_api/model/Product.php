<?php
class Product
{
    private $con;
    private $table = "product";

    //product properties;

    public $id;
    public $productName;

    public function __construct($db)
    {
        $this->con = $db;
    }

    public function read()
    {
        $query = "SELECT id,
        productname As  productName FROM " . $this->table . " 
        ";

        //Prepare statement
        $stmt = $this->con->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    public function readSingle()
    {
        $query = "SELECT id,productname  FROM " . $this->table . "
        WHERE id = ? ";

        //prepare statement
        $stmt = $this->con->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind ID
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->productName = $row['productname'];
    }
    public function create()
    {
        $query = "INSERT INTO " . $this->table . "
        SET id = :id,
            productname = :productname
        ";
        $stmt = $this->con->prepare($query);

        //clean data 
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->productName = htmlspecialchars(strip_tags($this->productName));

        //bind ID

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":productname", $this->productName);

        if ($stmt->execute()) {
            return true;
        }
        print_r("Error :%s.\n" . $stmt->errorinfo());

        return false;
    }
    public function update()
    {
        $sql = "UPDATE " . $this->table . "
        SET 
        productname = :productname
        WHERE  id = :id
        ";
        //prepare statemet
        $stmt = $this->con->prepare($sql);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->productName = htmlspecialchars(strip_tags($this->productName));

        //bind parameter
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":productname", $this->productName);


        if ($stmt->execute()) {
            return true;
        }

        print_r("Error : %s.\n" . $stmt->errorinfo());
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table . "
        WHERE id = :id";

        $stmt = $this->con->prepare($query);

        //clean data 
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind id
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute()) {
            return true;
        }

        print_r("Error :%s.\n" . $stmt->errorinfo());
        return false;
    }
}
