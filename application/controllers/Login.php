<?php 

class Login extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function secret_login_url()
	{
		$this->load->model('admin_m');
		$response['error'] = false;
		$username = $this->POST('username');
		$password = $this->POST('password');
		if (isset($username, $password))
		{
			$check_account = $this->admin_m->get_row([
				'username' => $username,
				'password' => $password
			]);
			if (!isset($check_account))
			{
				$response['error'] 			= true;
				$response['error_status']	= 1;
				$response['error_msg']		= 'Wrong username or password'; 
			}
			else
			{
				$this->data['poll_id'] = $this->POST('poll_id');
				if ($check_account->poll_id != $this->data['poll_id'])
				{
					$response['error'] 			= true;
					$response['error_status']	= 1;
					$response['error_msg']		= 'Wrong username or password'; 
				}
				else
				{
					$updated_at = date('Y-m-d H:i:s');
					$ip_address = $this->input->ip_address();
					$access_token = base64_encode($check_account->admin_id) . '.' .
								base64_encode($username) .  '.' . 
								base64_encode($ip_address) . '.' . 
								base64_encode($updated_at);
					$entry = [
						'access_token'	=> $access_token,
						'updated_at'	=> $updated_at,
						'ip_address'	=> $ip_address
					];

					$this->admin_m->update($check_account->admin_id, $entry);
					$response['access_token'] =  $access_token;
				}
			}
		}
		else
		{
			$response['error'] 			= true;
			$response['error_status']	= 2;
			$response['error_msg']		= 'Required parameter is missing'; 
		}

		echo json_encode($response);
	}

	public function check_access_token()
	{
		$this->load->model('admin_m');
		$response['error'] = false;
		$access_token = $this->POST('access_token');
		$token_generic = explode('.', $access_token);
		if (count($token_generic) > 1)
		{
			$admin_id = base64_decode($token_generic[0]);
			$username = base64_decode($token_generic[1]);
			$verify = $this->admin_m->select_row(['access_token'], [
				'access_token' 	=> $access_token,
				'admin_id'		=> $admin_id,
				'username'		=> $username
			]);
			if ($verify)
			{
				$updated_at = date('Y-m-d H:i:s');
				$ip_address = $this->input->ip_address();
				$access_token = base64_encode($admin_id) . '.' .
							base64_encode($username) .  '.' . 
							base64_encode($ip_address) . '.' . 
							base64_encode($updated_at);
				$entry = [
					'access_token'	=> $access_token,
					'updated_at'	=> $updated_at,
					'ip_address'	=> $ip_address
				];

				$this->admin_m->update($admin_id, $entry);
				$response['access_token'] =  $access_token;
			}
			else
			{
				$response['error']			= true;
				$response['error_status']	= 1;
				$response['error_msg']		= 'You have no authorized access. Please login!';
			}	
		}
		else
		{
			$response['error']			= true;
			$response['error_status']	= 1;
			$response['error_msg']		= 'You have no authorized access. Please login!';
		}
		
		echo json_encode($response);
	}
}