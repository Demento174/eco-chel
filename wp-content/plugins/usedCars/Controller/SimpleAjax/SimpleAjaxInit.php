<?php


namespace SimpleAjax;

class SimpleAjaxInit extends SimpleAjaxTemplate
{



    public function __construct()
    {
        $this->setMethods('SimpleAJAX\SimpleAjax');

        if(empty($this->methods)){
            new \View\Render('404',['message'=>'нет кастмоных методов AJAX']);
            wp_die();
        }

        new SimpleAjax($this->methods);

        return $this->methods;
    }



}