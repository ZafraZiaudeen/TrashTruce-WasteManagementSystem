<?php
include_once('Conn.php');
class location
{
    public $ID;
    public $name;
    public $nearbyloc;
    public $img;
    public $url;


    public function Add()
{
    try {
        $query = "INSERT INTO `location`(`Place`, `NearbyLoc`,`url`) 
        VALUES(:name, :nearby,:url)";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);

        $st->bindValue(":name", $this->name, PDO::PARAM_STR);
        $st->bindValue(":nearby", $this->nearbyloc,PDO::PARAM_STR);
        $st->bindValue(":url",$this->url,PDO::PARAM_STR);

        $st->execute();
        return $conn->lastInsertId();
    } catch (Exception $e) {
        throw $e;
    }
}

public function UpdateImage()
{
    try {
        $query = "UPDATE `location` SET  `Image`=:image 
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
public static function GetLocations()
{
    try {
        $query = "SELECT `ID`, `Place`, `NearbyLoc`, `Image`, `url` FROM `location`";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $locations = array();

        foreach ($result->fetchAll() as $r) {
            $location = new location();
            $location->ID = $r['ID'];
            $location->name = $r['Place'];
            $location->nearbyloc = $r['NearbyLoc'];
            $location->img= $r['Image'];
            $location->url = $r['url']; 

            array_push($locations, $location);
        }

        return $locations;
    } catch (Exception $th) {
        throw $th;
    }
}


public function Update()
    {
        try {
            $query = "UPDATE `location` SET `Place`=:place,`NearbyLoc`=:nearbyloc,`url`=:url WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
            $st->bindValue(":place", $this->name, PDO::PARAM_STR);
            $st->bindValue(":nearbyloc", $this->nearbyloc,PDO::PARAM_STR);
            $st->bindValue(":url",$this->url,PDO::PARAM_STR);

            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public static function GetLocation($ID)
{
    try {
        $query = "SELECT `ID`, `Place`, `NearbyLoc`, `Image`, `url` FROM `location` 
                  WHERE `ID` = :ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $ID, PDO::PARAM_INT);
        $st->execute();

        $r = $st->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $location = new location();
            $location->ID = $r['ID'];
            $location->name = $r['Place']; 
            $location->nearbyloc = $r['NearbyLoc'];
            $location->img = $r['Image'];
            $location->url = $r['url']; 

            return $location;
        }
        return null;
    } catch (Exception $th) {
        throw $th;
    }
}

    
    
public static function Delete($ID) {
    try{
    $query="DELETE FROM `location` where `ID` = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$ID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}
public static function DeleteAllLocation() {
    try {
        $query = "DELETE FROM `location`"; 
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->execute();
    } catch (Exception $ex) {
        throw $ex;
    }
}
public static function SearchLocations($search)
{
    try {
        $query = "SELECT `ID`, `Place`, `NearbyLoc`, `Image`, `url` FROM `location` 
                  WHERE `Place` LIKE :search 
                     OR `NearbyLoc` LIKE :search
                     OR `url` LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $locations = array();

        foreach ($st->fetchAll() as $r) {
            $location = new location();
            $location->ID = $r['ID'];
            $location->name = $r['Place']; 
            $location->nearbyloc = $r['NearbyLoc'];
            $location->img = $r['Image'];
            $location->url = $r['url']; 

            array_push($locations, $location);
        }

        return $locations;
    } catch (Exception $ex) {
        throw $ex;
    }
}


}