<?php  

class Player extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] 	= 'TuneGether';
		$this->data['content']	= 'player';
		$this->template($this->data);
	}

	public function get_currently_playing()
	{
		$this->response['error'] 			= false;
		$this->response['error_message'] 	= '';
		$this->response['data']				= [];

		$file = json_decode(file_get_contents(FCPATH . '/now_playing.txt'));
		if (isset($file->currently_playing, $file->request_id))
		{
			$this->load->model('musics_m');
			$this->response['data'] = $this->musics_m->get_music(['musics_id' => $file->currently_playing]);
			$this->response['data'] = (array)$this->response['data'];
			$this->response['data']['request_id'] = $file->request_id;
			$this->response['data'] = (object)$this->response['data'];
		}

		echo json_encode($this->response);
	}

	public function refresh()
	{
		$this->load->model('request_queue_m');
		$this->data['playlist'] = $this->request_queue_m->get(['played' => '0']);
		$this->data['playlist']['request_available'] = false;

		if (count($this->data['playlist']) > 1)
		{
			$this->data['playlist']['request_available'] = true;
			$this->data['playlist']['currently_playing'] = $this->POST('currently_playing');
			if ($this->data['playlist']['currently_playing'] != $this->data['playlist'][0]->musics_id)
			{
				file_put_contents(FCPATH . '/now_playing.txt', json_encode([
					'currently_playing'	=> $this->data['playlist'][0]->musics_id,
					'request_id'		=> $this->data['playlist'][0]->request_id
				]));
				$this->session->set_userdata('currently_playing', $this->data['playlist'][0]->musics_id);
				$this->data['playlist']['currently_playing'] = $this->data['playlist'][0]->musics_id;
				$this->load->model('musics_m');
				$music = $this->musics_m->get_row(['musics_id' => $this->data['playlist']['currently_playing']]);
				$this->data['playlist']['src'] = $music->filename;
			}
			else
			{
				$this->request_queue_m->update($this->data['playlist'][0]->request_id, ['played' => '1']);
			}
		}
		else
		{
			file_put_contents(FCPATH . '/now_playing.txt', json_encode([
				'currently_playing'	=> false,
				'request_id'		=> false
			]));
			$this->data['playlist']['currently_playing'] = false;
		}

		echo json_encode($this->data['playlist']);
	}
}