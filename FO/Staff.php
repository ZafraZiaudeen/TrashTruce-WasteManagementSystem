<?php 
include_once('Conn.php');

class staff{
    public $ID;
    public $fname;
    public $lname;
    public $position;
    public $dob;
    public $address;
    public $email;
    public $phone;
    public $password;
    public $date;

    public function Add(){
        try{
            $query = "INSERT INTO `staff`(`First_Name`, `Last_Name`,`position`, `DOB`, `Email`, `Password`, `Contact`, `Address`, `Date`)
                      VALUES (:fname, :lname,:position, :dob, :email, :password, :phone, :address, :dateofReg)";
            
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            
            $st->bindValue(":fname", $this->fname, PDO::PARAM_STR);
            $st->bindValue(":lname", $this->lname, PDO::PARAM_STR);
            $st->bindValue(":position", $this->position, PDO::PARAM_STR);
            $st->bindValue(":dob", $this->dob, PDO::PARAM_STR);           
            $st->bindValue(":email", $this->email, PDO::PARAM_STR);
            $st->bindValue(":password", $this->password, PDO::PARAM_STR);
            $st->bindValue(":phone", $this->phone, PDO::PARAM_STR);
            $st->bindValue(":address", $this->address, PDO::PARAM_STR);
            $st->bindValue(":dateofReg", $this->date, PDO::PARAM_STR);
            
            $st->execute();
            
            return $conn->lastInsertId();
        } catch(Exception $e) {
            throw $e;
        }
    }
    
    public static function GetStaffs()
    {
        try {
            $query = "SELECT `ID`, `First_Name`, `Last_Name`,`position`, `DOB`, `Email`, `Password`, `Contact`, `Address`, `Date` FROM `staff`";
            $conn = Conn::GetConnection();
            $result = $conn->query($query);
            $staffs = array();
    
            foreach ($result->fetchAll() as $r) {
                $staff = new staff();
                $staff->ID = $r['ID'];
                $staff->fname = $r['First_Name'];
                $staff->lname = $r['Last_Name'];
                $staff->position = $r['position'];
                $staff->dob = $r['DOB'];
                $staff->address = $r['Address'];
                $staff->email = $r['Email'];
                $staff->phone = $r['Contact'];
                $staff->password = $r['Password'];
                $staff->date = $r['Date'];
    
                array_push($staffs, $staff);
            }
    
            return $staffs;
        } catch (Exception $th) {
            throw $th;
        }
    }
    

    public static function GetStaffDetail($ID)
    {
        try {
            $query = "SELECT `ID`, `First_Name`, `Last_Name`,`position`, `DOB`, `Address`, `Email`, `Contact`, `Password` 
            FROM `staff` WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $ID, PDO::PARAM_INT);
            $st->execute();
    
            $r = $st->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $staff = new staff();
                $staff->ID = $r['ID'];
                $staff->fname = $r['First_Name'];
                $staff->lname = $r['Last_Name'];
                $staff->position=$r['position'];
                $staff->dob = $r['DOB'];
                $staff->address = $r['Address'];
                $staff->email = $r['Email'];
                $staff->phone = $r['Contact'];
                $staff->password = $r['Password'];
    
                return $staff;
            }
            return null;
        } catch (Exception $th) {
            throw $th;
        }
    }
    
    public function Update()
    {
        try {
            $query = "UPDATE `staff` SET `First_Name`=:fname, `Last_Name`=:lname,`position`=:position, `DOB`=:dob, `Email`=:email, `Contact`=:contact, `Address`=:address, `Date`=:date WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
            $st->bindValue(":fname", $this->fname, PDO::PARAM_STR);
            $st->bindValue(":lname", $this->lname, PDO::PARAM_STR);
            $st->bindValue(":position", $this->position, PDO::PARAM_STR);
            $st->bindValue(":dob", $this->dob, PDO::PARAM_STR);
            $st->bindValue(":address", $this->address, PDO::PARAM_STR);
            $st->bindValue(":email", $this->email, PDO::PARAM_STR);
            $st->bindValue(":contact", $this->phone, PDO::PARAM_STR);
            $st->bindValue(":date", $this->date, PDO::PARAM_STR);
    
            $st->execute();
        } catch (Exception $ex) {
            error_log("Error updating user: " . $ex->getMessage());
            throw $ex;
        }
    }
    

    public function UpdatePassword()
    {
        try {
            $query = "UPDATE `staff` SET `Password` = :password WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->ID, PDO::PARAM_INT);
            $st->bindValue(":password", $this->password, PDO::PARAM_STR);
            $st->execute();
        } catch (Exception $ex) {
            echo "Error updating password: " . $ex->getMessage(); 
            throw $ex; 
        }
    }
    

public static function GetStaffByEmail($email) {
    try {
        $query = "SELECT `ID`,`Email`, `Password` FROM `staff` WHERE Email=:email";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":email", $email, PDO::PARAM_STR);
        $st->execute();

        $result = $st->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $staff = new staff();
            $staff->ID = $result['ID'];
            $staff->email = $result['Email'];
            $staff->password = $result['Password'];
            return $staff;
        }

        return null; 
    } catch (Exception $th) {
        throw $th;
    }
}


public static function Delete($ID) {
    try{
    $query="DELETE FROM `staff` where ID=:ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$ID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}

public static function GetTotalStaffCount()
{
    try {
        $query = "SELECT COUNT(*) as staff_count FROM `staff`";
        $conn = Conn::GetConnection();
        $st = $conn->query($query);
        $result = $st->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['staff_count'])) {
            return $result['staff_count'];
        }

        return 0;
    } catch (Exception $th) {
        throw $th;
    }
}
public static function SearchStaff($search)
{
    try {
        $query = "SELECT `ID`, `First_Name`, `Last_Name`, `position`, `DOB`, `Email`, `Contact`, `Address`, `Date` FROM `staff` 
                  WHERE `First_Name` LIKE :search
                  OR `Last_Name` LIKE :search
                  OR `position` LIKE :search
                  OR `DOB` LIKE :search
                  OR `Email` LIKE :search
                  OR `Contact` LIKE :search
                  OR `Address` LIKE :search
                  OR `Date` LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $staffs = array();

        foreach ($st->fetchAll() as $r) {
            $staff = new staff();
            $staff->ID = $r['ID'];
            $staff->fname = $r['First_Name'];
            $staff->lname = $r['Last_Name'];
            $staff->position = $r['position'];
            $staff->dob = $r['DOB'];
            $staff->address = $r['Address'];
            $staff->email = $r['Email'];
            $staff->phone = $r['Contact'];
            $staff->date = $r['Date'];

            array_push($staffs, $staff);
        }

        return $staffs;
    } catch (Exception $ex) {
        throw $ex;
    }
}

}
?>