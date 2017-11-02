<?php 

class Musics extends MY_Controller
{
	private $response;

	public function __construct()
	{
		parent::__construct();
		$this->response['error'] = false;
		$this->load->model('musics_m');
	}

	public function set_musics()
	{
		$request_method = $this->METHOD();

		if ($request_method == 'post')
		{
			$title 		= $this->POST('title');
			$artist		= $this->POST('artist');
			$album		= $this->POST('album');
			$genre		= $this->POST('genre');
			$filename	= $this->POST('filename');
			if (isset($title, $artist, $album, $genre, $filename))
			{
				$this->musics_m->insert([
					'title'		=> $title,
					'artist'	=> $artist,
					'album'		=> $album,
					'genre'		=> $genre,
					'filename'	=> $filename
				]);
			}
			else
			{
				$this->response['error']			= true;
				$this->response['error_message']	= 'Required parameters are missing';
			}
		}
		else
		{
			$this->response['error'] 			= true;
			$this->response['error_message']	= 'Request aborted';
		}

		echo json_encode($this->response);
	}

	public function get_musics()
	{
		$type = $this->GET('type', true);
		$query_string = $_GET;
		unset($query_string['type']);
		$fields = $query_string;

		if (isset($type) && $type == 'one')
		{
			if (count($fields) > 0)
			{
				$this->response['data'] = $this->musics_m->select_row(['*'], $fields);
			}
			else
			{
				$this->response['data'] = $this->musics_m->select_row();
			}
		}
		else
		{
			if (count($fields) > 0)
			{
				$this->response['data'] = $this->musics_m->select(['*'], $fields);
			}
			else
			{
				$this->response['data'] = $this->musics_m->select();
			}
		}

		echo json_encode($this->response);
	}
}