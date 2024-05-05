<?php
include_once('Conn.php');
class Recycle
{
    public $gID;
    public $gname;
    public $gfile;
    public $gdate;
    public $pID;
    public $pname;
    public $pdesc;
    public $pvid;
    public $bid;
    public $bname;
    public $bcat;
    public $bdesc;
    public $bimg;
    
//------------------------------recycling Guide---------------------------------------
    public function AddGuide()
{
    try {
        $query = "INSERT INTO `recycling_guide`( `Name`, `Gfile`, `Date`) 
        VALUES(:gname, :gfile, :gdate)";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);

        $st->bindValue(":gname", $this->gname, PDO::PARAM_STR);
        $st->bindValue(":gfile", $this->gfile, PDO::PARAM_STR);
        $st->bindValue(":gdate", $this->gdate, PDO::PARAM_STR);


        $st->execute();
        return $conn->lastInsertId();
    } catch (Exception $e) {
        throw $e;
    }
}

public static function GetGuides()
{
    try {
        $query = "SELECT `ID`, `Name`, `Gfile`, `Date` FROM `recycling_guide`";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $guides = array();

        foreach ($result->fetchAll() as $r) {
            $guide = new Recycle();
            $guide->gID= $r['ID'];
            $guide->gname = $r['Name'];
            $guide->gfile = $r['Gfile'];
            $guide->gdate = $r['Date'];

            array_push($guides, $guide);
        }

        return $guides;
    } catch (Exception $th) {
        throw $th;
    }
}

public function Update()
    {
        try {
            $query = "UPDATE `recycling_guide` SET `Name`=:name,`Gfile`=:gfile,`Date`=:date 
            WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->gID, PDO::PARAM_INT);
            $st->bindValue(":name", $this->gname, PDO::PARAM_STR);
            $st->bindValue(":gfile", $this->gfile,PDO::PARAM_STR);
            $st->bindValue(":date",$this->gdate,PDO::PARAM_STR);
            $st->execute();

            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function GetGuide($gID)
    {
        try {
            $query = "SELECT `ID`, `Name`, `Gfile`, `Date` FROM `recycling_guide` 
                      WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $gID, PDO::PARAM_INT);
            $st->execute();
    
            $r = $st->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $guide = new Recycle();
                $guide->gID = $r['ID'];
                $guide->gname = $r['Name'];
                $guide->gfile = $r['Gfile'];
                $guide->gdate = $r['Date'];
    
                return $guide;
            }
            return null;
        } catch (Exception $th) {
            throw $th;
        }
    }  
    
