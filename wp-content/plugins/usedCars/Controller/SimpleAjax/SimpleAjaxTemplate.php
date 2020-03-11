<?php


namespace SimpleAjax;

use WC_Cart;
use WC_Order_Item_Shipping;
use WC_Shipping;
use \DB\DB;

class SimpleAjaxTemplate
{
    protected $db;

    protected $methods;

    protected $table='wp_demento_SimpleAJAX';

    private $exceptions=['__construct','getMethods',"setMethods"];

    function __construct()
    {
        $this->db=new DB();
    }

    protected function setMethods($class){

        $this->methods=get_class_methods($class);

        foreach ($this->exceptions as $item){
            unset($this->methods[array_search($item, $this->methods)]);
        }


    }

    public function getMethods()
    {
        return $this->methods;
    }
}