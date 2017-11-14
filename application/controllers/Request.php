<?php 

class Request extends MY_Controller
{
	private $response;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('request_queue_m');
		$this->response['error'] = false;
	}

	public function set_request()
	{
		$request_method = $this->METHOD();

		if ($request_method == 'post')
		{
			$this->load->model('musics_m');
			$musics_id = $this->POST('musics_id');
			$musics = $this->musics_m->get_row(['musics_id' => $musics_id]);
			if (isset($musics))
			{
				$data = ['musics_id'	=> $musics_id];

				$priority = $this->POST('priority');
				if (isset($priority) && $priority == 1)
				{
					$data['priority'] 	= $priority;
					$schedule 			= $this->POST('schedule');
					if (isset($schedule))
					{
						$data['schedule'] = $schedule;
						$this->request_queue_m->insert($data);
					}
					else
					{
						$this->response['error'] 			= true;
						$this->response['error_message']	= 'You must set the schedule';
					}
				}
				else
				{
					$this->request_queue_m->insert($data);
				}
			}	
			else
			{
				$this->response['error']			= true;
				$this->response['error_message']	= "$musics_id is the given music id. Music not found";
			}
		}
		else
		{
			$this->response['error'] 			= true;
			$this->response['error_message']	= 'Request aborted';
		}

		echo json_encode($this->response);
	}

	public function get_request()
	{
		$type = $this->GET('type', true);
		$query_string = $_GET;
		unset($query_string['type']);
		$fields = $query_string;

		if (isset($type) && $type == 'one')
		{
			if (count($fields) > 0)
			{
				$this->response['data'] = $this->request_queue_m->select_row(['*'], $fields);
			}
			else
			{
				$this->response['data'] = $this->request_queue_m->select_row();
			}
		}
		else
		{
			if (count($fields) > 0)
			{
				$this->response['data'] = $this->request_queue_m->select(['*'], $fields);
			}
			else
			{
				$this->response['data'] = $this->request_queue_m->select();
			}
		}

		echo json_encode($this->response);
	}
}