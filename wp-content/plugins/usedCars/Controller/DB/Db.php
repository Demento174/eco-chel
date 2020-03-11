<?php
namespace DB;

class DB{

	private $wpdb;

	function __construct($dbName=''){
		global $wpdb;


		$this->wpdb = new \wpdb( DB_USER, DB_PASSWORD, !empty($dbName)?$dbName:DB_NAME, DB_HOST );



		if( ! empty($this->wpdb->error) ){

			wp_die( $this->wpdb->error );
		}

	}

	public function query($sql){
		return $this->wpdb->get_results($sql,ARRAY_A);
	}

	public function getCount($table){
		$result = (array) $this->query('SELECT COUNT(*) FROM '.$table)[0];
		return (int) $result['COUNT(*)'];
	}

	public function lastId(){
		return $this ->wpdb->insert_id;
	}
}