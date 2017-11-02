<?php 

class Musics_m extends MY_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->data['table_name']	= 'musics';
		$this->data['primary_key']	= 'musics_id';
	}
}