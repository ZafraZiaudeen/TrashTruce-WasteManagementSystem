<?php
include_once('Conn.php');
class Feedback
{
    public $ID;
    public $name;
    public $rate;
    public $feed;
    public $date;
    
    public function AddFeed()
    {
        try {
            $query = "INSERT INTO `feedback`(`Name`, `Rating`, `Feedback`, `Date`)
                      VALUES(:name, :rate, :feed, :date)";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);

            $st->bindValue(":name", $this->name, PDO::PARAM_STR);
            $st->bindValue(":rate", $this->rate, PDO::PARAM_INT);
            $st->bindValue(":feed", $this->feed, PDO::PARAM_STR);
            $st->bindValue(":date", $this->date, PDO::PARAM_STR);

            $st->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            throw $e;
        }
    }
    public static function GetFeedbacks()
    {
        try {
            $query = "SELECT `ID`, `Name`, `Rating`, `Feedback`, `Date` FROM `feedback`";
            $conn = Conn::GetConnection();
            $result = $conn->query($query);
            $feedbacks = array();
    
            foreach ($result->fetchAll() as $r) {
                $feedback = new Feedback();
                $feedback->ID = $r['ID'];
                $feedback->name = $r['Name'];
                $feedback->rate = $r['Rating'];
                $feedback->feed = $r['Feedback'];
                $feedback->date = $r['Date'];
    
                array_push($feedbacks, $feedback);
            }
    
            return $feedbacks;
        } catch (Exception $th) {
            throw $th;
        }
    }
    
    public static function GetFeed($ID)
    {
        try {
            $query = "SELECT `ID`, `Name`, `Rating`, `Feedback`, `Date` FROM `feedback` 
                      WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $ID, PDO::PARAM_INT);
            $st->execute();
    
            $r = $st->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $feed = new Feedback();
                $feed->ID = $r['ID'];
                $feed->name = $r['Name'];
                $feed->rate = $r['Rating'];
                $feed->feed = $r['Feedback'];
                $feed->date = $r['Date'];

    
                return $feed;
            }
            return null;
        } catch (Exception $th) {
            throw $th;
        }
    }  

    public function Update()
    {
        try {
            $query = "UPDATE `feedback` SET `Name`=:name,`Rating`=:rate,`Feedback`=:feed,`Date`= :date
                      WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
            $st->bindValue(":name", $this->name, PDO::PARAM_STR);
            $st->bindValue(":rate", $this->rate, PDO::PARAM_INT);
            $st->bindValue(":feed", $this->feed, PDO::PARAM_STR);
            $st->bindValue(":date", $this->date, PDO::PARAM_STR);
            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function Delete($ID) {
        try {
            $query = "DELETE FROM `feedback` WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $ID, PDO::PARAM_INT);
            $st->execute();
        } catch(Exception $ex) {
            throw $ex;
        }
    }

    public static function SearchFeedbacks($search)
{
    try {
        $query = "SELECT `ID`, `Name`, `Rating`, `Feedback`, `Date` 
                  FROM `feedback` 
                  WHERE `Name` LIKE :search 
                     OR `Feedback` LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $feedbacks = array();

        foreach ($st->fetchAll() as $r) {
            $feedback = new Feedback();
            $feedback->ID = $r['ID'];
            $feedback->name = $r['Name'];
            $feedback->rate = $r['Rating'];
            $feedback->feed = $r['Feedback'];
            $feedback->date = $r['Date'];

            array_push($feedbacks, $feedback);
        }

        return $feedbacks;
    } catch (Exception $ex) {
        throw $ex;
    }
}

}
?>
