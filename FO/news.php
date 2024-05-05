<?php
include_once('Conn.php');
class News
{
    public $ID;
    public $name;
    public $img;
    public $description;
    public $date;


    public function Add()
{
    try {
        $query = "INSERT INTO news(name, description, date)  
        VALUES(:name, :description,:date)";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);

        $st->bindValue(":name", $this->name, PDO::PARAM_STR);
        $st->bindValue(":description", $this->description,PDO::PARAM_STR);
        $st->bindValue(":date",$this->date,PDO::PARAM_STR);

        $st->execute();
        return $conn->lastInsertId();
    } catch (Exception $e) {
        throw $e;
    }
}

public function UpdateImage()
{
    try {
        $query = "UPDATE news SET  Image=:image 
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
public static function GetNews()
{
    try {
        $query = "SELECT ID, name, Image, description, date FROM news";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $news = array();

        foreach ($result->fetchAll() as $r) {
            $snews = new News();
            $snews->ID = $r['ID'];
            $snews->name = $r['name'];
            $snews->img = $r['Image'];
            $snews->description= $r['description'];
            $snews->date = $r['date']; 

            array_push($news, $snews);
        }

        return $news;
    } catch (Exception $th) {
        throw $th;
    }
}
public function Update()
{
    try {
        $query = "UPDATE news SET name=:name, description=:description, date=:date WHERE ID = :ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
        $st->bindValue(":name", $this->name, PDO::PARAM_STR); 
        $st->bindValue(":description", $this->description, PDO::PARAM_STR); 
        $st->bindValue(":date", $this->date, PDO::PARAM_STR);

        $st->execute();
    } catch (Exception $ex) {
        throw $ex;
    }
}


public static function GetSNews($ID)
{
    try {
        $query = "SELECT ID, name, Image, description, date FROM news
                  WHERE ID = :ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $ID, PDO::PARAM_INT);
        $st->execute();

        $r = $st->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $news = new News();
            $news->ID = $r['ID'];
            $news->name = $r['name']; 
            $news->description = $r['description']; 
            $news->img = $r['Image'];
            $news->date = $r['date']; 

            return $news;
        }
        return null;
    } catch (Exception $th) {
        throw $th;
    }
}


    
    
public static function Delete($ID) {
    try{
    $query="DELETE FROM news where ID = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$ID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}

public static function GetNewsWordLimit()
{
    try {
        $query = "SELECT ID, name, `description`FROM news";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $news = array();

        foreach ($result->fetchAll() as $r) {
            $snews = new News();
            $snews->ID = $r['ID'];
            $snews->name = $r['name'];
            $description = implode(' ', array_slice(explode(' ', $r['description']), 0, 30));
            $snews->description = $description . (str_word_count($r['description']) > 30 ? '...' : '');


            array_push($news, $snews);
        }

        return $news;
    } catch (Exception $th) {
        throw $th;
    }
}
public static function GetNewsWordLimits()
{
    try {
        $query = "SELECT ID, name, Image, description, date FROM news";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $news = array();

        foreach ($result->fetchAll() as $r) {
            $snews = new News();
            $snews->ID = $r['ID'];
            $snews->name = $r['name'];
            $snews->img = $r['Image'];
            $snews->date = date("d.m.Y", strtotime($r['date']));

            // Limit description to 50 words
            $words = explode(' ', $r['description']);
            $limited_description = implode(' ', array_slice($words, 0, 30));
            $snews->description = $limited_description . (count($words) > 30 ? '...' : '');

            array_push($news, $snews);
        }

        return $news;
    } catch (Exception $th) {
        throw $th;
    }
}

public static function GetNewsWordLimitsDash($filter = null)
{
    try {
        $query = "SELECT ID, name, Image, description, date FROM news";

        if ($filter === 'today') {
            $query .= " WHERE DATE(date) = CURDATE()";
        } elseif ($filter === 'this_month') {
            $query .= " WHERE MONTH(date) = MONTH(CURDATE())";
        } elseif ($filter === 'this_year') {
            $query .= " WHERE YEAR(date) = YEAR(CURDATE())";
        }

        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $news = array();

        foreach ($result->fetchAll() as $r) {
            $snews = new News();
            $snews->ID = $r['ID'];
            $snews->name = $r['name'];
            $snews->img = $r['Image'];
            $snews->date = date("d.m.Y", strtotime($r['date']));

            // Limit description to 10 words
            $words = explode(' ', $r['description']);
            $limited_description = implode(' ', array_slice($words, 0, 10));
            $snews->description = $limited_description . (count($words) > 10 ? '...' : '');

            array_push($news, $snews);
        }

        return $news;
    } catch (Exception $th) {
        throw $th;
    }
}

public static function SearchNews($search)
{
    try {
        $query = "SELECT ID, name, Image, description, date FROM news 
                  WHERE name LIKE :search 
                     OR description LIKE :search
                    OR date LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $news = array();

        foreach ($st->fetchAll() as $r) {
            $snews = new News();
            $snews->ID = $r['ID'];
            $snews->name = $r['name'];
            $snews->img = $r['Image'];
            $snews->description = $r['description'];
            $snews->date = $r['date'];

            array_push($news, $snews);
        }

        return $news;
    } catch (Exception $ex) {
        throw $ex;
    }
}


}