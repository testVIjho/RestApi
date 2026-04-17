<?php
class Post
{
    //DB Stuff
    private $con;
    private $table = "buyer";

    //buyer properties
    public $buyerID;
    public $buyerName;
    public $productID;
    public $productName;
    public $quantity;
    public $price;


    public function __construct($db)
    {
        $this->con = $db;
    }

    public function read()
    {
        $sql = "SELECT p.id AS productID,
            p.productname AS productName,
            b.id AS buyerID,
            b.name AS buyerName,
            b.quantity AS quantity,
            b.price AS price
            FROM " . $this->table . " b
            INNER JOIN product p ON (p.id = b.product_id) ORDER BY p.id";

        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function readSingle()
    {
        $sql = "SELECT p.id AS productID,
                p.productname AS productName,
                b.id AS buyerID,
                b.name AS buyerName,
                b.quantity AS quantity,
                b.price AS price
                FROM " . $this->table . " b
                INNER JOIN product p ON (p.id = b.product_id )
                WHERE b.id=?";

        //prepare statement;
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $this->buyerID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->productID = $row['productID'];
        $this->productName = $row['productName'];
        $this->buyerID = $row['buyerID'];
        $this->buyerName = $row['buyerName'];
        $this->quantity = $row['quantity'];
        $this->price = $row['price'];
    }

    public function create()
    {
        $sql = "INSERT INTO " . $this->table . " 
            SET name = :name,
            quantity = :quantity,
            price = :price,
            product_id = :productID ";

        $stmt = $this->con->prepare($sql);

        //clean data 

        $this->buyerName = htmlspecialchars(strip_tags($this->buyerName));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->productID = htmlspecialchars(strip_tags($this->productID));

        //bind parameter

        $stmt->bindParam(':name', $this->buyerName);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':productID', $this->productID);

        if ($stmt->execute()) {
            return true;
        }

        print_r("Error : %s./n" . $stmt->errorInfo());

        return false;
    }
    public function update()
    {
        $query = "UPDATE " . $this->table . "
        SET name = :name,
        quantity = :quantity,
        price = :price,
        product_id = :product_id
        WHERE id = :id";
        // prepare statement
        $stmt = $this->con->prepare($query);

        // clean data
        $this->buyerID = htmlspecialchars(strip_tags($this->buyerID));
        $this->buyerName = htmlspecialchars(strip_tags($this->buyerName));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->productID = htmlspecialchars(strip_tags($this->productID));


        //bind parameter

        $stmt->bindParam(":name", $this->buyerName);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":product_id", $this->productID);
        $stmt->bindParam(":id", $this->buyerID);

        if ($stmt->execute()) {
            return true;
        }
        print_r("Error : %s./n" . $stmt->errorInfo());
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table . "
        WHERE id = ?";

        //prepare statement
        $stmt = $this->con->prepare($query);

        // clean data

        $this->buyerID = htmlspecialchars(strip_tags($this->buyerID));

        //bind ID
        $stmt->bindParam(1, $this->buyerID);

        if ($stmt->execute()) {
            return true;
        }

        print_r("Error : %s.\n" . $stmt->erroinfo());
    }
}
