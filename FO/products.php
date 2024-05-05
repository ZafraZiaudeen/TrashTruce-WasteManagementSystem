<?php
include_once('Conn.php');
class Products
{
    public $cID;
    public $cName;
    public $cactive;
    public $pID;
    public $pname;
    public $pprice;
    public $pdescription;
    public $pimage;
    public $pactive;
    public $pcat_id;
    public $quantitySold;
    
    //------------------------Categories---------------------------------------------//

    public function Add()
    {
        try {
            $query = "INSERT INTO `category`(`Title`, `active`)
             VALUES (:title,:active)";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);

            $st->bindValue(":title", $this->cName, PDO::PARAM_STR);
            $st->bindValue(":active",$this->cactive,PDO::PARAM_STR);
            $st->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            throw $e;
        }
    }   
    
public static function GetCategories()
{
    try {
        $query = "SELECT `ID`, `Title`, `active` FROM `category`";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $categories = array();

        foreach ($result->fetchAll() as $r) {
            $category = new Products();
            $category->cID = $r['ID'];
            $category->cName = $r['Title'];
            $category->cactive = $r['active'];

            array_push($categories, $category);
        }
        return $categories;
    } catch (Exception $th) {
        throw $th;
    }
}

public static function GetCategory($cID)
{
    try {
        $query = "SELECT `ID`, `Title`, `active`  FROM `category` WHERE `ID` = :ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $cID, PDO::PARAM_INT);
        $st->execute();

        $r = $st->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $category = new Products();
            $category->cID = $r['ID'];
            $category->cName = $r['Title'];
            $category->cactive = $r['active'];
            
            return $category;
        }
        return null;
    } catch (Exception $th) {
        throw $th;
    }
}

public function Update()
{
    try {
        $query = "UPDATE `category` SET `Title`=:title, `active`=:active
        WHERE `ID` = :ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $this->cID, PDO::PARAM_INT);
        $st->bindValue(":title", $this->cName, PDO::PARAM_STR);
        $st->bindValue(":active", $this->cactive, PDO::PARAM_STR);

        $st->execute();
    } catch (Exception $ex) {
        throw $ex;
    }
}

public static function DeleteCategory($cID) {
    try{
    $query="DELETE FROM `category` WHERE `ID` = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$cID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}
public static function SearchCategories($search)
{
    try {
        $query = "SELECT `ID`, `Title`, `active` FROM `category` 
                  WHERE `Title` LIKE :search
                  OR `active` LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $categories = array();

        foreach ($st->fetchAll() as $r) {
            $category = new Products();
            $category->cID = $r['ID'];
            $category->cName = $r['Title'];
            $category->cactive = $r['active'];

            array_push($categories, $category);
        }

        return $categories;
    } catch (Exception $ex) {
        throw $ex;
    }
}
  //----------------------------------Products--------------------------------------------//

public function AddProduct()
{
    try {
        $query = "INSERT INTO `product`(`Name`, `Price`, `Description`, `cat_id`, `active`)
         VALUES (:name, :price, :description, :cat_id, :active)";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);

        $st->bindValue(":name", $this->pname, PDO::PARAM_STR);
        $st->bindValue(":price", $this->pprice, PDO::PARAM_STR);
        $st->bindValue(":description", $this->pdescription, PDO::PARAM_STR);
        $st->bindValue(":cat_id", $this->pcat_id, PDO::PARAM_INT);
        $st->bindValue(":active", $this->pactive, PDO::PARAM_STR);
        
        $st->execute();
        return $conn->lastInsertId();
    } catch (Exception $e) {
        throw $e;
    }
}

public function UpdatePImage()
{
    try {
        $query = "UPDATE `product` SET  `Image`=:pimage 
                WHERE ID=:ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":pimage", $this->pimage, PDO::PARAM_STR);
        $st->bindValue(":ID", $this->pID, PDO::PARAM_STR);
        $st->execute();
    } catch (Exception $e) {
        throw $e;
    }
}

public static function GetProducts()
{
    try {
        $query = "SELECT p.ID, p.Name, p.Price, p.Description, p.Image, p.cat_id, p.active, c.Title AS CategoryName
                  FROM product p
                  LEFT JOIN category c ON p.cat_id = c.ID";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $products = array();

        foreach ($result->fetchAll() as $r) {
            $product = new Products();
            $product->pID = $r['ID'];
            $product->pname = $r['Name'];
            $product->pprice = $r['Price'];
            $product->pdescription = $r['Description'];
            $product->pimage = $r['Image'];
            $product->pcat_id = $r["cat_id"];
            $product->pactive = $r["active"];
            $product->cName = $r["CategoryName"]; 

            array_push($products, $product);
        }
        return $products;
    } catch (Exception $th) {
        throw $th;
    }
}

public static function GetProduct($pID)
{
    try{
        $query = "SELECT `ID`, `Name`, `Price`, `Description`, `Image`, `cat_id`, `active` FROM `product` WHERE `ID` = :ID ";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $pID, PDO::PARAM_INT);
        $st->execute();

        $r = $st->fetch(PDO::FETCH_ASSOC);
        if ($r){
            $product = new Products();
            $product->pID = $r['ID'];
            $product->pname = $r['Name'];
            $product->pprice = $r['Price'];
            $product->pdescription = $r['Description'];
            $product->pimage = $r['Image'];
            $product->pcat_id= $r["cat_id"];
            $product->pactive= $r["active"];

            return $product;
        }
        return null;
    } catch (Exception $th) {
        throw $th;
    }
}



    public function UpdateProduct()
{
    try {
        $query = "UPDATE `product` SET `Name`=:pname, `Price`=:pprice, `Description`=:pdesc, `cat_id`=:pcatID, `active`=:pactive
        WHERE `ID` = :ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $this->pID, PDO::PARAM_INT);
        $st->bindValue(":pname", $this->pname, PDO::PARAM_STR);
        $st->bindValue(":pprice", $this->pprice, PDO::PARAM_STR);
        $st->bindValue(":pdesc", $this->pdescription, PDO::PARAM_STR);
        $st->bindValue(":pcatID", $this->pcat_id, PDO::PARAM_INT);
        $st->bindValue(":pactive", $this->pactive, PDO::PARAM_STR);

        $st->execute();
    } catch (Exception $ex) {
        throw $ex;
    }
}


