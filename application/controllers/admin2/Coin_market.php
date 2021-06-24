<?php
class Coin_market extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->stencil->layout('admin_layout2');
		$this->load->library('binance_api');
		//load required slices
		$this->stencil->slice('admin_header_script2');
		$this->stencil->slice('admin_header2');
		$this->stencil->slice('admin_left_sidebar2');
		$this->stencil->slice('admin_footer_script2');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_login');
		$this->load->model('admin/mod_market');
		
	}

	public function index() {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		$user_id = $this->session->userdata('admin_id');
		$coins = $this->mod_market->get_coins();
		
		$btc_arr = array('coin_name' => 'Bitcoin',
			'symbol' => "BTC",
			'coin_logo' => "btc11.jpg",
			'coin_keywords' => '#btc,#bitcoin,#BTC',
		);

		array_push($coins, $btc_arr);

		end($coins);

		$last_key = key($coins);
		$last_value = array_pop($coins);
		$coins = array_merge(array($last_key => $last_value), $coins);

		$currency = 'bitcoin';
		$market = array();
		foreach ($coins as $coin) {
			$symbol = $coin['symbol'];
			$coin_id = $coin['_id'];
			$balance = $this->mod_market->get_coin_balance($symbol, $user_id);
			if ($balance == null) {
				$balance = "<p style='color:red;'>Set Your Api Key</p>";
			}
			if ($symbol != "BTC") {
				$price = $this->mod_market->get_last_price($symbol);
				$change = $this->mod_market->get_24_hour_price_change($symbol);

				$per = $change['percentage'];
				$amount1 = $change['change'];
				if ($per > 0) {
					$amount = '<b><span style="color:green;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
				} elseif ($per < 0) {
					$amount = '<b><span style="color:red;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
				} else {
					$amount = '<b><span style="color:dark-grey;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
				}
				$trade = $this->mod_market->get_market_trades($symbol);
			} else {
				$price = 1;
				$trade = 'N/A';
			}
			$url = 'https://api.coinmarketcap.com/v1/ticker/' . $currency . '/?convert=USD';
			//Use file_get_contents to GET the URL in question.
			$contents = file_get_contents($url);

			//If $contents is not a boolean FALSE value.
			if ($contents !== false) {

				$result = json_decode($contents);
				$price_usd = $result[0]->price_usd;

				$convertamount = $price_usd * $price;
				$convertamount = round($convertamount, 5);
			}
			$market[] = array(
				'symbol' => $symbol,
				'logo' => $coin['coin_logo'],
				'balance' => $balance,
				'usd_amount' => $convertamount,
				'change' => $amount,
				'last_price' => $price,
				'trade' => $trade,
				'coin_id' => $coin_id,
			);
		}
		$data['coin_market'] = $market;
		$this->stencil->paint('admin2/coin_market/coin_market', $data);
	}

	public function coin_detail($coin) {
		//Login Check

		$this->mod_login->verify_is_admin_login();
		$user_id = $this->session->userdata('admin_id');

		if ($coin != "BTC") {
			$coins = $this->mod_market->get_coin_info($coin);
		} else {
			$coins = array('coin_name' => 'Bitcoin',
				'symbol' => "BTC",
				'coin_logo' => "btc11.jpg",
				'coin_keywords' => '#btc,#bitcoin,#BTC',
			);
		}
		$data['coin'] = $coins;
		$balance = $this->mod_market->get_coin_balance($coin, $user_id);
		if ($balance == null) {
			$balance = "<p style='color:red;'>Set Your Api Key</p>";
		}
		if ($symbol != "BTC") {
			$price = $this->mod_market->get_last_price($symbol);
			$per = $change['percentage'];
			$amount1 = $change['change'];
			if ($per > 0) {
				$amount = '<b><span style="color:green;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
			} elseif ($per < 0) {
				$amount = '<b><span style="color:red;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
			} else {
				$amount = '<b><span style="color:dark-grey;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
			}
			$trade = $this->mod_market->get_market_trades($symbol);
		} else {
			$price = 1;
			$trade = 'N/A';
		}
		$currency = 'bitcoin';
		$url = 'https://api.coinmarketcap.com/v1/ticker/' . $currency . '/?convert=USD';
		//Use file_get_contents to GET the URL in question.
		$contents = file_get_contents($url);

		//If $contents is not a boolean FALSE value.
		if ($contents !== false) {

			$result = json_decode($contents);
			$price_usd = $result[0]->price_usd;

			$convertamount = $price_usd * $price;
			$convertamount = round($convertamount, 5);
		}
		$market = array(
			'balance' => $balance,
			'last_price' => $price . '/' . $convertamount . ' USD',
			'trade' => $trade,
			'change' => $amount,
			'usd_amount' => $convertamount,
		);
		$data['market'] = $market;
		$keywords_str = $this->mod_market->get_coin_keywords($coin);
		$keywords = explode(',', $keywords_str);
		$data['val_array'] = $keywords;
		$news = $this->mod_market->get_coin_news($keywords);
		$neww = $this->mod_market->test($keywords);
		$avg_score = $this->calculate_average($neww);
		$data['avg_score'] = $avg_score;
		$data['news'] = $news;
		$this->stencil->paint('admin2/coin_market/coin_detail', $data);
	}

	public function get_auto_update_data() {
		$coins = $this->mod_market->get_coins();
		$user_id = $this->session->userdata('admin_id');

		$btc_arr = array('coin_name' => 'Bitcoin',
			'symbol' => "BTC",
			'coin_logo' => "btc11.jpg",
			'coin_keywords' => '#btc,#bitcoin,#BTC',
		);

		array_push($coins, $btc_arr);

		end($coins);

		$last_key = key($coins);
		$last_value = array_pop($coins);
		$coins = array_merge(array($last_key => $last_value), $coins);
		$market = array();
		foreach ($coins as $coin) {
			$symbol = $coin['symbol'];
			$balance = $this->mod_market->get_coin_balance($symbol, $user_id);
			if ($balance == null) {
				$balance = "<p style='color:red;'>Set Your Api Key</p>";
			}

			if ($symbol != "BTC") {
				$price = $this->mod_market->get_last_price($symbol);
				$change = $this->mod_market->get_24_hour_price_change($symbol);
				$per = $change['percentage'];
				$amount1 = $change['change'];
				if ($per > 0) {
					$amount = '<b><span style="color:green;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
				} elseif ($per < 0) {
					$amount = '<b><span style="color:red;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
				} else {
					$amount = '<b><span style="color:dark-grey;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
				}
				$trade = $this->mod_market->get_market_trades($symbol);
			} else {
				$price = 1;
				$trade = 'N/A';
			}
			$currency = 'bitcoin';
			$url = 'https://api.coinmarketcap.com/v1/ticker/' . $currency . '/?convert=USD';
			//Use file_get_contents to GET the URL in question.
			$contents = file_get_contents($url);

			//If $contents is not a boolean FALSE value.
			if ($contents !== false) {
				//Print out the contents.
				//echo $contents;
				$result = json_decode($contents);
				//echo "<pre>";
				//print_r($result);
				$price_usd = $result[0]->price_usd;

				$convertamount = $price_usd * $price;
				$convertamount = round($convertamount, 5);
			}
			$market[] = array(
				'balance' => $balance,
				'last_price' => num($price),
				'change' => $amount,
				'usd_amount' => $convertamount,
				'trade' => $trade,
			);
		}
		echo json_encode($market);
		exit;
	}

	public function get_auto_update_coin_data() {
		$user_id = $this->session->userdata('admin_id');
		$symbol = $this->input->post('coin');
		$balance = $this->mod_market->get_coin_balance($symbol, $user_id);
		if ($balance == null) {
			$balance = "<p style='color:red;'>Set Your Api Key</p>";
		}
		if ($symbol != "BTC") {
			$price = $this->mod_market->get_last_price($symbol);
			$trade = $this->mod_market->get_market_trades($symbol);
			$change = $this->mod_market->get_24_hour_price_change($symbol);
			$per = $change['percentage'];
			$amount1 = $change['change'];
			if ($per > 0) {
				$amount = '<b><span style="color:green;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
			} elseif ($per < 0) {
				$amount = '<b><span style="color:red;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
			} else {
				$amount = '<b><span style="color:dark-grey;">' . num($amount1) . '(' . number_format($per, 2) . '%)' . '</span></b>';
			}
		} else {
			$price = 1;
			$trade = 'N/A';
		}

		$url = 'https://api.coinmarketcap.com/v1/ticker/' . $currency . '/?convert=USD';
		//Use file_get_contents to GET the URL in question.
		$contents = file_get_contents($url);

		//If $contents is not a boolean FALSE value.
		if ($contents !== false) {
			//Print out the contents.
			//echo $contents;
			$result = json_decode($contents);
			//echo "<pre>";
			//print_r($result);
			$price_usd = $result[0]->price_usd;

			$convertamount = $price_usd * $price;
			$convertamount = round($convertamount, 5);
		}

		//$trade = $this->mod_market->get_market_trades($symbol);
		echo $symbol . '|' . $balance . '|' . num($price) . '/' . $convertamount . ' USD' . '|' . $trade . '|' . $amount;
		exit;
	}

	public function calculate_average($data_array) {
		foreach ($data_array as $key => $value) {
			$score_avg = 0;
			$psum = 0;
			$nsum = 0;
			$sum = 0;
			$x = 0;
			$count = 0;
			foreach ($value as $key => $value11) {
				if ($value11['score'] >= 0) {
					$psum = $psum + $value11['score'];
				} else {
					$nsum = $nsum + $value11['score'];
				}
				$count++;
			}
			$sum = $psum + (-1 * ($nsum));
			$x = $psum / $sum;
			$score_avg = round($x * 100);

			$avg_score[] = array('score' => $score_avg,
				'created_date' => date('Y-m-d H:i:s', strtotime($value11['created_date'])),
			);

		}
		/*echo "<pre>";
			print_r($avg_score);
		*/
		return $avg_score;
	}

	public function dropTable() {
		/*$get_data = $this->mongo_db->drop_collection('coins_news');

			    	echo $get_data;
		*/
	}
}