<?php
include_once('Conn.php');
class admin
{
    // Properties
    public $ID;
    public $email;
    public $password;
    public $fullname;
    public $image;
    public $about;
    public $job;
    public $phone;
    public $address;

    // Methods
    // Add a new admin
    public function Add()
    {
        try {
            $query = "INSERT INTO `admin`(`Email`, `password`) VALUES (:email, :password)";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);

            $st->bindValue(":email", $this->email, PDO::PARAM_STR);
            $st->bindValue(":password", $this->password, PDO::PARAM_STR);
            $st->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Get admin by ID
    public static function GetAdmin($ID)
    {
        try {
            $query = "SELECT `ID`, `Full_Name`, `Image`, `About`, `Job`, `Address`, `Phone`, `Email`, `password` FROM `admin` WHERE `ID` = :ID ";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $ID, PDO::PARAM_INT);
            $st->execute();

            $r = $st->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $admin = new admin();
                $admin->ID = $r['ID'];
                $admin->fullname = $r['Full_Name'];
                $admin->image = $r['Image'];
                $admin->about = $r['About'];
                $admin->job = $r['Job'];
                $admin->address = $r['Address'];
                $admin->phone = $r['Phone'];
                $admin->email = $r['Email'];
                $admin->password = $r['password'];
                return $admin;
            }
            return null;
        } catch (Exception $th) {
            throw $th;
        }
    }

    // Update profile image
    public function UpdateImage()
    {
        try {
            $query = "UPDATE `admin` SET `Image`=:image WHERE ID=:ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":image", $this->image, PDO::PARAM_STR);
            $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
            $st->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Update admin profile information
    public function UpdateAdmin()
    {
        try {
            $query = "UPDATE `admin` SET `Full_Name`=:fname, `About`=:about, `Job`=:job, `Address`=:address, `Phone`=:phone, `Email`=:email WHERE `ID`=:ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
            $st->bindValue(":fname", $this->fullname, PDO::PARAM_STR);
            $st->bindValue(":about", $this->about, PDO::PARAM_STR);
            $st->bindValue(":job", $this->job, PDO::PARAM_STR);
            $st->bindValue(":address", $this->address, PDO::PARAM_STR);
            $st->bindValue(":phone", $this->phone, PDO::PARAM_STR);
            $st->bindValue(":email", $this->email, PDO::PARAM_STR);
            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Update admin password
    public function UpdatePassword()
    {
        try {
            $query = "UPDATE `admin` SET `password`=:password WHERE `ID`=:ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
            $st->bindValue(":password", $this->password, PDO::PARAM_STR);
            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Get all admins
    public static function GetAdmins()
    {
        try {
            $query = "SELECT `ID`, `Full_Name`, `Image`, `About`, `Job`, `Address`, `Phone`, `Email`, `password` FROM `admin`";
            $conn = Conn::GetConnection();
            $result = $conn->query($query);
            $admins = array();

            foreach ($result->fetchAll() as $r) {
                $admin = new admin();
                $admin->ID = $r['ID'];
                $admin->fullname = $r['Full_Name'];
                $admin->image = $r['Image'];
                $admin->about = $r['About'];
                $admin->job = $r['Job'];
                $admin->address = $r['Address'];
                $admin->phone = $r['Phone'];
                $admin->email = $r['Email'];
                $admin->password = $r['password'];

                array_push($admins, $admin);
            }

            return $admins;
        } catch (Exception $th) {
            throw $th;
        }
    }

    public static function GetadminByEmail($email)
    {
        try {
            $query = "SELECT `ID`, `Full_Name`, `Image`, `About`, `Job`, `Address`, `Phone`, `Email`, `password` FROM `admin` WHERE `Email` = :Email";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":Email", $email, PDO::PARAM_STR);
            $st->execute();
            $result = $st->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $admin= new admin();
                $admin->ID = $result['ID'];
                $admin->email = $result['Email'];
                $admin->password = $result['password'];
                return $admin;
            } 
                return null; 
            
        } catch (Exception $e) {
            throw $e;
        }
    }
}
?>