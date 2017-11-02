<?php 

class Service extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// $request_method = $this->METHOD();

		// if ($request_method == 'post')
		// {
		// 	$access_token = base64_decode($this->POST('access_token'));
		// 	if ($access_token != 'key_sangat_rahasia_disini_haha_hihi_huhu_hehe_hoho')
		// 	{
		// 		$response['error'] 			= true;
		// 		$response['error_status']	= -1;
		// 		$response['error_msg']		= 'Access token is not valid';
		// 		echo json_encode($response);
		// 		exit;
		// 	}
		// }
	}

	public function poll()
	{
		$this->load->model('poll_m');
		$response['error'] = false; // error flag
		$request_method = $this->METHOD(); // get or post
		switch ($request_method)
		{
			case 'get':

				$type = $this->GET('type', true); // all rows or one row of data
				$query_string_array = $_GET;
				unset($query_string_array['type']);
				switch ($type)
				{
					case 'all':

						$fields = $query_string_array;
						if (count($fields) > 0)
						{
							$response['data'] = $this->poll_m->select(['*'], $fields);
						}
						else
						{
							$response['data'] = $this->poll_m->select();
						}

						break;

					case 'one':

						$fields = $query_string_array;
						if (count($fields) > 0)
						{
							$response['data'] = $this->poll_m->select_row(['*'], $fields);
						}
						else
						{
							$response['data'] = $this->poll_m->select_row();
						}

						break;
				}

				break;

			case 'post':

				$action = $this->POST('action');
				switch ($action)
				{
					case 'insert':

						do
						{
							$poll_id = mt_rand();
							$duplicated = $this->poll_m->get_row(['poll_id' => $poll_id]);
						}
						while ($duplicated);

						$title = $this->POST('title');
						if (strlen($title) > 500)
						{
							$response['error'] 			= true;
							$response['error_status']	= 1;
							$response['error_msg'] 		= 'Title can not be longer than 500 characters';
							break;
						}

						$created_at = date('Y-m-d H:i:s');
						$entry = [
							'poll_id'		=> $poll_id,
							'title'			=> $title,
							'description'	=> $this->POST('description'),
							'started_at'	=> $this->POST('started_at'),
							'ended_at'		=> $this->POST('ended_at'),
							'created_at'	=> $created_at,
							'updated_at'	=> $created_at
						];

						$this->poll_m->insert($entry);

						break;

					case 'update':

						$updated_at = date('Y-m-d H:i:s');
						$entry = [
							'poll_id'		=> $this->POST('poll_id'),
							'title'			=> $this->POST('title'),
							'description'	=> $this->POST('description'),
							'started_at'	=> $this->POST('started_at'),
							'ended_at'		=> $this->POST('ended_at'),
							'updated_at'	=> $updated_at
						];

						$this->poll_m->update($this->POST('poll_id'), $entry);

						break;

					case 'delete':

						$this->poll_m->delete($this->POST('poll_id'));

						break;
				}

				break;
		}

		echo json_encode($response);
	}

	public function poll_option()
	{
		$this->load->model('poll_option_m');
		$response['error'] = false;
		$request_method = $this->METHOD();
		switch ($request_method)
		{
			case 'get':

				$type = $this->GET('type', true);
				$query_string_array = $_GET;
				unset($query_string_array['type']);
				switch ($type)
				{
					case 'all':

						$fields = $query_string_array;
						if (count($fields) > 0)
						{
							$response['data'] = $this->poll_option_m->select(['*'], $fields);
						}
						else
						{
							$response['data'] = $this->poll_option_m->select();
						}

						break;

					case 'one':

						$fields = $query_string_array;
						if (count($fields) > 0)
						{
							$response['data'] = $this->poll_option_m->select_row(['*'], $fields);
						}
						else
						{
							$response['data'] = $this->poll_option_m->select_row();
						}

						break;
				}

				break;

			case 'post':

				$action = $this->POST('action');
				switch ($action)
				{
					case 'insert':
						$this->load->model('poll_m');
						$poll_id = $this->POST('poll_id');
						$check_poll = $this->poll_m->get_row(['poll_id' => $poll_id]);

						if (!isset($check_poll))
						{
							$response['error'] 			= true;
							$response['error_status']	= 1;
							$response['error_msg']		= 'Add option failed because poll is not available';
						}
						else
						{
							$created_at = date('Y-m-d H:i:s');
							$details = $this->POST('details');
							$label = $this->POST('label');
							if (strlen($label) > 500)
							{
								$response['error']			= true;
								$response['error_status']	= 2;
								$response['error_msg']		= 'Label can not be longer than 500 characters';
								break;
							}

							do
							{
								$option_id = mt_rand();
								$duplicated = $this->poll_option_m->get_row(['option_id' => $option_id]);
							}
							while ($duplicated);

							$entry = [
								'option_id'		=> $option_id,
								'poll_id'		=> $check_poll->poll_id,
								'label'			=> $label,
								'details'		=> $details,
								'created_at'	=> $created_at,
								'updated_at'	=> $created_at
							];

							$this->poll_option_m->insert($entry);
							$response['id'] = $option_id;
						}

						break;

					case 'update':

						$this->load->model('poll_m');
						$poll_id = $this->POST('poll_id');
						$check_poll = $this->poll_m->get_row(['poll_id' => $poll_id]);

						if (!isset($check_poll))
						{
							$response['error'] 			= true;
							$response['error_status'] 	= 1;	
							$response['error_msg']		= 'Edit option failed because poll is not available';
							break;
						}
						else
						{
							$label = $this->POST('label');
							if (strlen($label) > 500)
							{
								$response['error']			= true;
								$response['error_status']	= 2;
								$response['error_msg']		= 'Label can not be longer than 500 characters';
								break;
							}

							$details = $this->POST('details');
							$updated_at = date('Y-m-d H:i:s');
							$entry = [
								'poll_id'		=> $poll_id,
								'label'			=> $label,
								'details'		=> $details,
								'updated_at'	=> $updated_at
							];

							$this->poll_option_m->update($this->POST('option_id'), $entry);
							$response['id'] = $this->POST('option_id');
						}

						break;

					case 'delete':

						$this->poll_option_m->delete($this->POST('option_id'));

						break;
				}

				break;
		}

		echo json_encode($response);
	}

	public function poll_option_details()
	{
		$this->load->model('poll_option_details_m');
		$response['error'] = false; // error flag
		$request_method = $this->METHOD(); // get or post
		switch ($request_method)
		{
			case 'get':

				$type = $this->GET('type', true); // all rows or one row of data
				$query_string_array = $_GET;
				unset($query_string_array['type']);
				switch ($type)
				{
					case 'all':

						$fields = $query_string_array;
						if (count($fields) > 0)
						{
							$response['data'] = $this->poll_option_details_m->select(['*'], $fields);
						}
						else
						{
							$response['data'] = $this->poll_option_details_m->select();
						}

						break;

					case 'one':

						$fields = $query_string_array;
						if (count($fields) > 0)
						{
							$response['data'] = $this->poll_option_details_m->select_row(['*'], $fields);
						}
						else
						{
							$response['data'] = $this->poll_option_details_m->select_row();
						}

						break;
				}

				break;

			case 'post':

				$action = $this->POST('action');
				switch ($action)
				{
					case 'insert':

						$poll_id = $this->POST('poll_id');
						$this->load->model('poll_m');
						$check_poll = $this->poll_m->get_row();
						if (!isset($check_poll))
						{
							$response['error'] 			= true;
							$response['error_status']	= 1;
							$response['error_msg']		= 'The poll is not available';
							break;
						}

						$data_type 		= $this->POST('data_type');
						$option_values 	= $this->POST('option_values');

						$created_at = date('Y-m-d H:i:s');
						$entry = [
							'poll_id'		=> $poll_id,
							'data_type'		=> $data_type,
							'option_values'	=> $data_type == 'enum' ? json_encode($option_values) : '',
							'name'			=> $this->POST('name'),
							'label'			=> $this->POST('label'),
							'created_at'	=> $created_at,
							'updated_at'	=> $created_at
						];

						$this->poll_option_details_m->insert($entry);

						break;

					case 'update':
						
						$data_type 		= $this->POST('data_type');
						$option_values 	= $this->POST('option_values');

						$updated_at = date('Y-m-d H:i:s');
						$entry = [
							'poll_id'		=> $poll_id,
							'data_type'		=> $data_type,
							'option_values'	=> $data_type == 'enum' ? json_encode($option_values) : '',
							'name'			=> $this->POST('name'),
							'label'			=> $this->POST('label'),
							'updated_at'	=> $updated_at
						];

						$this->poll_option_details_m->update($this->POST('option_details_id'), $entry);

						break;

					case 'delete':

						$this->poll_option_details_m->delete($this->POST('option_details_id'));

						break;
				}

				break;
		}

		echo json_encode($response);
	}

	public function vote()
	{
		$this->load->model('poll_option_m');
		$this->load->model('vote_m');
		$this->load->model('voucher_m');
		$this->load->model('voucher_type_m');
		$this->load->model('poll_m');
		$response['error'] = false;

		$check_voucher = $this->voucher_m->get_row([
			'code' 	=> $this->POST('code'),
			'used'	=> 'false'
		]);

		$poll = $this->poll_m->get_row(['poll_id' => $this->POST('poll_id')]);
		if (!isset($poll))
		{
			$response['error']			= true;
			$response['error_status']	= 3;
			$response['error_msg']		= 'Option is not available for this poll';
		}
		else
		{
			$start = new DateTime($poll->started_at);
			$end = new DateTime($poll->ended_at);
			$now = new DateTime(date('Y-m-d H:i:s'));
			if ($now < $start)
			{
				$this->load->library('tanggal');
				$response['error'] 			= true;
				$response['error_status']	= 4;
				$response['error_msg']		= 'Polling belum dibuka atau tidak tersedia untuk saat ini. Polling dibuka pada ' . $this->tanggal->convert_date($start->format('Y-m-d H:i:s'));
			}
			else if ($now > $end)
			{
				$response['error'] 			= true;
				$response['error_status']	= 5;
				$response['error_msg']		= 'Polling telah ditutup atau tidak tersedia untuk saat ini';
			}
			else if (!isset($check_voucher))
			{
				$response['error'] 			= true;
				$response['error_status']	= 1;
				$response['error_msg']		= 'This voucher is already used or the code is not valid';
			}
			else
			{
				$voucher_type = $this->voucher_type_m->get_row([
					'type_id'	=> $check_voucher->type_id,
					'poll_id'	=> $this->POST('poll_id')
				]);

				if (!isset($voucher_type))
				{
					$response['error']			= true;
					$response['error_status']	= 2;
					$response['error_msg']		= 'This voucher type is not available for this poll';
				}
				else
				{
					$check_option = $this->poll_option_m->get_row(['option_id' => $this->POST('option_id')]);

					if (!isset($check_option))
					{
						$response['error']			= true;
						$response['error_status']	= 3;
						$response['error_msg']		= 'Option is not available for this poll';
					}
					else
					{
						do
						{
							$vote_id = mt_rand();
							$duplicated = $this->vote_m->get_row(['vote_id' => $vote_id]);
						}
						while ($duplicated);

						$created_at = date('Y-m-d H:i:s');
						$ip_address = $this->input->ip_address();
						$vote = [
							'vote_id'		=> $vote_id,
							'poll_id'		=> $voucher_type->poll_id,
							'voucher_id'	=> $check_voucher->voucher_id,
							'option_id'		=> $check_option->option_id,
							'created_at'	=> $created_at,
							'updated_at'	=> $created_at,
							'ip_address'	=> $ip_address
						];
						$this->vote_m->insert($vote);

						$this->voucher_m->update($check_voucher->voucher_id, [
							'used'			=> 'true',
							'updated_at'	=> $created_at
						]);
					}
				}
			}

		}

		
		echo json_encode($response);
	}

	public function voucher()
	{
		$response['error'] = false;
		$request_method = $this->METHOD();

		if ($request_method == 'post')
		{
			$poll_id = $this->POST('poll_id');
			if ($poll_id)
			{
				$this->load->model('voucher_m');
				$response['data'] = $this->voucher_m->get_voucher($poll_id);
			}
			else
			{
				$response['error']			= true;
				$response['error_status']	= 2;
				$response['error_msg']		= 'The poll does not exist';
			}
		}
		else
		{
			$response['error'] 			= true;
			$response['error_status']	= 1;
			$response['error_msg']		= 'Request method is not allowed';
		}

		echo json_encode($response);
	}

	public function voucher_type()
	{
		$response['error'] = false;
		$request_method = $this->METHOD();

		if ($request_method == 'post')
		{
			$poll_id = $this->POST('poll_id');
			if ($poll_id)
			{
				$this->load->model('voucher_type_m');
				$response['data'] = $this->voucher_type_m->get(['poll_id' => $poll_id]);
			}
			else
			{
				$response['error']			= true;
				$response['error_status']	= 2;
				$response['error_msg']		= 'The poll does not exist';
			}
		}
		else
		{
			$response['error'] 			= true;
			$response['error_status']	= 1;
			$response['error_msg']		= 'Request method is not allowed';
		}

		echo json_encode($response);
	}

	public function generate_code()
	{
		$response['error'] = false;

		$this->load->model('voucher_type_m');
		$type_id = $this->POST('type_id');
		$check_type = $this->voucher_type_m->get_row(['type_id' => $type_id]);

		if (!isset($check_type))
		{
			$response['error'] 			= true;
			$response['error_status']	= 1;
			$response['error_msg']		= 'This voucher type is not available for this poll';
		}
		else
		{
			$this->load->model('voucher_m');
			$amount = $this->POST('amount');
			$generated = [];
			for ($i = 0; $i < $amount; $i++)
			{
				do
				{
					$voucher_id = mt_rand();
					$duplicated = $this->voucher_m->get_row(['voucher_id' => $voucher_id]);
				}
				while ($duplicated);

				do
				{
					$code = $this->_generate_random_string();
					$duplicated = $this->voucher_m->get_row(['code' => $code]);
				}
				while ($duplicated);

				$created_at = date('Y-m-d H:i:s');
				$generated_voucher = [
					'voucher_id'	=> $voucher_id,
					'type_id'		=> $type_id,
					'code'			=> $code,
					'used'			=> 'false',
					'created_at'	=> $created_at,
					'updated_at'	=> $created_at
				];

				$this->voucher_m->insert($generated_voucher);
				$generated []= $generated_voucher;
			}

			$response['data'] = $generated;
		}

		echo json_encode($response);
	}

	public function total_sold()
	{
		$this->load->model('admin_m');
		$response['error'] = false;
		// $access_token = $this->POST('access_token');
		$poll_id = $this->POST('poll_id');
		if ($poll_id)
		{
			// $check_token = $this->admin_m->get_row(['access_token' => $access_token]);
			// if (isset($check_token))
			// {
				$response['data'] = $this->admin_m->get_total_sold($poll_id);
			// }
			// else
			// {
			// 	$response['error'] 			= true;
			// 	$response['error_status'] 	= 2;
			// 	$response['error_msg']		= 'Your access token is not valid';
			// }
		}
		else
		{
			$response['error'] 			= true;
			$response['error_status'] 	= 1;
			$response['error_msg']		= 'Required parameter is missing';
		}
		echo json_encode($response);
	}

	public function total_votes()
	{
		$this->load->model('vote_m');
		$response['error'] = false;
		$poll_id = $this->POST('poll_id');

		if (isset($poll_id))
		{
			$this->load->model('poll_m');
			$check_poll = $this->poll_m->get_row(['poll_id' => $poll_id]);
			if (isset($check_poll))
			{
				$response['data'] = $this->vote_m->get_total_votes($poll_id);
			}
			else
			{
				$response['error']			= true;
				$response['error_status']	= 2;
				$response['error_msg']		= 'This poll is not available';
			}
		}
		else
		{
			$response['error'] 			= true;
			$response['error_status']	= 1;
			$response['error_msg']		= 'Required parameter is missing';
		}

		echo json_encode($response);
	}

	private function _generate_random_string($length = 5)
	{
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$string = '';
		for ($i = 0; $i < $length; $i++)
		{
			$string .= $characters[mt_rand(0, strlen($characters) - 1)];
		}
		return $string;
	}
}