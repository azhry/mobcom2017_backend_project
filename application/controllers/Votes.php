<?php 

class Votes extends MY_Controller
{
	private $response;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('votes_m');
		$this->response['error'] = false;
		$this->response['error_message'] = '';
		$this->response['data'] = [];
	}

	public function set_votes()
	{
		$request_method = $this->METHOD();

		if ($request_method == 'post')
		{
			$this->load->model('request_queue_m');
			$musics_id = $this->POST('musics_id');
			$request_queue = $this->request_queue_m->get_row(['musics_id' => $musics_id]);
			if (isset($request_queue))
			{
				$device_id	= $this->POST('device_id');
				$votes = $this->votes_m->get_row(['musics_id' => $musics_id, 'device_id' => $device_id]);
				$type 		= $this->POST('type');
				if (isset($votes))
				{
					if ($votes->type == $type)
					{
						$this->votes_m->delete_by(['musics_id' => $musics_id, 'device_id' => $device_id]);
					}
					else
					{
						date_default_timezone_set('Asia/Jakarta');
						$updated_at = date('Y-m-d H:i:s');
						$this->votes_m->update($votes->vote_id, [
							'type'			=> $type,
							'updated_at'	=> $updated_at
						]);
					}
				}
				else
				{
					$this->votes_m->insert([
						'musics_id'	=> $musics_id,
						'type'			=> $type,
						'device_id'		=> $device_id
					]);
				}
			}
			else
			{
				$this->response['error']			= true;
				$this->response['error_message']	= 'Request queue not found';
			}
		}
		else
		{
			$this->response['error'] 			= true;
			$this->response['error_message']	= 'Request aborted';
		}

		echo json_encode($this->response);
	}

	public function count_votes()
	{
		$musics_id = $this->POST('musics_id');
		if (isset($musics_id))
		{
			$this->response['data'] = [
				'upvote'	=> $this->votes_m->count_vote($musics_id, '1'),
				'downvote'	=> $this->votes_m->count_vote($musics_id, '0')
			];
		}
		else
		{
			$this->response['error']			= true;
			$this->response['error_message']	= 'Missing required parameters [musics_id]';
		}

		echo json_encode($this->response);
	}

	public function check_votes()
	{
		$musics_id = $this->POST('musics_id');
		$device_id = $this->POST('device_id');

		if (isset($musics_id, $device_id))
		{
			$this->response['data'] = $this->votes_m->get_row([
				'musics_id' => $musics_id,
				'device_id'	=> $device_id
			]);
		}

		echo json_encode($this->response);
	}
}