<?php
include_once('Conn.php');
class Team
{
    public $ID;
    public $name;
    public $img;
    public $position;
    public $description;


    public function Add()
    {
        try {
            $query = "INSERT INTO `team`(`Name`, `Position`, `Description`) 
             VALUES (:name,:position,:desc)";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);

            $st->bindValue(":name", $this->name, PDO::PARAM_STR);
            $st->bindValue(":position",$this->position,PDO::PARAM_STR);
            $st->bindValue(":desc",$this->description,PDO::PARAM_STR);
            $st->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            throw $e;
        }
    }   

    

public function UpdateImage()
{
    try {
        $query = "UPDATE `team` SET  `Image`=:image 
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
    
public static function GetTeamMems()
{
    try {
        $query = "SELECT `ID`, `Name`, `Image`, `Position`, `Description` FROM `team`";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $members = array();

        foreach ($result->fetchAll() as $r) {
            $member = new Team();
            $member->ID = $r['ID'];
            $member->name = $r['Name'];
            $member->img = $r['Image'];
            $member->position= $r['Position'];
            $member->description=$r['Description'];

            array_push($members, $member);
        }
        return $members;
    } catch (Exception $th) {
        throw $th;
    }
}

public static function GetMember($ID)
{
    try {
        $query = "SELECT `ID`, `Name`, `Image`, `Position`, `Description` FROM `team` WHERE `ID` = :ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $ID, PDO::PARAM_INT);
        $st->execute();

        $r = $st->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $member = new Team();
            $member->ID = $r['ID'];
            $member->name = $r['Name'];
            $member->img = $r['Image'];
            $member->position = $r['Position' ];
            $member->description = $r['Description'] ;
            return $member;
     
        }
        return null;
    } catch (Exception $th) {
        throw $th;
    }
}

public function Update()
{
    try {
        $query = "UPDATE `team` SET `Name`=:name,`Position`=:position,`Description`=:description
        WHERE `ID` = :ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
        $st->bindValue(":name", $this->name, PDO::PARAM_STR); 
        $st->bindValue(":position", $this->position, PDO::PARAM_STR); 
        $st->bindValue(":description", $this->description, PDO::PARAM_STR); 

        $st->execute();
    } catch (Exception $ex) {
        throw $ex;
    }
}

public static function DeleteMember($ID) {
    try{
    $query="DELETE FROM `team` WHERE `ID` = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$ID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}
public static function SearchTeam($search)
{
    try {
        $query = "SELECT `ID`, `Name`, `Image`, `Position`, `Description` FROM `team` 
                  WHERE `Name` LIKE :search
                  OR `Position` LIKE :search
                  OR `Description` LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $teamMembers = array();

        foreach ($st->fetchAll() as $r) {
            $member = new Team();
            $member->ID = $r['ID'];
            $member->name = $r['Name'];
            $member->img = $r['Image'];
            $member->position = $r['Position'];
            $member->description = $r['Description'];

            array_push($teamMembers, $member);
        }

        return $teamMembers;
    } catch (Exception $ex) {
        throw $ex;
    }
}

}
?>