<?php 

class Votes_m extends MY_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->data['table_name']	= 'votes';
		$this->data['primary_key']	= 'vote_id';
	}

	public function count_vote($request_id, $type)
	{
		$this->db->select('COUNT(type) AS total_vote');
		$this->db->from($this->data['table_name']);
		$this->db->where(['request_id' => $request_id, 'type' => $type]);
		$query = $this->db->get();
		$result = $query->row();

		return isset($result) ? $result->total_vote : 0; 
	}
}