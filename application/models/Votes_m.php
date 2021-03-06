<?php 

class Votes_m extends MY_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->data['table_name']	= 'votes';
		$this->data['primary_key']	= 'vote_id';
	}

	public function count_votes($musics_id_arr, $type){
		
		$result = [];
		foreach ($musics_id_arr as $musics_id) {
			$result['musics_id'] = count_vote($musics_id, $type);	
		}	
		return $result;
	}

	public function count_vote($musics_id, $type)
	{
		$this->db->select('COUNT(type) AS total_vote');
		$this->db->from($this->data['table_name']);
		$this->db->where(['musics_id' => $musics_id, 'type' => $type]);
		$query = $this->db->get();
		$result = $query->row();

		return isset($result) ? $result->total_vote : 0; 
	}
}