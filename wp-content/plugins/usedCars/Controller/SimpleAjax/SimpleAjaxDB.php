<?php


namespace SimpleAjax;


class SimpleAjaxDB extends SimpleAjaxTemplate
{
    function __construct()
    {
        parent::__construct();
    }

    public function insert($title,$description='')
    {

        $this->db->query('INSERT INTO '.$this->table.' (title,description) VALUES ("'.$title.'","'.$description.'")');
        return $this->db->lastId();
    }

    public function insertFromId($description='',$id)
    {
        $sql ='UPDATE '.$this->table.' SET description = "'.$description.'" WHERE id="'.$id.'"';

        $this->db->query($sql);
    }

    public function selectAll()
    {
        $result = $this->db->query('SELECT * FROM '.$this->table);

        return $result;
    }

    public function selectFromTitle($title)
    {
        $result = $this->db->query('SELECT * FROM '.$this->table.' WHERE title = "'.$title.'"');

        return $result;
    }

}