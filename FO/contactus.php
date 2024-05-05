<?php
include_once('Conn.php');

class ContactUs
{
    public $ID;
    public $name;
    public $phone;
    public $email;
    public $message;
    public $date;
    
    public function AddContactUs()
    {
        try {
            $query = "INSERT INTO `contactus` (`Name`, `Phone`, `Email`, `Message`,`date`) VALUES (:name, :phone, :email, :message,:date)";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);

            $st->bindValue(":name", $this->name, PDO::PARAM_STR);
            $st->bindValue(":phone", $this->phone, PDO::PARAM_STR);
            $st->bindValue(":email", $this->email, PDO::PARAM_STR);
            $st->bindValue(":message", $this->message, PDO::PARAM_STR);
            $st->bindValue(":date", $this->date, PDO::PARAM_STR);

            $st->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function GetContactUs()
    {
        try {
            $query = "SELECT `ID`, `Name`, `Phone`, `Email`, `Message`, `Date` FROM `contactus`";
            $conn = Conn::GetConnection();
            $stmt = $conn->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $AllContactus = array();
    
            foreach ($result as $r) {
                $contactus = new ContactUs();
                $contactus->ID = $r['ID'];
                $contactus->name = $r['Name'];
                $contactus->phone = $r['Phone'];
                $contactus->email = $r['Email'];
                $contactus->message = $r['Message'];
                $contactus->date = $r['Date'];
    
                array_push($AllContactus, $contactus); 
            }
            return $AllContactus;
        } catch (Exception $th) {
            throw $th;
        }
    }
    
    public static function Delete($ID) {
        try{
        $query="DELETE FROM `contactus` where `ID` = :ID";
            $conn=Conn::GetConnection();
            $st=$conn->prepare($query);
            $st->bindValue(":ID",$ID,PDO::PARAM_INT);
            $st->execute();
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

}
?>
