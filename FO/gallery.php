<?php
include_once('Conn.php');
class Gallery
{
    public $ID;
    public $name;
    public $img;
    public $featured;

    public function Add()
{
    try {
        $query = "INSERT INTO `gallery`(`Name`, `Featured`) 
        VALUES(:Name,:Featured)";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);

        $st->bindValue(":Name", $this->name, PDO::PARAM_STR);
        $st->bindValue(":Featured", $this->featured, PDO::PARAM_STR);
        $st->execute();
        return $conn->lastInsertId();
    } catch (Exception $e) {
        throw $e;
    }
}

public function UpdateImage()
{
    try {
        $query = "UPDATE `gallery` SET  `Image`=:image 
                WHERE ID=:ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":image", $this->img, PDO::PARAM_STR);
        $st->bindValue(":ID", $this->ID, PDO::PARAM_STR);
        $st->execute();
    } catch (Exception $e) {
        throw $e;
    }
}
public static function GetGalleries()
{
    try {
        $query = "SELECT `ID`,  `Name`, `Image`, `Featured` FROM `gallery`";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $galleries = array();

        foreach ($result->fetchAll() as $r) {
            $gallery = new Gallery();
            $gallery->ID = $r['ID'];
            $gallery->name = $r['Name']; 
            $gallery->img= $r['Image'];
            $gallery->featured= $r['Featured'];


            array_push($galleries, $gallery);
        }

        return $galleries;
    } catch (Exception $th) {
        throw $th;
    }
}


public function Update()
    {
        try {
            $query = "UPDATE `gallery` SET `Name`=:name, `Featured`=:featured WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
            $st->bindValue(":name", $this->name, PDO::PARAM_STR);
            $st->bindValue(":featured",$this->featured,PDO::PARAM_STR);

            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public static function GetGallery($ID)
{
    try {
        $query = "SELECT `ID`, `Name`, `Image`, `Featured` FROM `gallery` 
                  WHERE `ID` = :ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $ID, PDO::PARAM_INT);
        $st->execute();

        $r = $st->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $gallery = new Gallery();
            $gallery->ID = $r['ID'];
            $gallery->name = $r['Name']; 
            $gallery->img = $r['Image'];
            $gallery->featured=$r['Featured'];

            return $gallery;
        }
        return null;
    } catch (Exception $th) {
        throw $th;
    }
}  
    
public static function Delete($ID) {
    try{
    $query="DELETE FROM `gallery` where `ID` = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$ID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}
public static function GetFeaturedGalleries()
{
    try {
        $query = "SELECT `ID`, `Name`, `Image`, `Featured` FROM `gallery` WHERE `Featured` = 'yes'";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $featuredGalleries = array();

        foreach ($result->fetchAll() as $r) {
            $gallery = new Gallery();
            $gallery->ID = $r['ID'];
            $gallery->name = $r['Name']; 
            $gallery->img = $r['Image'];
            $gallery->featured = $r['Featured'];

            array_push($featuredGalleries, $gallery);
        }

        return $featuredGalleries;
    } catch (Exception $th) {
        throw $th;
    }
}

public static function SearchGallery($search)
{
    try {
        $query = "SELECT `ID`, `Name`, `Image`, `Featured` FROM `gallery` 
                  WHERE `Name` LIKE :search 
                     OR `Featured` LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $galleries = array();

        foreach ($st->fetchAll() as $r) {
            $gallery = new Gallery();
            $gallery->ID = $r['ID'];
            $gallery->name = $r['Name']; 
            $gallery->img = $r['Image'];
            $gallery->featured = $r['Featured'];

            array_push($galleries, $gallery);
        }

        return $galleries;
    } catch (Exception $ex) {
        throw $ex;
    }
}


}
?>