public static function Delete($gID) {
    try{
    $query="DELETE FROM `recycling_guide` where `ID` = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$gID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}

public static function GetLastAddedGuide() {
    try {
        $query = "SELECT `ID`, `Name`, `Gfile`, `Date` FROM `recycling_guide` ORDER BY `ID` DESC LIMIT 1";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->execute();

        $r = $st->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $guide = new Recycle();
            $guide->gID = $r['ID'];
            $guide->gname = $r['Name'];
            $guide->gfile = $r['Gfile'];
            $guide->gdate = $r['Date'];

            return $guide;
        }
        return null;
    } catch (Exception $th) {
        throw $th;
    }
}

public static function SearchGuide($search)
{
    try {
        $query = "SELECT `ID`, `Name`, `Gfile`, `Date` 
                  FROM `recycling_guide` 
                  WHERE `Name` LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $guides = array();

        foreach ($st->fetchAll() as $r) {
            $guide = new Recycle();
            $guide->gID = $r['ID'];
            $guide->gname = $r['Name'];
            $guide->gfile = $r['Gfile'];
            $guide->gdate = $r['Date'];

            array_push($guides, $guide);
        }

        return $guides;
    } catch (Exception $ex) {
        throw $ex;
    }
}

//----------------------------------------Process-----------------------------------------------------------------

public function AddProcess()
{
    try {
        $query = "INSERT INTO `recycling_process`( `Process_Name`, `Process_Des`, `Process_Vid`) 
        VALUES(:pname, :pdes, :pvid)";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);

        $st->bindValue(":pname", $this->pname, PDO::PARAM_STR);
        $st->bindValue(":pdes", $this->pdesc, PDO::PARAM_STR);
        $st->bindValue(":pvid", $this->pvid, PDO::PARAM_STR);


        $st->execute();
        return $conn->lastInsertId();
    } catch (Exception $e) {
        throw $e;
    }
}

public static function GetProcesses()
{
    try {
        $query = "SELECT `ID`, `Process_Name`, `Process_Des`, `Process_Vid` FROM `recycling_process`";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $Processes = array();

        foreach ($result->fetchAll() as $r) {
            $process = new Recycle();
            $process->pID= $r['ID'];
            $process->pname = $r['Process_Name'];
            $process->pdesc = $r['Process_Des'];
            $process->pvid = $r['Process_Vid'];

            array_push($Processes, $process);
        }

        return $Processes;
    } catch (Exception $th) {
        throw $th;
    }
}

public static function GetProcess($pID)
    {
        try {
            $query = "SELECT `ID`, `Process_Name`, `Process_Des`, `Process_Vid` FROM `recycling_process` 
                      WHERE `ID` = :ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $pID, PDO::PARAM_INT);
            $st->execute();
    
            $r = $st->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $process = new Recycle();
                $process->pID = $r['ID'];
                $process->pname = $r['Process_Name'];
                $process->pdesc = $r['Process_Des'];
                $process->pvid = $r['Process_Vid'];
    
                return $process;
            }
            return null;
        } catch (Exception $th) {
            throw $th;
        }
    }  

