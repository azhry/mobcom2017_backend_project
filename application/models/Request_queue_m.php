<?php 

class Request_queue_m extends MY_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->data['table_name']	= 'request_queue';
		$this->data['primary_key']	= 'request_id';
	}

	public function get_all_request($cond = '')
	{
		if ((is_array($cond) && count($cond) > 0) or 
			(is_string($cond) && strlen($cond) > 3))
			$this->db->where($cond);
		$this->db->select('*');
		$this->db->from($this->data['table_name']);
		$this->db->join('musics', $this->data['table_name'] . '.musics_id = musics.musics_id');
		$this->db->order_by($this->data['table_name'] . '.created_at', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_request($cond = '')
	{
		if ((is_array($cond) && count($count) > 0) or 
			(is_string($cond) && strlen($count) > 3))
			$this->db->where($cond);
		$this->db->select('*');
		$this->db->from($this->data['table_name']);
		$this->db->join('musics', $this->data['table_name'] . '.musics_id = musics.musics_id');
		$this->db->order_by($this->data['table_name'] . '.created_at', 'DESC');
		$query = $this->db->get();
		return $query->row();
	}
}