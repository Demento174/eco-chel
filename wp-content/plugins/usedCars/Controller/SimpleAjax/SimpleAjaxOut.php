<?php


namespace SimpleAjax;

use \View\Render;

class SimpleAjaxOut extends SimpleAjaxTemplate
{
    private $view='simpleAJAX/simpleAJAX';

    private $data;

    function __construct()
    {
        parent::__construct();

        $methods = new SimpleAjaxInit();

        $this->methods = $methods->methods;

        $this->setData();

        new Render($this->view,['data'=>$this->data]);
    }

    private function setData(){

        foreach ($this->methods as $item){

            $simpleAjaxDB=new SimpleAjaxDB();

            $result=$simpleAjaxDB->selectFromTitle($item);

            if(empty($result)){
                $lastId = $simpleAjaxDB->insert($item);

                $this->data[]=[
                    'id'=>$lastId,
                    'title'=>$item,
                    'description'=>''
                ];
            }else{
                $result=$result[0];
                $this->data[]=[
                    'id'=>$result['id'],
                    'title'=>$result['title'],
                    'description'=>$result['Description']
                ];
            }
        }

    }
}