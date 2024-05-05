<?php
include_once('Conn.php');
class events
{
    public $ID;
    public $name;
    public $img;
    public $desc;
    public $loc;
    public $date;
    public $time;
    public $ee_id;
    public $ename;
    public $eemail;
    public $ephone;
    public $eaddress;
    public $event_name;

    public function Add()
{
    try {
        $query = "INSERT INTO `events`(`Name`, `Description`, `Location`, `Date`, `Time`) 
        VALUES(:name, :desc, :loc, :date, :time)";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);

        $st->bindValue(":name", $this->name, PDO::PARAM_STR);
        $st->bindValue(":desc", $this->desc, PDO::PARAM_STR);
        $st->bindValue(":loc", $this->loc, PDO::PARAM_STR);
        $st->bindValue(":date", $this->date, PDO::PARAM_STR);
        $st->bindValue(":time", $this->time, PDO::PARAM_STR);

        $st->execute();
        return $conn->lastInsertId();
    } catch (Exception $e) {
        throw $e;
    }
}

public function UpdateImage()
{
    try {
        $query = "UPDATE `events` SET  `Image`=:eimage 
                WHERE ID=:ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":eimage", $this->img, PDO::PARAM_STR);
        $st->bindValue(":ID", $this->ID, PDO::PARAM_STR);
        $st->execute();
    } catch (Exception $e) {
        throw $e;
    }
}

public static function GetEvents()
{
    try {
        $query = "SELECT `ID`, `Name`, `Image`, `Description`, `Location`, `Date`, `Time` FROM `events`";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $events = array();

        foreach ($result->fetchAll() as $r) {
            $event = new events();
            $event->ID = $r['ID'];
            $event->name = $r['Name'];
            $event->img = $r['Image']; 
            $event->desc = $r['Description'];
            $event->loc = $r['Location'];
            $event->date = $r['Date'];
            $event->time = $r['Time'];

            array_push($events, $event);
        }

        return $events;
    } catch (Exception $th) {
        throw $th;
    }

}

public function Update()
    {
        try {
            $query = "UPDATE `events` SET `Name`=:name, `Description`=:description, `Location`=:location,
            `Date`=:date, `Time`=:time WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
            $st->bindValue(":name", $this->name, PDO::PARAM_STR);
            $st->bindValue(":description", $this->desc, PDO::PARAM_STR);
            $st->bindValue(":location", $this->loc, PDO::PARAM_STR);
            $st->bindValue(":date", $this->date, PDO::PARAM_STR);
            $st->bindValue(":time", $this->time, PDO::PARAM_STR);

            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public static function GetEvent($ID)
    {
        try {
            $query = "SELECT `ID`, `Name`, `Image`, `Description`, `Location`, `Date`, `Time` 
                      FROM `events` WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $ID, PDO::PARAM_INT);
            $st->execute();
    
            $r = $st->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $event = new events();
                $event->ID = $r['ID'];
                $event->name = $r['Name'];
                $event->img = $r['Image'];
                $event->desc = $r['Description'];
                $event->loc = $r['Location'];
                $event->date = $r['Date'];
                $event->time = $r['Time'];
    
                return $event;
            }
            return null;
        } catch (Exception $th) {
            throw $th;
        }
    }
    
    
