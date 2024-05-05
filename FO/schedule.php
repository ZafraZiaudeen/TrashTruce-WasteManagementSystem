<?php
include_once('Conn.php');
class Schedule
{
    public $ID;
    public $name;
    public $description;
    public $file;
    public $date;
    
    public function AddSchedule()
    {
        try {
            $query = "INSERT INTO `schedule`(`Name`, `Description`, `File`, `Date`)
                      VALUES(:name, :description, :file, :date)";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);

            $st->bindValue(":name", $this->name, PDO::PARAM_STR);
            $st->bindValue(":description", $this->description, PDO::PARAM_STR);
            $st->bindValue(":file", $this->file, PDO::PARAM_STR);
            $st->bindValue(":date", $this->date, PDO::PARAM_STR);

            $st->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function GetSchedules()
    {
        try {
            $query = "SELECT `ID`, `Name`, `Description`, `File`, `Date` FROM `schedule`";
            $conn = Conn::GetConnection();
            $result = $conn->query($query);
            $schedules = array();

            foreach ($result->fetchAll() as $r) {
                $schedule = new Schedule();
                $schedule->ID = $r['ID'];
                $schedule->name = $r['Name'];
                $schedule->description = $r['Description'];
                $schedule->file = $r['File'];
                $schedule->date = $r['Date'];

                array_push($schedules, $schedule);
            }

            return $schedules;
        } catch (Exception $th) {
            throw $th;
        }
    }

    public static function GetSchedule($ID)
    {
        try {
            $query = "SELECT `ID`, `Name`, `Description`, `File`, `Date` FROM `schedule` 
                      WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $ID, PDO::PARAM_INT);
            $st->execute();
    
            $r = $st->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $schedule = new Schedule();
                $schedule->ID = $r['ID'];
                $schedule->name = $r['Name'];
                $schedule->description = $r['Description'];
                $schedule->file = $r['File'];
                $schedule->date = $r['Date'];
    
                return $schedule;
            }
            return null;
        } catch (Exception $th) {
            throw $th;
        }
    }  

    public function Update()
    {
        try {
            $query = "UPDATE `schedule` SET `Name`=:name, `Description`=:description, `File`=:file, `Date`=:date
                      WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
            $st->bindValue(":name", $this->name, PDO::PARAM_STR);
            $st->bindValue(":description", $this->description, PDO::PARAM_STR);
            $st->bindValue(":file", $this->file, PDO::PARAM_STR);
            $st->bindValue(":date", $this->date, PDO::PARAM_STR);
            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function Delete($ID) {
        try {
            $query = "DELETE FROM `schedule` WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $ID, PDO::PARAM_INT);
            $st->execute();
        } catch(Exception $ex) {
            throw $ex;
        }
    }

    
    public static function SearchSchedule($search)
    {
        try {
            $query = "SELECT `ID`, `Name`, `Description`, `File`, `Date` FROM `schedule` 
                      WHERE `Name` LIKE :search 
                      OR `Description` LIKE :search
                      OR `File` LIKE :search
                      OR `Date` LIKE :search";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $searchParam = "%$search%";
            $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
            $st->execute();
    
            $schedules = array();
    
            foreach ($st->fetchAll() as $r) {
                $schedule = new Schedule();
                $schedule->ID = $r['ID'];
                $schedule->name = $r['Name'];
                $schedule->description = $r['Description'];
                $schedule->file = $r['File'];
                $schedule->date = $r['Date'];
    
                array_push($schedules, $schedule);
            }
    
            return $schedules;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
?>
