<?php
class cart
{
    public $ID;
    public $Name;
    public $Image;
    public $Price;
    public $Qty;
    public $category;

    public function GetValue()
    {
        $Price = floatval($this->Price);
        $Qty = intval($this->Qty);

        return $Price* $Qty;
    }
}
?>