<?php 

class Votes extends MY_Controller
{
	private $response;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('votes_m');
		$this->response['error'] = false;
	}

	public function set_votes()
	{
		$request_method = $this->METHOD();

		if ($request_method == 'post')
		{
			$this->load->model('request_queue_m');
			$request_id = $this->POST('request_id');
			$request_queue = $this->request_queue_m->get_row(['request_id' => $request_id]);
			if (isset($request_queue))
			{
				$device_id	= $this->POST('device_id');
				$votes = $this->votes_m->get_row(['request_id' => $request_id, 'device_id' => $device_id]);
				$type 		= $this->POST('type');
				if (isset($votes))
				{
					date_default_timezone_set('Asia/Jakarta');
					$updated_at = date('Y-m-d H:i:s');
					$this->votes_m->update($votes->vote_id, [
						'type'			=> $type,
						'updated_at'	=> $updated_at
					]);
				}
				else
				{
					$this->votes_m->insert([
						'request_id'	=> $request_id,
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
		$request_id = $this->GET('request_id');
		if (isset($request_id))
		{
			$this->load->model('request_queue_m');
			$request_queue = $this->request_queue_m->get_row(['request_id' => $request_id]);
			if (isset($request_queue))
			{
				$this->response['data'] = [
					'upvote'	=> $this->votes_m->count_vote($request_id, 1),
					'downvote'	=> $this->votes_m->count_vote($request_id, 0)
				];
			}
			else
			{
				$this->response['error']			= true;
				$this->response['error_message']	= 'Request queue not found';
			}
		}
		else
		{
			$this->response['error']			= true;
			$this->response['error_message']	= 'Missing required parameters [request_id]';
		}

		echo json_encode($this->response);
	}
}