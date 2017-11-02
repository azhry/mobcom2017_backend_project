<?php 

class Request_queue_m extends MY_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->data['table_name']	= 'request_queue';
		$this->data['primary_key']	= 'request_id';
	}
}