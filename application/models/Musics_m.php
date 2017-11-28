<?php 

require_once APPPATH . '/third_party/getID3-1.9.15/getid3/getid3.php';

class Musics_m extends MY_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->data['table_name']	= 'musics';
		$this->data['primary_key']	= 'musics_id';
	}

	public function get_all_musics($cond = '')
	{
		$ID3 = new getID3();

		$result = [];
		if ((is_array($cond) && count($cond) > 0) or 
			(is_string($cond) && strlen($cond) > 3))
			$musics = $this->get($cond);
		else
			$musics = $this->get();
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

	public function get_music($cond = '')
	{
		$ID3 = new getID3();

		if ((is_array($cond) && count($cond) > 0) or 
			(is_string($cond) && strlen($cond) > 3))
			$music = $this->select_row(['*'], $cond);
		else
			$music = $this->select_row(['*']);
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