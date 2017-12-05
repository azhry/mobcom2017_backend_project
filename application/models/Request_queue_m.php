<?php 

require_once APPPATH . '/third_party/getID3-1.9.15/getid3/getid3.php';

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
		
		$ID3 = new getID3();

		$result = [];
		$musics = $query->result();

		foreach ($musics as $music)
		{
			$path 		= FCPATH . 'assets/musics/' . $music->filename;
			$file_info 	= $ID3->analyze($path);
			if (isset($file_info['comments']['picture'][0]))
			{
				$music->base64img = base64_encode($file_info['comments']['picture'][0]['data']);
			}
			else
			{
				$music->base64img = null;
			}

			$result []= $music;
		}

		return $result;
	}

	public function get_request($cond = '')
	{
		if ((is_array($cond) && count($count) > 0) or 
			(is_string($cond) && strlen($count) > 3))
			$this->db->where($cond);
		$this->db->select('*');
		$this->db->from($this->data['table_name']);
		$this->db->join('musics', $this->data['table_name'] . '.musics_id = musics.musics_id');
		// $this->db->order_by($this->data['table_name'] . '.created_at', 'DESC');
		$query = $this->db->get();

		$ID3 = new getID3();
		$music = $query->row();

		if (isset($music))
		{
			$path 		= FCPATH . 'assets/musics/' . $music->filename;
			$file_info 	= $ID3->analyze($path);
			if (isset($file_info['comments']['picture'][0]))
			{
				$music->base64img = base64_encode($file_info['comments']['picture'][0]['data']);
			}
			else
			{
				$music->base64img = null;
			}
		}

		return $music;
	}
}