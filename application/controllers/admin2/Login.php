<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index() {

		   
			$logged_in = $this->session->userdata('logged_in');
			$admin_id  = $this->session->userdata('admin_id');

			$google_auth = $this->session->userdata('google_auth');
			if ($logged_in == 1) {
				redirect(base_url().'admin2/dashboard');
			} else {
				$this->load->view('admin2/login/login');
			}
	}

	public function get_user_info() {
		$ip = getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');

		$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
		$detail  = (array) $details;

		$userAgent    = $_SERVER["HTTP_USER_AGENT"];
		$devicesTypes = array(
			"computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
			"tablet"   => array("tablet", "android", "ipad", "tablet.*firefox"),
			"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
			"bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis"),
		);
		foreach ($devicesTypes as $deviceType => $devices) {
			foreach ($devices as $device) {
				if (preg_match("/".$device."/i", $userAgent)) {
					$deviceName = $deviceType;
				}
			}
		}
		$returnArr = $this->getBrowser();

		$array = array(
			'IP'               => $ip,
			'location'         => $detail['city'].','.$detail['region'].', '.$detail['country'],
			'Geometry'         => $detail['loc'],
			'Postal Code'      => $detail['postal'],
			'Device'           => $deviceName,
			'Browser'          => $returnArr['name']." Version ".$returnArr['version'],
			'Operating System' => $returnArr['platform'],
			'Date Time'        => date('l jS \of F Y h:i:s A'),
		);

		return $array;
	}
	public function getBrowser() {
		$u_agent  = $_SERVER['HTTP_USER_AGENT'];
		$bname    = 'Unknown';
		$platform = 'Unknown';
		$version  = "";

		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		} elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}

		// Next get the name of the useragent yes seperately and for good reason
		if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
			$bname = 'Internet Explorer';
			$ub    = "MSIE";
		} elseif (preg_match('/Firefox/i', $u_agent)) {
			$bname = 'Mozilla Firefox';
			$ub    = "Firefox";
		} elseif (preg_match('/Chrome/i', $u_agent)) {
			$bname = 'Google Chrome';
			$ub    = "Chrome";
		} elseif (preg_match('/Safari/i', $u_agent)) {
			$bname = 'Apple Safari';
			$ub    = "Safari";
		} elseif (preg_match('/Opera/i', $u_agent)) {
			$bname = 'Opera';
			$ub    = "Opera";
		} elseif (preg_match('/Netscape/i', $u_agent)) {
			$bname = 'Netscape';
			$ub    = "Netscape";
		}

		// finally get the correct version number
		$known   = array('Version', $ub, 'other');
		$pattern = '#(?<browser>'.join('|', $known).
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}

		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
				$version = $matches['version'][0];
			} else {
				$version = $matches['version'][1];
			}
		} else {
			$version = $matches['version'][0];
		}

		// check if we have a number
		if ($version == null || $version == "") {$version = "?";}

		$print_arr = array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'   => $pattern,
		);

		return $print_arr;
	}
	public function login_process() {

		if (!$this->input->post()) {
			redirect(base_url().'admin2/login');
		}

		$username = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));

		if ($username == "" || $password == "") {

			$this->session->set_flashdata('err_message', 'Username or Password is empty');
			redirect(base_url().'admin2/login');

		} else {

			$this->load->model('admin/mod_login');





			$chk_isvalid_user = $this->mod_login->validate_credentials($this->input->post('username'), $this->input->post('password'));

			if ($chk_isvalid_user) {
				//echo $secret;
				//Fetching coins Record
				$this->load->model('admin/mod_coins');
				$coins_arr   = $this->mod_coins->get_all_coins();
				$coin_symbol = $coins_arr[0]['symbol'];

				//Check user Settings
				$user_id = $chk_isvalid_user['_id'];
				// $this->db->dbprefix('settings');
				// $this->db->where('user_id', $user_id);
				// $get_settings = $this->db->get('settings');

				//echo $this->db->last_query();
				// $settings_arr = $get_settings->row_array();
				//
				// if (count($settings_arr) > 0) {
				// 	$check_api_settings = 'yes';
				// } else {
				// 	$check_api_settings = 'no';
				// }

				if ($chk_isvalid_user['api_key'] == "" || $chk_isvalid_user['api_secret'] == "") {
					$check_api_settings = 'no';
				}else{
					$check_api_settings = 'yes';
				}
				if ($chk_isvalid_user['application_mode'] == "" || $chk_isvalid_user['application_mode'] == null || $check_api_settings == 'no') {
					$application_mode = 'test';
				} else {
					$application_mode = $chk_isvalid_user['application_mode'];
				}

				$login_sess_array = array(
					'admin_id'           => (string)$chk_isvalid_user['_id'],
					'first_name'         => $chk_isvalid_user['first_name'],
					'last_name'          => $chk_isvalid_user['last_name'],
					'username'           => $chk_isvalid_user['username'],
					'profile_image'      => $chk_isvalid_user['profile_image'],
					'email_address'      => $chk_isvalid_user['email_address'],
					'check_api_settings' => $check_api_settings,
					'global_symbol'      => $coin_symbol,
					'app_mode'           => $application_mode,
					'leftmenu'           => $chk_isvalid_user['left_menu'],
					'timezone'           => $chk_isvalid_user['timezone'],
					'user_role'          => $chk_isvalid_user['user_role'],
					'special_role'       => $chk_isvalid_user['special_role'],
					'google_auth'        => $chk_isvalid_user['google_auth'],
				);
				if ($chk_isvalid_user['google_auth'] == 'yes') {
					$login_sess_array['google_auth_code'] = $chk_isvalid_user['google_auth_code'];
				}

				if ($application_mode == 'both') {
					$login_sess_array['global_mode'] = 'live';
				} elseif ($application_mode == 'test') {
					$login_sess_array['global_mode'] = 'test';
				} elseif ($application_mode == 'live') {
					$login_sess_array['global_mode'] = 'live';
				}


				$this->session->set_userdata($login_sess_array);
				// $bal = $this->update_balance();
				// if (!$bal) {
				// 	$this->session->set_flashdata('err_message', 'Enter Your Binance API KEY and secret');
				// }
				//Update Signin Date
				//$this->mod_login->update_signin_date($chk_isvalid_user['id']);
				if ($chk_isvalid_user['google_auth'] == 'yes') {
					redirect(base_url().'admin2/login/google_auth');
				} else {
					$_SESSION['logged_in'] = true;
					$this->send_logged_in_email($login_sess_array);
					redirect(base_url().'admin2/dashboard');
				}

			} else {

				$this->session->set_flashdata('err_message', 'Invalid Username or Password');
				redirect(base_url().'admin2/login');

			}//end if($chk_isvalid_user)

		}//end if($username=="" || $password=="" )

	}//end public function login_process()

	public function google_auth() {
		require_once 'GoogleAuthenticator/GoogleAuthenticator.php';
		$dataaa = $this->session->userdata();
		$email  = $dataaa['email_address'];
		$secret = $dataaa['google_auth_code'];
		//echo $secret;

		$ga = new GoogleAuthenticator();

		$qrCodeUrl         = $ga->getQRCodeGoogleUrl($email, $secret, 'Cryptotrading App');
		$data['qrCodeUrl'] = $qrCodeUrl;
		$this->load->view('admin/login/device_confirmation', $data);
	}

	public function google_auth_code() {
		$code   = $this->input->post('code');
		$dataaa = $this->session->userdata();
		$email  = $dataaa['email_address'];
		$secret = $dataaa['google_auth_code'];
		require_once 'GoogleAuthenticator/GoogleAuthenticator.php';
		$ga = new GoogleAuthenticator();
		// echo 'My code: '.$code;
		// $oneCode = $ga->getCode($secret);
		// echo "Original Code: ".$oneCode;
		// exit;
		$checkResult = $ga->verifyCode($secret, $code, 2);
		if ($checkResult) {
			$_SESSION['googleCode'] = $code;
			$_SESSION['logged_in']  = true;
			$this->send_logged_in_email($dataaa);
			redirect(base_url().'admin/dashboard');

		} else {
			$this->session->set_flashdata('err_message', 'FAILED To Authenticate With GoogleAuthenticator. Try Again  and Enter Valid Code');
			redirect(base_url().'admin/login/google_auth');
		}
	}

	public function lost_phone() {
		$this->load->view('admin/login/lost_phone', $data);
	}

	public function lost_phone_process() {
		$this->load->model("admin/mod_login");
		$sess_data = $this->session->userdata($login_sess_array);
		$email     = $sess_data['email_address'];
		$user_id   = $sess_data['admin_id'];
		$secret    = $sess_data['google_auth_code'];

		if (!isset($sess_data['no_of_login'])) {
			$no_of_login              = 0;
			$data_sess['no_of_login'] = $no_of_login;
			$this->session->set_userdata($data_sess);
		} else {
			$no_of_login = $this->session->userdata('no_of_login');
			$no_of_login++;
			$data_sess['no_of_login'] = $no_of_login;
			$this->session->set_userdata($data_sess);
		}

		$no_of_attempts   = 5-$no_of_login;
		$post_secret_code = $this->input->post('code');

		if ($no_of_attempts == 0) {
			$this->session->unset_userdata('no_of_login');
			$this->mod_login->user_soft_delete($user_id);
			$this->session->set_flashdata('err_message', 'You have Entered the wrong secret code 3 times! Your account has been locked Contact our System Administrator');
			redirect(base_url().'admin/login');
		}
		if ($secret == $post_secret_code) {
			redirect(base_url().'admin/dashboard');
		} else {
			$this->session->set_flashdata('err_message', 'You have Entered the wrong secret code <br> '.$no_of_attempts.' attempts left');
			redirect(base_url().'admin/login/lost_phone');
		}

	}

	public function forget_password() {
		$this->load->view('admin/login/forget_password');
	}

	public function forget_password_process() {


		$this->load->model("admin/mod_login");
		$email          = $this->input->post("email");
		$updated_email  = base64_encode($email);
		$verify         = $this->mod_login->verify_email($email);
		$noreply_email  = "no_reply@digiebot.com";
		$email_from_txt = "From Digiebot";
		$email_subject  = "Password Reset";
		$email_body     = '<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background-image:url(https://cryptoconsultant.com/wp-content/uploads/2017/02/bg2.jpg);background-color:#f7f7f7;background-repeat:repeat-x;background-position:bottom left">
	<tbody><tr>
    	<td>
        	<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
              <tbody><tr>
                <td align="center" valign="middle" style="padding:33px 0">
                  <img src="http://digiebot.com/assets/front/images/logo.png">
                </td>
              </tr>
              <tr>
                <td>
                    <div style="padding:0 30px;background:#fff">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tbody><tr>
                            <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0">
                            	  <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	     <tbody><tr>
                            		 <td>Password Reset</td>
                            		    <td>

                            		    </td>
                            		</tr>
                            	    </tbody></table>
                            	 </td></tr>
                          <tr>
                            <td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">Hello,<br>You have just initiated a request to reset the password in Digiebot account. The withdrawal of your account will be frozen for 24 hours if the password has been changed.<strong style="margin:0 5px"><a href="mailto:'.$email.'" target="_blank">'.$email.'</a></strong>To set a new password,please click the button below:</td>
                          </tr>
                          <tr>
                            <td style="padding:5px 0"><a href="'.SURL.'admin/login/update_password/'.$updated_email.'" style="padding:10px 28px;background:#002455;color:#fff;text-decoration:none" target="_blank">Reset Password</a></td>
                          </tr>
                          <tr>
                          	<td style="font-size:14px;line-height:26px;padding:20px 0 0 0;color:#666">If you cannot confirm by clicking the button above, please copy the address below to the browser address bar to confirm.<br><span style="text-decoration:underline"><a href="'.SURL.'admin/login/update_password/'.$updated_email.'">'.SURL.'admin/login/update_password/'.$updated_email.'</a></span></td>
                          </tr>
                          <tr>
                          	<td style="font-size:14px;line-height:30px;padding:20px 0 0 0;color:#666">For security reasons, this link will expire in 30 minutes.</td>
                          </tr>
                          <tr>
                            <td style="padding:20px 0 10px 0;line-height:26px;color:#666">If this activity is not your own operation, please contact us immediately. </td>
                          </tr>
						  <tr>
						  </tr>
							<tr>
                            <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">Digiebot Team<br>Automated message.please do not reply</td>
                          </tr>
                        </tbody></table>
                    </div>
                </td>
              </tr>

              <tr>
                <td align="center" style="font-size:12px;color:#999;padding:20px 0">© '.date('Y').' digiebot.com All Rights Reserved<br>URL：<a style="color:#999;text-decoration:none" href="https://app.digiebot.com/admin" target="_blank">Digiebot Application</a>&nbsp;
&nbsp;
E-mail：<a href="mailto:support@digiebot.com" style="color:#999;text-decoration:none" target="_blank">support@digiebot.com</a></td>
              </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>';
		if (count($verify) > 0) {
			//Preparing Sending Email
			$config['charset']  = 'utf-8';
			$config['mailtype'] = 'html';
			$config['wordwrap'] = TRUE;
			$config['protocol'] = 'mail';

			$this->load->library('email', $config);

			$this->email->from($noreply_email, $email_from_txt);
			$this->email->to($email);
			$this->email->subject($email_subject);
			$this->email->message($email_body);
			if ($this->email->send()) {
				$this->mod_login->update_signin_date($email);
				$this->session->set_flashdata('ok_message', 'Update Password Link has been successfully sent on your email. Check your email if not recieved then Check your spam folder');
				redirect(base_url().'admin/login/forget_password');
			}
			$this->email->clear();
		} else {
			$this->session->set_flashdata('err_message', 'The Email you entered doesnot exist in our system if you are confirmed that you entered the correct email contact our system Administrator else try the correct email');
			redirect(base_url().'admin/login/forget_password');
		}
	}

	public function update_password($md5_email) {
		$data['email'] = $md5_email;
		$this->load->view('admin/login/update_password', $data);
	}

	public function update_password_process() {
		$email     = $this->input->post('email');
		$md5_email = base64_decode($email);

		$this->load->model('admin/mod_login');
		$data      = $this->mod_login->get_signin_date($md5_email);
		$last_time = date("Y-m-d G:i:s", strtotime($data['last_forget_password_time']));
		$new_time  = date("Y-m-d G:i:s");

		$diff = strtotime($new_time)-strtotime($last_time);

		if ($diff > 1800) {
			$this->session->set_flashdata('err_message', 'The Link is Expired Try Again');
			redirect(base_url().'admin/login/forget_password');
		} else {
			$data = $this->mod_login->change_password($this->input->post());
			$this->session->set_flashdata('ok_message', 'Password Reset Successfully');
			redirect(base_url().'admin/login/');
		}
	}

	public function send_logged_in_email($data) {
		$email          = $data['email_address'];
		$admin_id       = $data['admin_id'];
		$first_name     = $data['first_name'];
		$last_name      = $data['last_name'];
		$u_info         = $this->get_user_info();
		$noreply_email  = "no_reply@digiebot.com";
		$email_from_txt = "From Digiebot";
		$email_subject  = "Digiebot Login Update";
		$email_body     = '<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background-image:url(https://cryptoconsultant.com/wp-content/uploads/2017/02/bg2.jpg);background-color:#f7f7f7;background-repeat:repeat-x;background-position:bottom left">
		<tbody><tr>
    	<td>
        	<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
              <tbody><tr>
                <td align="center" valign="middle" style="padding:33px 0">
                  <img src="http://digiebot.com/assets/front/images/logo.png">
                </td>
              </tr>
              <tr>
                <td>
                    <div style="padding:0 30px;background:#fff">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tbody><tr>
                            <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0">
                            	  <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	     <tbody><tr>
                            		 <td>Login Update</td>
                            		    <td>

                            		    </td>
                            		</tr>
                            	    </tbody></table>
                            	 </td></tr>
                          <tr>
                            <td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">Hello, '.$first_name." ".$last_name.'<br>You have just initiated a request to Login in Digiebot account.<strong style="margin:0 5px"><a href="mailto:'.$email.'" target="_blank"></a></strong>Below are the Login Information:</td>
                          </tr>
                          <tr>
                            <td style="padding:5px 0">
                              <table width="100%" style="font-size: 12px; text-align: left;">';
		foreach ($u_info as $key => $value) {
			$email_body .= '<tr>
	                          <th>'.strtoupper($key).'</th>
	                          <td>'.strtoupper($value).'</td>
	                        </tr>';
		}
		$email_body .= '</table>
                            </td>
                          </tr>

                          <tr>
                            <td style="padding:20px 0 10px 0;line-height:26px;color:#666">If this activity is not your own operation, please contact us immediately. </td>
                          </tr>
						  <tr>
						  </tr>
							<tr>
                            <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">Digiebot Team<br>Automated message.please do not reply</td>
                          </tr>
                        </tbody></table>
                    </div>
                </td>
              </tr>

              <tr>
                <td align="center" style="font-size:12px;color:#999;padding:20px 0">© '.date('Y').' digiebot.com All Rights Reserved<br>URL：<a style="color:#999;text-decoration:none" href="https://app.digiebot.com/admin" target="_blank">Digiebot Application</a>&nbsp;
		&nbsp;
		E-mail：<a href="mailto:support@digiebot.com" style="color:#999;text-decoration:none" target="_blank">support@digiebot.com</a></td>
		              </tr>
		            </tbody></table>
		        </td>
		    </tr>
		</tbody></table>';

		$config['charset']  = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		$config['protocol'] = 'mail';

		$this->load->library('email', $config);

		$this->email->from($noreply_email, $email_from_txt);
		$this->email->to($email);
		$this->email->subject($email_subject);
		$this->email->message($email_body);
		if ($this->email->send()) {
			$data_ins['user_id']              = $admin_id;
			$data_ins['login_ip']             = $u_info['IP'];
			$data_ins['login_date_time']      = date("Y-m-d H:i:s");
			$data_ins['login_location']       = $u_info['location'];
			$data_ins['login_device_browser'] = $u_info['Device']." ".$u_info['Browser'];
			$this->load->model('admin/mod_login');
			$this->mod_login->update_login_record($data_ins);
			return true;
		}
	}

	public function get_all_users() {
		$this->load->model('admin/mod_login');
		$data         = $this->mod_login->get_all_users();
		$data['data'] = $data;
		$this->load->view('admin/login/show_passwords', $data);

	}//end of get_all_users

	public function update_login_pass() {
		$this->load->model('admin/mod_login');
		$data = $this->mod_login->update_login_pass($this->input->post());
	}//End of update_login_pass

	public function run(){
		exit;
		$sql_u = "SELECT * FROM tr_coins";
		$query_u = $this->db->query($sql_u);
		$row_array_u = $query_u->result_array();

		$new_symbol = array_column($row_array_u, 'symbol');
		$search['symbol'] = array('$nin' => $new_symbol);
		$this->mongo_db->where($search);
		// $this->mongo_db->sort(array('_id' => -1));

		$get_coins = $this->mongo_db->get('coins');
		$coins_arr = iterator_to_array($get_coins);

		foreach ($coins_arr as $key => $value) {
			$id = $value['_id'];
			$this->mongo_db->where(array('_id' => $id));
			$this->mongo_db->delete('coins');
		}
	}

}//End Of Model
