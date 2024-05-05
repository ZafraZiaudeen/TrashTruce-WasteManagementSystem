<?php
include_once('Conn.php');
include_once('customer.php');

class orders{
    public $o_id;
    public $u_id;
    public $product;
    public $quantity;
    public $price;
    public $cardowner;
    public $cardno;
    public $Exp;
    public $cvv;
    public $method;
    public $status;
    public $date;
    public $user;
    public $payment;
    public $email;
    public $address;

    public function Add()
    {
        // print_r('name');
        // print_r($this->product); exit;
        try {
            $query = "INSERT INTO `orders`(`u_id`, `product`, `quantity`, `price`, `card_owner`, `card_no`, `Exp`, `cvv`, `payment_method`,`payment_status`, `status`, `date`)
                VALUES(:uid, :product, :quantity, :price, :cardowner, :cardno, :Exp, :cvv, :method, :payment, :status, :date)";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":uid", $this->u_id, PDO::PARAM_INT);
            $st->bindValue(":product", $this->product, PDO::PARAM_STR);
            $st->bindValue(":quantity", $this->quantity, PDO::PARAM_STR);
            $st->bindValue(":price", $this->price, PDO::PARAM_INT);
            $st->bindValue(":cardowner", $this->cardowner, PDO::PARAM_STR);
            $st->bindValue(":cardno", $this->cardno, PDO::PARAM_STR);
            $st->bindValue(":Exp", $this->Exp, PDO::PARAM_STR);
            $st->bindValue(":cvv", $this->cvv, PDO::PARAM_STR);
            $st->bindValue(":method", $this->method, PDO::PARAM_STR);
            $st->bindValue(":payment", $this->payment, PDO::PARAM_STR);
            $st->bindValue(":status", $this->status, PDO::PARAM_STR);
            $st->bindValue(":date", $this->date, PDO::PARAM_STR);
            $st->execute();
            return $conn->lastInsertId();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function AddOrderWithCardDetails($orderData, $cardDetails) {
        try {
            // Retrieve cart details from session
            $cart = $_SESSION["Cart"];
            $totalPrice = 0;
            
            foreach ($cart as $item) {
                $product = $item->Name; 
                $quantity = $item->Qty;
                $subtotal = $item->Price * $item->Qty;
                $totalPrice += $subtotal;
    
                // Create a new order instance for each item
                $order = new orders();
                $order->u_id = $orderData['u_id'];
                $order->product = $product;
                $order->quantity = $quantity;
                $order->price = $subtotal; 
                $order->cardowner = $cardDetails['owner'];
                $order->cardno = $cardDetails['cardNumber'];
                $order->Exp = $cardDetails['exp'];
                $order->cvv = $cardDetails['cvv'];
                $order->method = 'card'; 
                $order->payment = 'on process';
                $order->status = 'pending';
                $order->date = date('Y-m-d H:i:s'); 
    
                // Add the order to the database
                $order->Add(); 
            }
            
            // Return true if all orders were added successfully
            return true;
        } catch (Exception $e) {
            // Handle any exceptions here
            throw $e;
        }
    }
    

    public static function AddOrderWithCashOnDelivery($orderData) {
        try {
            // Retrieve cart details from session
            $cart = $_SESSION["Cart"];
            $totalPrice = 0;
            $order_ids = array(); // Store order IDs for multiple items in cart
    
            foreach ($cart as $item) {
                $product = $item->Name; 
                $quantity = $item->Qty;
                $subtotal = $item->Price * $item->Qty;
                $totalPrice += $subtotal;
    
                $order = new orders();
                $order->u_id = $orderData['u_id'];
                $order->product = $product;
                $order->quantity = $quantity;
                $order->price = $subtotal;
                $order->cardowner = ''; 
                $order->cardno = '';
                $order->Exp = '';
                $order->cvv = '';
                $order->method = 'cashon delivery'; 
                $order->payment = 'on process';
                $order->status = 'pending';
                $order->date = date('Y-m-d H:i:s');
    
                // Add the order to the database and store the order ID
                $order_id = $order->Add();
                $order_ids[] = $order_id;
            }
    
            // Return array of order IDs
            return $order_ids;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    
    public function GetOrders($userId){
        try {
            $query = "SELECT `o_id`, `u_id`, `product`, `quantity`, `price`, `card_owner`, `card_no`, `Exp`, `cvv`, `payment_method`,
             `payment_status`, `status`, `date` FROM `orders` WHERE `u_id` = :user_id";
            $conn = Conn::GetConnection();
            $result = $conn->prepare($query);
            $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $result->execute();
    
            $orders = array();
    

            foreach ($result->fetchAll() as $r) {
                $order = new orders();
                $order->o_id = $r['o_id'];
                $order->u_id = $r['u_id'];
                $order->product = $r['product'];
                $order->quantity = $r['quantity'];
                $order->price = $r['price'];
                $order->status = $r['status'];
                $order->date = $r['date'];
                $order->method = $r['payment_method'];
                $order->payment = $r['payment_status'];

                array_push($orders, $order);
            }

            return $orders;
        } catch (Exception $th) {
            throw $th;
        }
}
public static function GetOrderById($orderID){
    try {
        $query = "SELECT o.*, c.email FROM orders o
                  JOIN customer c ON o.u_id = c.ID
                  WHERE o.o_id = :order_id";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":order_id", $orderID, PDO::PARAM_INT);
        $st->execute();

        $r = $st->fetch(PDO::FETCH_ASSOC);

        if($r){
            $order = new orders(); 
            $order->o_id = $r['o_id'];
            $order->u_id = $r['u_id'];
            $order->product = $r['product'];
            $order->quantity = $r['quantity'];
            $order->price = $r['price'];
            $order->status = $r['status'];
            $order->date = $r['date'];
            $order->method = $r['payment_method'];
            $order->payment = $r['payment_status'];

            // Include customer information
            $customer = new Customer();
            $customer->ID = $r['u_id'];
            $customer->email = $r['Email'];
            $order->user = $customer;

            return $order;
        }

        return null;
    } catch (Exception $th) {
        throw $th;
    }
}
public static function GetOrdersforAll($userId = null){
    try {
        $query = "SELECT o.*, c.email, c.address FROM orders o
                  JOIN customer c ON o.u_id = c.ID";
        $conn = Conn::GetConnection();
        
        if ($userId !== null) {
            // If user ID is provided, filter orders for that specific user
            $query .= " WHERE o.u_id = :user_id";
            $result = $conn->prepare($query);
            $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        } else {
            // If user ID is not provided, retrieve orders for all users
            $result = $conn->prepare($query);
        }
        
        $result->execute();

        $orders = array();

        foreach ($result->fetchAll() as $r) {
            $order = new orders();
            $order->o_id = $r['o_id'];
            $order->u_id = $r['u_id'];
            $order->product = $r['product'];
            $order->quantity = $r['quantity'];
            $order->price = $r['price'];
            $order->status = $r['status'];
            $order->date = $r['date'];
            $order->method = $r['payment_method'];
            $order->payment = $r['payment_status'];
        
            // Include customer information
            $customer = new Customer();
            $customer->ID = $r['u_id'];
            $customer->email = $r['email'];
            $customer->address = $r['address'];
            
            $order->user = $customer;

            array_push($orders, $order);
        }

        return $orders;
    } catch (Exception $th) {
        throw $th;
    }
}
public static function GetOrder($id)
{
    try {
        $query = "SELECT `o_id`, `u_id`, `product`, `quantity`, `price`, `card_owner`, `card_no`, `Exp`, 
        `cvv`, `payment_method`, `payment_status`, `status`, `date` FROM `orders` WHERE `o_id` = :id";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();

        $r = $st->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $order = new orders();
            $order->o_id = $r['o_id'];
            $order->payment = $r['payment_status'];
            $order->status = $r['status'];
            
            return $order;
        }
        return null;
    } catch (Exception $th) {
        throw $th;
    }
}

public function UpdateOrder()
{
    try {
        $query = "UPDATE `orders` SET `payment_status` = :payment, `status` = :status WHERE `o_id` = :id";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $st->bindValue(":id", $this->o_id, PDO::PARAM_INT);
        $st->bindValue(":payment", $this->payment, PDO::PARAM_STR);
        $st->bindValue(":status", $this->status, PDO::PARAM_STR);
        $st->execute();
    } catch (Exception $ex) {
        throw $ex;
    }
}

public static function Delete($ID) {
    try{
    $query="DELETE FROM `orders` WHERE `o_id` = :ID";
        $conn=Conn::GetConnection();
        $st=$conn->prepare($query);
        $st->bindValue(":ID",$ID,PDO::PARAM_INT);
        $st->execute();
    }
    catch(Exception $ex){
        throw $ex;
    }
}
public static function GetSalesCountDelivered() {
    try {
        $query = "SELECT COUNT(*) AS sales_count FROM orders WHERE status = 'Delivered'";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        return $row['sales_count'];
    } catch (Exception $ex) {
        throw $ex;
    }
}
public static function GetRevenueFromDeliveredOrders() {
    try {
        $query = "SELECT SUM(price) AS total_revenue FROM orders WHERE status = 'Delivered'";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        // Handle case where there are no delivered orders
        if ($row['total_revenue'] === null) {
            return 0;
        }
        
        return $row['total_revenue'];
    } catch (Exception $ex) {
        throw $ex;
    }
}
public static function SearchOrders($search)
{
    try {
        $query = "SELECT o.*, c.email, c.address FROM orders o
                  JOIN customer c ON o.u_id = c.ID
                  WHERE o.product LIKE :search 
                  OR o.status LIKE :search
                  OR o.payment_method LIKE :search
                  OR o.payment_status LIKE :search
                  OR o.date LIKE :search";
        $conn = Conn::GetConnection();
        $st = $conn->prepare($query);
        $searchParam = "%$search%";
        $st->bindValue(":search", $searchParam, PDO::PARAM_STR);
        $st->execute();

        $orders = array();

        foreach ($st->fetchAll() as $r) {
            $order = new orders();
            $order->o_id = $r['o_id'];
            $order->u_id = $r['u_id'];
            $order->product = $r['product'];
            $order->quantity = $r['quantity'];
            $order->price = $r['price'];
            $order->cardowner = $r['card_owner'];
            $order->cardno = $r['card_no'];
            $order->Exp = $r['Exp'];
            $order->cvv = $r['cvv'];
            $order->method = $r['payment_method'];
            $order->payment = $r['payment_status'];
            $order->status = $r['status'];
            $order->date = $r['date'];
            
            // Include customer information
            $customer = new Customer();
            $customer->email = $r['email'];
            $customer->address = $r['address'];
            $order->user = $customer;

            array_push($orders, $order);
        }

        return $orders;
    } catch (Exception $ex) {
        throw $ex;
    }
}
public static function GetPendingOrdersCount() {
    try {
        $query = "SELECT COUNT(*) AS pending_orders_count FROM orders WHERE status = 'pending'";
        $conn = Conn::GetConnection();
        $result = $conn->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        return $row['pending_orders_count'];
    } catch (Exception $ex) {
        throw $ex;
    }
}


}