public function UpdateProcess()
    {
        try {
            $query="UPDATE `recycling_process` SET `Process_Name`=:name,`Process_Des`=:desc,`Process_Vid`=:vid 
            WHERE `ID` = :ID";
            
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->pID, PDO::PARAM_INT);
            $st->bindValue(":name", $this->pname, PDO::PARAM_STR);
            $st->bindValue(":desc", $this->pdesc,PDO::PARAM_STR);
            $st->bindValue(":vid",$this->pvid,PDO::PARAM_STR);
            $st->execute();

            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public static function DeleteProcess($pID) {
        try{
        $query="DELETE FROM `recycling_process` WHERE `ID` = :ID";
            $conn=Conn::GetConnection();
            $st=$conn->prepare($query);
            $st->bindValue(":ID",$pID,PDO::PARAM_INT);
            $st->execute();
        }
        catch(Exception $ex){
            throw $ex;
        }
    }
    
    public static function DeleteAllProcesses() {
        try {
            $query = "DELETE FROM `recycling_process`"; 
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    
    public static function SearchProcess($search)
    {
        try {
            $query = "SELECT `ID`, `Process_Name`, `Process_Des`, `Process_Vid` 
                      FROM `recycling_process` 
                      WHERE `Process_Name` LIKE :search OR `Process_Des` LIKE :search";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $searchParam = "%$search%";
            $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
            $st->execute();
    
            $processes = array();
    
            foreach ($st->fetchAll() as $r) {
                $process = new Recycle();
                $process->pID = $r['ID'];
                $process->pname = $r['Process_Name'];
                $process->pdesc = $r['Process_Des'];
                $process->pvid = $r['Process_Vid'];
    
                array_push($processes, $process);
            }
    
            return $processes;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    //--------------------Bins-----------------------------------
    public function AddBin()
    {
        try {
            $query = "INSERT INTO `recycling_bin`(`Name`, `Category`, `Description`)
            VALUES(:bname,:bcat, :bdes)";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
    
            $st->bindValue(":bname", $this->bname, PDO::PARAM_STR);
            $st->bindValue(":bcat", $this->bcat, PDO::PARAM_STR);
            $st->bindValue(":bdes", $this->bdesc, PDO::PARAM_STR); 
    
    
            $st->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            throw $e;
        }
    }

    
public function UpdateBImage()
{
    try {
        $query = "UPDATE `recycling_bin` SET  `Image`=:bimage 
                WHERE ID=:ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":bimage", $this->bimg, PDO::PARAM_STR);
        $st->bindValue(":ID", $this->bid, PDO::PARAM_STR);
        $st->execute();
    } catch (Exception $e) {
        throw $e;
    }
}

public static function GetBinsByCategory($category)
{
    try {
        $query = "SELECT `ID`, `Name`, `Category`, `Description`, `Image` FROM `recycling_bin` WHERE `Category` = :category";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":category", $category, PDO::PARAM_STR);
        $st->execute();

        $bins = array();

        foreach ($st->fetchAll() as $r) {
            $bin = new Recycle();
            $bin->bid = $r['ID'];
            $bin->bname = $r['Name'];
            $bin->bcat = $r['Category'];
            $bin->bdesc = $r['Description'];
            $bin->bimg = $r['Image'];

            array_push($bins, $bin);
        }

        return $bins;
    } catch (Exception $ex) {
        throw $ex;
    }
}

public static function GetBins()
{
    try {
        $query = "SELECT `ID`, `Name`, `Category`, `Description`, `Image` FROM `recycling_bin`";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $Bins = array();

        foreach ($result->fetchAll() as $r) {
            $Bin = new Recycle();
            $Bin->bid= $r['ID'];
            $Bin->bname = $r['Name'];
            $Bin->bcat = $r['Category'];
            $Bin->bdesc = $r['Description'];
            $Bin->bimg=$r['Image'];

            array_push($Bins, $Bin);
        }

        return $Bins;
    } catch (Exception $th) {
        throw $th;
    }
}

public function UpdateBin()
    {
        try {
            $query="UPDATE `recycling_bin` SET `Name`=:bname,`Category`=:bcategory,`Description`=:bdesc 
        WHERE `ID` = :ID";

            
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $this->bid, PDO::PARAM_INT);
            $st->bindValue(":bname", $this->bname, PDO::PARAM_STR);
            $st->bindValue(":bcategory", $this->bcat,PDO::PARAM_STR);
            $st->bindValue(":bdesc",$this->bdesc,PDO::PARAM_STR);
            $st->execute();

        } catch (Exception $ex) {
            throw $ex;
        }
    } 

    
public static function GetBin($bID)
{
    try {
        $query = "SELECT `ID`, `Name`, `Category`, `Description` FROM `recycling_bin` 
                  WHERE `ID` = :ID";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":ID", $bID, PDO::PARAM_INT);
        $st->execute();

        $r = $st->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $bin = new Recycle();
            $bin->bid = $r['ID'];
            $bin->bname = $r['Name'];
            $bin->bcat = $r['Category'];
            $bin->bdesc = $r['Description'];

            return $bin;
        }
        return null;
    } catch (Exception $th) {
        throw $th;
    }
}  
public static function DeleteBin($bID) {
    try{
    $query="DELETE FROM `recycling_bin` WHERE `ID` = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$bID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}

public static function SearchBins($search)
{
    try {
        $query = "SELECT `ID`, `Name`, `Category`, `Description`, `Image` 
                  FROM `recycling_bin` 
                  WHERE `Name` LIKE :search 
                     OR `Category` LIKE :search 
                     OR `Description` LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $bins = array();

        foreach ($st->fetchAll() as $r) {
            $bin = new Recycle();
            $bin->bid = $r['ID'];
            $bin->bname = $r['Name'];
            $bin->bcat = $r['Category'];
            $bin->bdesc = $r['Description'];
            $bin->bimg = $r['Image'];

            array_push($bins, $bin);
        }

        return $bins;
    } catch (Exception $ex) {
        throw $ex;
    }
}


}