public static function DeleteProduct($pID) {
    try{
    $query="DELETE FROM `product` where `ID` = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$pID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}

public static function GetProductsByCategory($catID)
{
    try {
        $query = "SELECT p.ID, p.Name, p.Price, p.Description, p.Image, p.cat_id, p.active, c.Title AS CategoryName
                  FROM product p
                  LEFT JOIN category c ON p.cat_id = c.ID
                  WHERE p.cat_id = :catID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":catID", $catID, PDO::PARAM_INT);
        $st->execute();

        $products = array();

        foreach ($st->fetchAll() as $r) {
            $product = new Products();
            $product->pID = $r['ID'];
            $product->pname = $r['Name'];
            $product->pprice = $r['Price'];
            $product->pdescription = $r['Description'];
            $product->pimage = $r['Image'];
            $product->pcat_id = $r["cat_id"];
            $product->pactive = $r["active"];
            $product->cName = $r["CategoryName"]; 

            array_push($products, $product);
        }
        return $products;
    } catch (Exception $th) {
        throw $th;
    }
}public static function GetActiveCategories()
{
    try {
        $query = "SELECT `ID`, `Title`, `active` FROM `category` WHERE `active` = 'yes'";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $categories = array();

        foreach ($result->fetchAll() as $r) {
            $category = new Products();
            $category->cID = $r['ID'];
            $category->cName = $r['Title'];
            $category->cactive = $r['active'];

            array_push($categories, $category);
        }
        return $categories;
    } catch (Exception $th) {
        throw $th;
    }
}

public static function GetActiveProducts()
{
    try {
        $query = "SELECT p.ID, p.Name, p.Price, p.Description, p.Image, p.cat_id, p.active, c.Title AS CategoryName
                  FROM product p
                  LEFT JOIN category c ON p.cat_id = c.ID
                  WHERE p.active = 'yes'";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $products = array();

        foreach ($result->fetchAll() as $r) {
            $product = new Products();
            $product->pID = $r['ID'];
            $product->pname = $r['Name'];
            $product->pprice = $r['Price'];
            $product->pdescription = $r['Description'];
            $product->pimage = $r['Image'];
            $product->pcat_id = $r["cat_id"];
            $product->pactive = $r["active"];
            $product->cName = $r["CategoryName"]; 

            array_push($products, $product);
        }
        return $products;
    } catch (Exception $th) {
        throw $th;
    }
}
public static function SearchProducts($search, $categoryID)
{
    try {
        $query = "SELECT p.ID, p.Name, p.Price, p.Description, p.Image, p.cat_id, p.active, c.Title AS CategoryName
                  FROM product p
                  LEFT JOIN category c ON p.cat_id = c.ID
                  WHERE (p.Name LIKE :search 
                  OR p.Description LIKE :search 
                  OR p.active LIKE :search
                  OR p.Price LIKE :search
                  OR c.Title LIKE :search)
                  AND (:categoryID IS NULL OR p.cat_id = :categoryID)";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->bindValue(":categoryID", $categoryID, PDO::PARAM_INT);
        $st->execute();

        $products = array();

        foreach ($st->fetchAll() as $r) {
            $product = new Products();
            $product->pID = $r['ID'];
            $product->pname = $r['Name'];
            $product->pprice = $r['Price'];
            $product->pdescription = $r['Description'];
            $product->pimage = $r['Image'];
            $product->pcat_id = $r["cat_id"];
            $product->pactive = $r["active"];
            $product->cName = $r["CategoryName"]; 

            array_push($products, $product);
        }

        return $products;
    } catch (Exception $ex) {
        throw $ex;
    }
}
}
?>