public static function Delete($ID) {
    try{
    $query="DELETE FROM `events` where `ID` = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$ID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}

public static function GetLastAddedEvents()
{
    try {
        $query = "SELECT `ID`, `Name`, `Image`, `Description`, `Date` FROM `events` ORDER BY `ID` DESC LIMIT 3";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $events = array();

        foreach ($result->fetchAll() as $r) {
            $event = new events();
            $event->ID = $r['ID'];
            $event->name = $r['Name'];
            $event->img = $r['Image'];
            $event->date = $r['Date'];
            
            // Truncate description to 30 words
            $description = $r['Description'];
            $words = explode(' ', $description);
            $truncatedDescription = implode(' ', array_slice($words, 0, 30));
            $event->desc = $truncatedDescription;

            array_push($events, $event);
        }

        return $events;
    } catch (Exception $th) {
        throw $th;
    }
}
public static function GetLastAddedEventsDash()
{
    try {
        $query = "SELECT `ID`, `Name`, `Image`, `Date` FROM `events` ORDER BY `Date` ASC LIMIT 5";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $events = array();

        foreach ($result->fetchAll() as $r) {
            $event = new events();
            $event->ID = $r['ID'];
            $event->name = $r['Name'];
            $event->img = $r['Image'];
            $event->date = $r['Date'];

            array_push($events, $event);
        }

        return $events;
    } catch (Exception $th) {
        throw $th;
    }
}

public static function SearchEvents($search)
{
    try {
        $query = "SELECT `ID`, `Name`, `Image`, `Description`, `Location`, `Date`, `Time`
                  FROM `events` 
                  WHERE `Name` LIKE :search 
                     OR `Description` LIKE :search 
                     OR `Location` LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $events = array();

        foreach ($st->fetchAll() as $r) {
            $event = new events();
            $event->ID = $r['ID'];
            $event->name = $r['Name'];
            $event->img = $r['Image'];
            $event->desc = $r['Description'];
            $event->loc = $r['Location'];
            $event->date = $r['Date'];
            $event->time = $r['Time'];

            array_push($events, $event);
        }

        return $events;
    } catch (Exception $ex) {
        throw $ex;
    }
}

//------------------------------------------Enrollment----------------------------------------------------------------------

public function AddEnrollment($event_id)
{
    try {
        $this->ee_id = $event_id; 

        $query = "INSERT INTO `enrollment`(`e_id`, `name`, `email`, `phone`, `address`) 
                  VALUES (:eid, :name, :email, :phone, :address)";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);

        $st->bindValue(":eid", $this->ee_id, PDO::PARAM_INT); 
        $st->bindValue(":name", $this->ename, PDO::PARAM_STR);
        $st->bindValue(":email", $this->eemail, PDO::PARAM_STR);
        $st->bindValue(":phone", $this->ephone, PDO::PARAM_INT);
        $st->bindValue(":address", $this->eaddress, PDO::PARAM_STR);
        
        $st->execute();
        return $conn->lastInsertId();
    } catch (Exception $e) {
        throw $e;
    }
}
public function isUserEnrolled($email, $event_id) {
    try {
        $conn = Conn::GetConnection();
        $query = "SELECT COUNT(*) FROM `enrollment` WHERE `email` = :email AND `e_id` = :event_id";
        $st = $conn->prepare($query);
        $st->bindValue(":email", $email, PDO::PARAM_STR);
        $st->bindValue(":event_id", $event_id, PDO::PARAM_INT);
        $st->execute();
        $result = $st->fetchColumn();
        return $result > 0; // If count is greater than 0, user is enrolled
    } catch (Exception $e) {
        throw $e;
    }
}
public static function GetEnrolled()
{
    try {
        $query = "SELECT e.ID AS enrollment_id, e.e_id, e.name, e.email, e.phone, e.address, ev.Name AS event_name 
                  FROM `enrollment` e
                  INNER JOIN `events` ev ON e.e_id = ev.ID";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $enrollments = array();

        foreach ($result->fetchAll() as $r) {
            $enrollment = new events();
            $enrollment->ID = $r['enrollment_id'];
            $enrollment->ee_id = $r["e_id"];
            $enrollment->ename = $r['name'];
            $enrollment->eemail = $r['email']; 
            $enrollment->ephone = $r['phone']; 
            $enrollment->eaddress = $r['address'];
            $enrollment->event_name = $r['event_name']; 

            array_push($enrollments, $enrollment);
        }

        return $enrollments;
    } catch (Exception $th) {
        throw $th;
    }

}

public static function DeleteEnrolled($ID) {
    try{
    $query="DELETE FROM `enrollment` where `ID` = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$ID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}
public static function SearchEnrollments($search)
{
    try {
        $query = "SELECT e.ID AS enrollment_id, e.e_id, e.name, e.email, e.phone, e.address, ev.Name AS event_name 
                  FROM `enrollment` 
                  INNER JOIN `events` ev ON e.e_id = ev.ID
                  WHERE e.name LIKE :search 
                     OR e.email LIKE :search 
                     OR e.phone LIKE :search 
                     OR e.address LIKE :search 
                     OR ev.Name LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $enrollments = array();

        foreach ($st->fetchAll() as $r) {
            $enrollment = new events();
            $enrollment->ID = $r['enrollment_id'];
            $enrollment->ee_id = $r["e_id"];
            $enrollment->ename = $r['name'];
            $enrollment->eemail = $r['email']; 
            $enrollment->ephone = $r['phone']; 
            $enrollment->eaddress = $r['address'];
            $enrollment->event_name = $r['event_name']; 

            array_push($enrollments, $enrollment);
        }

        return $enrollments;
    } catch (Exception $ex) {
        throw $ex;
    }
}


}