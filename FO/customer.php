<?php
include_once('Conn.php');
class Customer
{
    public $ID;
    public $fname;
    public $lname;
    public $email;
    public $phone;
    public $address;
    public $password;
    public $date;
    public $approval = "Pending Approval";

    public function Add()
    {
        try {
            $query = "INSERT INTO `customer`(`Fname`, `Lname`, `Email`, `Phone`, `address`, `Password`, `date`, `approval`)
             VALUES (:fname, :lname, :email, :phone, :address, :password, :date, :approval)";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);

            $st->bindValue(":fname", $this->fname, PDO::PARAM_STR);
            $st->bindValue(":lname", $this->lname, PDO::PARAM_STR);
            $st->bindValue(":email", $this->email, PDO::PARAM_STR);
            $st->bindValue(":phone", $this->phone, PDO::PARAM_INT);
            $st->bindValue(":address", $this->address, PDO::PARAM_STR);
            $st->bindValue(":password", $this->password, PDO::PARAM_STR);
            $st->bindValue(":date", $this->date, PDO::PARAM_STR); 
            $st->bindValue(":approval",$this->approval, PDO::PARAM_STR);
            $st->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function EmailExists($email)
    {
        try {
            $query = "SELECT COUNT(*) FROM `customer` WHERE `Email` = :email";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":email", $email, PDO::PARAM_STR);
            $st->execute();
            $count = $st->fetchColumn();
            return $count > 0;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function GetUserDetails()
    {
        try{
            $query="SELECT `ID`, `Fname`, `Lname`, `Email`, `Phone`, `address`, `Password`, `date`, `approval` FROM `customer`";
            $conn=Conn::GetConnection();
            $result= $conn->query($query);
            $users=array();
    
            foreach($result->fetchAll() as $r){
                $user= new Customer();
                $user->ID=$r['ID'];
                $user->fname=$r['Fname'];
                $user->lname=$r['Lname'];
                $user->email=$r['Email'];
                $user->phone=$r['Phone'];
                $user->address=$r['address'];
                $user->password=$r['Password'];
                $user->date=$r['date'];
                $user->approval=$r['approval'];

                array_push($users, $user);
            }
            return $users;
        }catch (Exception $th){
            throw $th;
        }
        
    }

    public function Update()
    {
        try {
            $query = "UPDATE `customer` SET `Fname`=:Fname, `Lname`=:Lname, `Email`=:Email,
            `Phone`=:Phone, `address`=:address, `date`=:date, `approval`=:approval WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->ID, PDO::PARAM_INT); 
            $st->bindValue(":Fname", $this->fname, PDO::PARAM_STR); 
            $st->bindValue(":Lname", $this->lname, PDO::PARAM_STR); 
            $st->bindValue(":Email", $this->email, PDO::PARAM_STR);
            $st->bindValue(":Phone", $this->phone, PDO::PARAM_STR); 
            $st->bindValue(":address", $this->address, PDO::PARAM_STR);
            $st->bindValue(":date", $this->date, PDO::PARAM_STR);
            $st->bindValue(":approval", $this->approval, PDO::PARAM_STR);
            $st->execute();
        } catch (Exception $ex) {
            error_log("Error updating user: " . $ex->getMessage());
            throw $ex;
        }
    }

    public static function GetUserByEmail($email)
{
    try {
        $query = "SELECT `ID`, `Fname`, `Lname`, `Email`, `Phone`, `address`, `Password`, `date`, `approval` FROM `customer` WHERE `Email` = :Email";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":Email", $email, PDO::PARAM_STR);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new Customer();
            $user->ID = $result['ID'];
            $user->email = $result['Email'];
            $user->password = $result['Password'];
            $user->approval = $result['approval'];
            return $user;
        } 
            return null; 
        
    } catch (Exception $e) {
        throw $e;
    }
}


public static function Delete($ID) {
    try{
    $query="DELETE FROM `customer` where `ID` = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$ID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}

public static function GetUserDetail($userID)
{
    try {
        $query = "SELECT `ID`, `Fname`, `Lname`, `Email`, `Phone`, `address`, `Password`, `date`, `approval` FROM `customer` WHERE `ID` = :ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $userID, PDO::PARAM_INT);
        $st->execute();

        $result = $st->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $customer = new Customer();
            $customer->ID = $result['ID'];
            $customer->fname = $result['Fname'];
            $customer->lname = $result['Lname'];
            $customer->email = $result['Email'];
            $customer->phone = $result['Phone'];
            $customer->address = $result['address'];
            $customer->approval = $result['approval'];

            return $customer;
        }

        return null;
    } catch (Exception $th) {
        throw $th;
    }
}
public static function GetTotalCustomerCount() {
    try {
        $query = "SELECT COUNT(*) AS total_customers FROM `customer`";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        return $row['total_customers'];
    } catch (Exception $ex) {
        throw $ex;
    }
}

public static function DeleteAllCustomer() {
    try {
        $query = "DELETE FROM `customer`"; 
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->execute();
    } catch (Exception $ex) {
        throw $ex;
    }
}

public static function SearchCustomer($search)
{
    try {
        $query = "SELECT `ID`, `Fname`, `Lname`, `Email`, `Phone`, `address`, `Password`, `date`, `approval`
                  FROM `customer` 
                  WHERE `Fname` LIKE :search 
                     OR `Lname` LIKE :search 
                     OR `Email` LIKE :search 
                     OR `Phone` LIKE :search 
                     OR `address` LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $customers = array();

        foreach ($st->fetchAll() as $r) {
            $customer = new Customer();
            $customer->ID = $r['ID'];
            $customer->fname = $r['Fname'];
            $customer->lname = $r['Lname'];
            $customer->email = $r['Email'];
            $customer->phone = $r['Phone'];
            $customer->address = $r['address'];
            $customer->password = $r['Password'];
            $customer->date = $r['date'];
            $customer->approval = $r['approval'];

            array_push($customers, $customer);
        }

        return $customers;
    } catch (Exception $ex) {
        throw $ex;
    }
}


}

?>
