<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sentiment extends CI_Controller {

	public function __construct() {

		parent::__construct();
		//load main template
		$this->stencil->layout('admin_layout');
		//load main template
		$this->stencil->layout('admin_layout');
		//load required slices
		$this->stencil->slice('admin_header_script');
		$this->stencil->slice('admin_header');
		$this->stencil->slice('admin_left_sidebar');
		$this->stencil->slice('admin_footer_script');
		// Load Modal
		$this->load->model('admin/mod_sentiment');
		$this->load->model('admin/mod_coins');
		//$this->load->library('twconnect');
		 //$this->load->library('twitter');
	}
	
	public function secondTwitterName()
    {
		
		$source='twitter';
		$this->load->file('application/libraries/lib/autoload.php');
	    $this->load->file('application/libraries/lib/config.php');
	    $this->load->file('application/libraries/lib/TwitterSentimentAnalysis.php');
		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		
		
		 $TwitterSentimentAnalysis = new TwitterSentimentAnalysis(DATUMBOX_API_KEY,TWITTER_CONSUMER_KEY,TWITTER_CONSUMER_SECRET,TWITTER_ACCESS_KEY,TWITTER_ACCESS_SECRET);  
		
		foreach($coins_arr as $key1 => $row2){
		
		$keyword =  $row2['coin_name'];
		$symbol =  $row2['symbol'];
		 
		 $twitterSearchParams=array(
				'q'      =>$keyword,
				'lang'   =>'en',
				'count'  =>200,
				'max_id' =>$lastTweetIdnew
         );
        $results=$TwitterSentimentAnalysis->sentimentAnalysis($twitterSearchParams);
        $sentiment        = new \PHPInsight\Sentiment();
		
					foreach ($results as $key => $row) {
						
						$text               = $row['text'];
						$created_at         = $row['created_at'];
						$tweetId            = $row['id'];
						$scores             = $sentiment->score($text);
						$class              = $sentiment->categorise($text);
						$negative_sentiment = $scores['neg'];
						$positive_sentiment = $scores['pos'];
						$neutral_sentiment  = $scores['neu'];
						
						$this->mongo_db->where('tweet_id', $tweetId);
						$responseArr = $this->mongo_db->get('tweets_sent_report');
						$responseArr = iterator_to_array($responseArr);
						
						//echo "<pre>";  print_r($responseArr); exit;
						
						
						if(count($responseArr)>0){}else{
							
							$ins_arr = array(
								'tweet_id' => $tweetId,
								'source'   => $source,
								'keyword'  => $symbol,
								'text'     => $text,
								'negative_sentiment' => (float) $negative_sentiment,
								'positive_sentiment' => (float) $positive_sentiment,
								'neutral_sentiment' => (float) $neutral_sentiment,
								'created_date'       => $this->mongo_db->converToMongodttime($created_at),
								'created_date_human_readable' => $created_at,
								'sentiment_rating'            => (float) $scores,
								'sentiment_calculations'      => $class,
							);
							
							$ins_id = $this->mongo_db->insert("tweets_sent_report", $ins_arr); 
					    
						}
						  
					}
		}
    }
	
	public function secondTwitterSymbol($keyword, $lastTweetId)
    {
		
		$source='twitter';
		$this->load->file('application/libraries/lib/autoload.php');
	    $this->load->file('application/libraries/lib/config.php');
	    $this->load->file('application/libraries/lib/TwitterSentimentAnalysis.php');
		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		
		
		 $TwitterSentimentAnalysis = new TwitterSentimentAnalysis(DATUMBOX_API_KEY,TWITTER_CONSUMER_KEY,TWITTER_CONSUMER_SECRET,TWITTER_ACCESS_KEY,TWITTER_ACCESS_SECRET);  
		
		foreach($coins_arr as $key1 => $row2){
		
		$keyword =  $row2['symbol'];
		 
		 $twitterSearchParams=array(
				'q'      =>$symbol,
				'lang'   =>'en',
				'count'  =>200,
				'max_id' =>$lastTweetIdnew
         );
        $results=$TwitterSentimentAnalysis->sentimentAnalysis($twitterSearchParams);
		
        $sentiment        = new \PHPInsight\Sentiment();
		
					foreach ($results as $key => $row) {
						
						$text               = $row['text'];
						$created_at         = $row['created_at'];
						$tweetId            = $row['id'];
						$scores             = $sentiment->score($text);
						$class              = $sentiment->categorise($text);
						$negative_sentiment = $scores['neg'];
						$positive_sentiment = $scores['pos'];
						$neutral_sentiment  = $scores['neu'];
						
						$this->mongo_db->where('tweet_id', $tweetId);
						$responseArr = $this->mongo_db->get('tweetsrep');
						$responseArr = iterator_to_array($responseArr);
						
						if(count($responseArr)>0){}else{
							
							$ins_arr = array(
								'tweet_id' => $tweetId,
								'source'   => $source,
								'keyword'  => $symbol,
								'text'     => $text,
								'negative_sentiment' => (float) $negative_sentiment,
								'positive_sentiment' => (float) $positive_sentiment,
								'neutral_sentiment' => (float) $neutral_sentiment,
								'created_date'       => $this->mongo_db->converToMongodttime($created_at),
								'created_date_human_readable' => $created_at,
								'sentiment_rating'            => (float) $scores,
								'sentiment_calculations'      => $class,
							);
							
							$ins_id = $this->mongo_db->insert("tweets_sent_report", $ins_arr); 
					    
						}
						  
					}
		}
    }
	
	
	public function importTableCronReddit() {
		
		$sql = "SELECT * from tr_reddit_comments";
		$query = $this->db->query($sql);
		$res_arr = $query->result_array();
		
		foreach ($res_arr as $key => $value) {
				
			$reddit_id     = $value['reddit_id'];
			$red_id        = $value['id'];
			$source   = $value['source'];
			$keyword  = $value['keyword'];
			$text     = $value['title'];
			$negative_sentiment = $value['negative_sentiment'];
			$neutral_sentiment  = $value['neutral_sentiment'];
			$positive_sentiment = $value['positive_sentiment'];
			$class              = $value['class'];
			$score              = $value['score'];
			$created_date       = date("Y-m-d H:i:s", ($value['created_at']));
			
			$sentiment_rating   = $value['sentiment_rating'];
			$sentiment_calculations = $value['sentiment_calculations'];

			$ins_arr = array(
				'reddit_id' => $reddit_id,
				'source'   => $source,
				'keyword'  => $keyword,
				'text'     => $text,
				'negative_sentiment' => (float) $negative_sentiment,
				'neutral_sentiment'  => (float) $neutral_sentiment,
				'positive_sentiment' => (float) $positive_sentiment,
				'created_date'       => $this->mongo_db->converToMongodttime($created_date),
				'created_date_human_readable'       => $created_date,
				'class'   => (float) $class,
				'score'   => (float) $score,
				'sentiment_calculations' => $sentiment_calculations,
			);
			$ins_id = $this->mongo_db->insert("reddi_comments", $ins_arr);
				
			$upd_arr = array(
				'mongoID' => (string) $ins_id,
			);

			$this->db->where("id", $red_id);
			$update  = $this->db->update("reddit_comments", $upd_arr);
			
		} //end foreach
		
	}
	
	
	public function redditMongo(){
		$this->load->file('application/libraries/lib/Reddit.php');
		$reddit = new reddit();
		$this->load->file('application/libraries/lib/autoload.php');
		
		
		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;
		
		
		foreach($coins_arr as $coin){
		
		
		$keyword =  $coin['coin_name'];
		
		if ($_GET['after']) {
			$after = $_GET['after'];
		} else {
			$after = '';
		}
		$sentiment   = new \PHPInsight\Sentiment();
		$redditArray = $reddit->search($keyword, "news", 200, '', $after);

		$mainRedditArray = array();
		$mainRedditArray = $redditArray->data->children;
		$count           = count($mainRedditArray);
		$totalrecord     = $count;
		$totalNewrecord  = $count - 1;
        foreach ($mainRedditArray as $key => $row) {
            $title          = $row->data->title;
            $description    = $row->data->selftext;
            $created        = $row->data->created;
            $permalink      = $row->data->permalink;
            $id             = $row->data->id;
            $score          = $row->data->score;
			
            $this_tweet_day = date('D. M j, Y', ($created));
            // calculations:
            $scores         = $sentiment->score($title);
            $class          = $sentiment->categorise($title);
            $rating_from    = 'title';
            if ($class == 'neu') {
                $description = $row->data->selftext;
                $scores      = $sentiment->score($description);
                $class       = $sentiment->categorise($description);
                $rating_from = 'description';
            }
            $negative_sentiment = $scores['neg'];
            $positive_sentiment = $scores['pos'];
            $neutral_sentiment  = $scores['neu'];
            
            $description        = str_replace('"', '', $description);
            $title              = str_replace('"', '', $title);
            $created_date       = date('Y-m-d G:i:s');
			
			
            $ins_data           = array(
                'reddit_id' => $this->db->escape_str(trim($id)),
                'source' => $this->db->escape_str(trim('reddit')),
                'keyword' => $this->db->escape_str(trim($keyword)),
                'title' => $this->db->escape_str($title),
                'description' => $this->db->escape_str(trim($description)),
                'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
                'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
                'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
                'created_at' => $this->db->escape_str(trim($this->mongo_db->converToMongodttime($created))),
                'origional_date' => $this->db->escape_str(trim($created)),
                'sentiment_rating' => $this->db->escape_str(trim()),
                'class' => $this->db->escape_str(trim($class)),
                'score' => $this->db->escape_str(trim($score))
            );
			
				
			$ins_id = $this->mongo_db->insert("reddits", $ins_data);
            
            //Insert the record into the database.
            //$this->db->dbprefix('reddit');
            //$ins_into_db = $this->db->insert('reddit', $ins_data);
            
            //******************************* Insert Comments into DB *****************************//
            $dataArray   = json_decode(file_get_contents('https://www.reddit.com' . $permalink . '.json'));
            
            foreach ($dataArray as $articles) {
                foreach ($articles->data->children as $key => $article) {
                    if ($key == 0) {
                        $score              = $article->data->score;
                        $parent_id          = $article->data->parent_id;
                        $comment            = $article->data->body;
                        $comment            = str_replace('"', '', $comment);
                        $created            = $article->data->created;
                        $subreddit_id       = $article->data->subreddit_id;
                        // calculations:
                        $scores_comment     = $sentiment->score($comment);
                        $class_comment      = $sentiment->categorise($comment);
                        $negative_sentiment = $scores_comment['neg'];
                        $positive_sentiment = $scores_comment['pos'];
                        $neutral_sentiment  = $scores_comment['neu'];
                        $created_date       = date('Y-m-d G:i:s');
						
                        $ins_data           = array(
                            'reddit_id' => $this->db->escape_str(trim($id)),
                            'source' => $this->db->escape_str(trim('reddit')),
                            'keyword' => $this->db->escape_str(trim($keyword)),
                            'title' => $this->db->escape_str($comment),
                            'description' => $this->db->escape_str(trim($description)),
                            'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
                            'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
                            'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
                            'created_at' => $this->db->escape_str(trim($this->mongo_db->converToMongodttime($created))),
                            'origional_date' => $this->db->escape_str(trim($created)),
                            'sentiment_rating' => $this->db->escape_str(trim()),
                            'class' => $this->db->escape_str(trim($class_comment)),
                            'score' => $this->db->escape_str(trim($score))
                        );
                        //Insert the record into the database.
						$ins_id = $this->mongo_db->insert("reddit_comments", $ins_data);
                        //$this->db->dbprefix('reddit_comments');
                        //$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
                    } else {
                        $score              = $article->data->score;
                        $parent_id          = $article->data->parent_id;
                        $comment            = $article->data->body;
                        $comment            = str_replace('"', '', $comment);
                        $created            = $article->data->created;
                        $subreddit_id       = $article->data->subreddit_id;
                        // calculations:
                        $scores_comment     = $sentiment->score($comment);
                        $class_comment      = $sentiment->categorise($comment);
                        $negative_sentiment = $scores_comment['neg'];
                        $positive_sentiment = $scores_comment['pos'];
                        $neutral_sentiment  = $scores_comment['neu'];
                        $created_date       = date('Y-m-d G:i:s');
                        $ins_data           = array(
                            'reddit_id' => $this->db->escape_str(trim($id)),
                            'source' => $this->db->escape_str(trim('reddit')),
                            'keyword' => $this->db->escape_str(trim($keyword)),
                            'title' => $this->db->escape_str($comment),
                            'description' => $this->db->escape_str(trim($description)),
                            'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
                            'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
                            'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
                            'created_at' => $this->db->escape_str(trim($this->mongo_db->converToMongodttime($created))),
                            'origional_date' => $this->db->escape_str(trim($created)),
                            'sentiment_rating' => $this->db->escape_str(trim()),
                            'class' => $this->db->escape_str(trim($class_comment)),
                            'score' => $this->db->escape_str(trim($score))
                        );
                        //Insert the record into the database.
						$ins_id = $this->mongo_db->insert("reddit_comments", $ins_data);
                        //$this->db->dbprefix('reddit_comments');
                        //$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
                        foreach ($article->data->replies->data->children as $reply) {
                            $comment_reply          = $reply->data->body;
                            $comment_reply          = str_replace('"', '', $comment_reply);
                            $score_reply            = $reply->data->score;
                            $score_reply            = $reply->data->score;
                            $parent_id              = $reply->data->parent_id;
                            $link_id                = $reply->data->link_id;
                            $created_reply          = $article->data->created;
                            // calculations:
                            $scores_comment_rep     = $sentiment->score($comment_reply);
                            $classs_comment_rep     = $sentiment->categorise($comment_reply);
                            $negative_sentiment_rep = $scores_comment_rep['neg'];
                            $positive_sentiment_rep = $scores_comment_rep['pos'];
                            $neutral_sentiment_rep  = $scores_comment_rep['neu'];
                            $ins_data               = array(
                                'reddit_id' => $this->db->escape_str(trim($link_id)),
                                'source' => $this->db->escape_str(trim('reddit')),
                                'keyword' => $this->db->escape_str(trim($keyword)),
                                'title' => $this->db->escape_str($comment_reply),
                                'description' => $this->db->escape_str(trim($description)),
                                'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment_rep)),
                                'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment_rep)),
                                'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment_rep)),
                                'created_at' => $this->db->escape_str(trim($this->mongo_db->converToMongodttime($created))),
                                'origional_date' => $this->db->escape_str(trim($created)),
                                'sentiment_rating' => $this->db->escape_str(trim()),
                                'class' => $this->db->escape_str(trim($classs_comment_rep)),
                                'score' => $this->db->escape_str(trim($score_reply))
                            );
                            //Insert the record into the database.
							$ins_id = $this->mongo_db->insert("reddit_comments", $ins_data);
							echo $ins_id;
							echo "<br />";
                            //$this->db->dbprefix('reddit_comments');
                            //$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
                        }
                    }
				}
            }
        }
	  }
    }
	
	
	public function redditCoinName(){
        $this->load->file('application/libraries/lib/Reddit.php');
        $reddit = new reddit();
        $this->load->file('application/libraries/lib/autoload.php');
        
		
		
		$coins_arr = $this->mod_coins->get_all_coins();
		
		foreach($coins_arr as $coin){
			
				
			$keyword =  $coin['symbol'];
					
			if ($_GET['after']) {
				$after = $_GET['after'];
			} else {
				$after = '';
			}
			$sentiment   = new \PHPInsight\Sentiment();
			$redditArray = $reddit->search($keyword, "news", 200, '', $after);
			
			
			
			$mainRedditArray = array();
			$mainRedditArray = $redditArray->data->children;
			$count           = count($mainRedditArray);
			$totalrecord     = $count;
			$totalNewrecord  = $count - 1;
			
			foreach ($mainRedditArray as $key => $row) {
				$title          = $row->data->title;
				$description    = $row->data->selftext;
				$created        = $row->data->created;
				$permalink      = $row->data->permalink;
				$id             = $row->data->id;
				$score          = $row->data->score;
				$this_tweet_day = date('D. M j, Y', ($created));
				// calculations:
				$scores         = $sentiment->score($title);
				$class          = $sentiment->categorise($title);
				$rating_from    = 'title';
				if ($class == 'neu') {
					$description = $row->data->selftext;
					$scores      = $sentiment->score($description);
					$class       = $sentiment->categorise($description);
					$rating_from = 'description';
				}
				$negative_sentiment = $scores['neg'];
				$positive_sentiment = $scores['pos'];
				$neutral_sentiment  = $scores['neu'];
				
				$description        = str_replace('"', '', $description);
				$title              = str_replace('"', '', $title);
				$created_date       = date('Y-m-d G:i:s');
				
				
				$this->db->dbprefix('reddit');
				$this->db->like('title', $title);
				$this->db->like('created_at', $created);
				$get_redditRecord = $this->db->get('reddit');
		
				//echo $this->db->last_query();
				$row_reddit= $get_redditRecord->result_array();
				
				if($row_reddit>0){}else{
				
					$ins_data           = array(
						'reddit_id' => $this->db->escape_str(trim($id)),
						'source' => $this->db->escape_str(trim('reddit')),
						'keyword' => $this->db->escape_str(trim($keyword)),
						'title' => $this->db->escape_str($title),
						'description' => $this->db->escape_str(trim($description)),
						'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
						'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
						'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
						'created_at' => $this->db->escape_str(trim($created)),
						'origional_date' => $this->db->escape_str(trim()),
						'sentiment_rating' => $this->db->escape_str(trim()),
						'class' => $this->db->escape_str(trim($class)),
						'score' => $this->db->escape_str(trim($score))
					);
					
					//Insert the record into the database.
					$this->db->dbprefix('reddits');
					$ins_into_db = $this->db->insert('reddits', $ins_data);
					
					
					$ins_data           = array(
						'reddit_id' => $this->db->escape_str(trim($id)),
						'source' => $this->db->escape_str(trim('reddit')),
						'keyword' => $this->db->escape_str(trim($keyword)),
						'title' => $this->db->escape_str($title),
						'description' => $this->db->escape_str(trim($description)),
						'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
						'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
						'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
						'created_at' => $this->db->escape_str(trim($this->mongo_db->converToMongodttime($created))),
						'origional_date' => $this->db->escape_str(trim($created)),
						'sentiment_rating' => $this->db->escape_str(trim()),
						'class' => $this->db->escape_str(trim($class)),
						'score' => $this->db->escape_str(trim($score))
					);
				
					
					$ins_id = $this->mongo_db->insert("reddits", $ins_data);
				
					
					
					
					
					
				}
				
				//******************************* Insert Comments into DB *****************************//
				$dataArray   = json_decode(file_get_contents('https://www.reddit.com' . $permalink . '.json'));
				
				
				//echo "<pre>";  print_r($dataArray); exit;
				
				foreach ($dataArray as $articles) {
					foreach ($articles->data->children as $key => $article) {
						if ($key == 0) {
							$score              = $article->data->score;
							$parent_id          = $article->data->parent_id;
							$comment            = $article->data->selftext;
							$comment            = str_replace('"', '', $comment);
							$created            = $article->data->created;
							$subreddit_id       = $article->data->subreddit_id;
							// calculations:
							$scores_comment     = $sentiment->score($comment);
							$class_comment      = $sentiment->categorise($comment);
							$negative_sentiment = $scores_comment['neg'];
							$positive_sentiment = $scores_comment['pos'];
							$neutral_sentiment  = $scores_comment['neu'];
							$created_date       = date('Y-m-d G:i:s');
							
							
							
							
							$this->db->dbprefix('reddit_comments');
							$this->db->like('title', $comment);
							$this->db->like('created_at', $created);
							$get_redditRecord = $this->db->get('reddit_comments');
							//echo $this->db->last_query();
							$row_reddit= $get_redditRecord->result_array();
								
							if($row_reddit>0){}else{
							
							
								$ins_data           = array(
									'reddit_id' => $this->db->escape_str(trim($id)),
									'source' => $this->db->escape_str(trim('reddit')),
									'keyword' => $this->db->escape_str(trim($keyword)),
									'title' => $this->db->escape_str($comment),
									'description' => $this->db->escape_str(trim($description)),
									'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
									'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
									'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
									'created_at' => $this->db->escape_str(trim($created)),
									'origional_date' => $this->db->escape_str(trim()),
									'sentiment_rating' => $this->db->escape_str(trim()),
									'class' => $this->db->escape_str(trim($class_comment)),
									'score' => $this->db->escape_str(trim($score))
								);
								//Insert the record into the database.
								$this->db->dbprefix('reddit_comments');
								$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
							}
						} else {
							$score              = $article->data->score;
							$parent_id          = $article->data->parent_id;
							$comment            = $article->data->body;
							$comment            = str_replace('"', '', $comment);  
							$created            = $article->data->created;
							$subreddit_id       = $article->data->subreddit_id;
							// calculations:
							$scores_comment     = $sentiment->score($comment);
							$class_comment      = $sentiment->categorise($comment);
							$negative_sentiment = $scores_comment['neg'];
							$positive_sentiment = $scores_comment['pos'];
							$neutral_sentiment  = $scores_comment['neu'];
							$created_date       = date('Y-m-d G:i:s');
							
							$this->db->dbprefix('reddit_comments');
							$this->db->like('title', $comment);
							$this->db->like('created_at', $created);
							$get_redditRecord = $this->db->get('reddit_comments');
							//echo $this->db->last_query();   exit;
							$row_reddit= $get_redditRecord->result_array();
								
							if($row_reddit>0){}else{
							
								$ins_data           = array(
									'reddit_id' => $this->db->escape_str(trim($id)),
									'source' => $this->db->escape_str(trim('reddit')),
									'keyword' => $this->db->escape_str(trim($keyword)),
									'title' => $this->db->escape_str($comment),
									'description' => $this->db->escape_str(trim($description)),
									'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
									'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
									'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
									'created_at' => $this->db->escape_str(trim($created)),
									'origional_date' => $this->db->escape_str(trim()),
									'sentiment_rating' => $this->db->escape_str(trim()),
									'class' => $this->db->escape_str(trim($class_comment)),
									'score' => $this->db->escape_str(trim($score))
								);
								//Insert the record into the database.
								$this->db->dbprefix('reddit_comments');
								$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
							}
							foreach ($article->data->replies->data->children as $reply) {
								$comment_reply          = $reply->data->body;
								$comment_reply          = str_replace('"', '', $comment_reply);
								$score_reply            = $reply->data->score;
								$score_reply            = $reply->data->score;
								$parent_id              = $reply->data->parent_id;
								$link_id                = $reply->data->link_id;
								$created_reply          = $article->data->created;
								// calculations:
								$scores_comment_rep     = $sentiment->score($comment_reply);
								$classs_comment_rep     = $sentiment->categorise($comment_reply);
								$negative_sentiment_rep = $scores_comment_rep['neg'];
								$positive_sentiment_rep = $scores_comment_rep['pos'];
								$neutral_sentiment_rep  = $scores_comment_rep['neu'];
								
								
								$this->db->dbprefix('reddit_comments');
								$this->db->like('title', $comment_reply);
								$this->db->like('created_at', $created);
								$get_redditRecord = $this->db->get('reddit_comments');
								//echo $this->db->last_query();
								$row_reddit= $get_redditRecord->result_array();
									
								if($row_reddit>0){

								}else{
								
									$ins_data               = array(
										'reddit_id' => $this->db->escape_str(trim($link_id)),
										'source' => $this->db->escape_str(trim('reddit')),
										'keyword' => $this->db->escape_str(trim($keyword)),
										'title' => $this->db->escape_str($comment_reply),
										'description' => $this->db->escape_str(trim($description)),
										'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment_rep)),
										'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment_rep)),
										'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment_rep)),
										'created_at' => $this->db->escape_str(trim($created_reply)),
										'origional_date' => $this->db->escape_str(trim()),
										'sentiment_rating' => $this->db->escape_str(trim()),
										'class' => $this->db->escape_str(trim($classs_comment_rep)),
										'score' => $this->db->escape_str(trim($score_reply))
									);
									//Insert the record into the database.
									$this->db->dbprefix('reddit_comments');
									$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
								}
							}
						}
					}
				}
			}
        }
    }
	
	
	public function redditsymbol()//////////////////
	{
		
		$delete = $this->mongo_db->drop_collection('redditnews');
		$delete = $this->mongo_db->drop_collection('reddi_comments');
	
		
        $this->load->file('application/libraries/lib/Reddit.php');
        $reddit = new reddit();
        $this->load->file('application/libraries/lib/autoload.php');
        
		$coins_arr = $this->mod_coins->get_all_coins();
		
		foreach($coins_arr as $coin){
			
			$keyword =  $coin['symbol'];
			
			if ($_GET['after']) {
				$after = $_GET['after'];
			} else {
				$after = '';
			}
			$sentiment   = new \PHPInsight\Sentiment();
			$redditArray = $reddit->search($keyword, "news", 200, '', $after);
			
			$mainRedditArray = array();
			$mainRedditArray = $redditArray->data->children;
			$count           = count($mainRedditArray);
			$totalrecord     = $count;
			$totalNewrecord  = $count - 1;
		
		
	
		
			foreach ($mainRedditArray as $key => $row) {
				
				
				$title          = $row->data->title;
				$description    = $row->data->selftext;
				$created        = $row->data->created;
				$permalink      = $row->data->permalink;
				$id             = $row->data->id;
				$score          = $row->data->score;
				$this_tweet_day = date('D. M j, Y', ($created));
				// calculations:
				$scores         = $sentiment->score($title);
				
				
				$class          = $sentiment->categorise($title);
				$rating_from    = 'title';
				if ($class == 'neu') {
					//$description = $row->data->selftext;
					$scores      = $sentiment->score($description);
					$class       = $sentiment->categorise($description);
					$rating_from = 'description';
				}
				$negative_sentiment = $scores['neg'];
				$positive_sentiment = $scores['pos'];
				$neutral_sentiment  = $scores['neu'];
				
				$description        = str_replace('"', '', $description);
				$title              = str_replace('"', '', $title);
				$created_date       = date('Y-m-d G:i:s');
				
			
					$ins_arr = array(
						'reddit_id' => $id,
						'source'   => 'reddit',
						'keyword'  => $keyword,
						'text'     => $title,
						'description'     => $description,
						'negative_sentiment' => (float) $negative_sentiment,
						'neutral_sentiment'  => (float) $neutral_sentiment,
						'positive_sentiment' => (float) $positive_sentiment,
						'created_date'       => $this->mongo_db->converToMongodttime($this_tweet_day),
						'created_date_human_readable'       => $this_tweet_day,
						'class'   => (float) $class,
						'score'   => (float) $score,
						'sentiment_calculations' => $sentiment_calculations,
					);
					
					$ins_id = $this->mongo_db->insert("redditnews", $ins_arr);
								
				//******************************* Insert Comments into DB *****************************//
				$dataArray   = json_decode(file_get_contents('https://www.reddit.com' . $permalink . '.json'));
				
				
				//echo "<pre>";  print_r($dataArray); exit;
				
				foreach ($dataArray as $articles) {
					foreach ($articles->data->children as $key => $article) {
						if ($key == 0) {
							$score              = $article->data->score;
							$parent_id          = $article->data->parent_id;
							$comment            = $article->data->selftext;
							$comment            = str_replace('"', '', $comment);
							$created            = $article->data->created;
							$subreddit_id       = $article->data->subreddit_id;
							$this_tweet_day     = date('D. M j, Y', ($created));
							// calculations:
							$scores_comment     = $sentiment->score($comment);
							$class_comment      = $sentiment->categorise($comment);
							$negative_sentiment = $scores_comment['neg'];
							$positive_sentiment = $scores_comment['pos'];
							$neutral_sentiment  = $scores_comment['neu'];
							$created_date       = date('Y-m-d G:i:s');
							
							
							/*
							
							$this->db->dbprefix('reddit_comments');
							//$this->db->like('title', $comment);
							$this->db->like('created_at', $created);
							$get_redditRecord = $this->db->get('reddit_comments');
							//echo $this->db->last_query();
							$row_reddit= $get_redditRecord->result_array();*/
								
							//if($row_reddit>0){}else{
							
								
								$ins_arr = array(
									'reddit_id' => $id,
									'source'   => 'reddit',
									'keyword'  => $keyword,
									'text'     => $comment,
									'description'     => $description,
									'negative_sentiment' => (float) $negative_sentiment,
									'neutral_sentiment'  => (float) $neutral_sentiment,
									'positive_sentiment' => (float) $positive_sentiment,
									'created_date'       => $this->mongo_db->converToMongodttime($this_tweet_day),
									'created_date_human_readable'       => $this_tweet_day,
									'class'   => (float) $class,
									'score'   => (float) $score,
									'sentiment_calculations' => $sentiment_calculations,
								);
								$ins_id = $this->mongo_db->insert("reddi_comments", $ins_arr);
								
								
						//}
						} else {
							$score              = $article->data->score;
							$parent_id          = $article->data->parent_id;
							$comment            = $article->data->body;
							$comment            = str_replace('"', '', $comment);  
							$created            = $article->data->created;
							$subreddit_id       = $article->data->subreddit_id;
							$this_tweet_day     = date('D. M j, Y', ($created));
							// calculations:
							$scores_comment     = $sentiment->score($comment);
							$class_comment      = $sentiment->categorise($comment);
							$negative_sentiment = $scores_comment['neg'];
							$positive_sentiment = $scores_comment['pos'];
							$neutral_sentiment  = $scores_comment['neu'];
							$created_date       = date('Y-m-d G:i:s');
							
							$this->db->dbprefix('reddit_comments');
							//$this->db->like('title', $comment);
							$this->db->like('created_at', $created);
							$get_redditRecord = $this->db->get('reddit_comments');
							//echo $this->db->last_query();   exit;
							$row_reddit= $get_redditRecord->result_array();
								
							//if($row_reddit>0){}else{
							
								
								$ins_arr = array(
									'reddit_id' => $id,
									'source'   => 'reddit',
									'keyword'  => $keyword,
									'text'     => $comment,
									'description'     => $description,
									'negative_sentiment' => (float) $negative_sentiment,
									'neutral_sentiment'  => (float) $neutral_sentiment,
									'positive_sentiment' => (float) $positive_sentiment,
									'created_date'       => $this->mongo_db->converToMongodttime($this_tweet_day),
									'created_date_human_readable'       => $this_tweet_day,
									'class'   => (float) $class,
									'score'   => (float) $score,
									'sentiment_calculations' => $sentiment_calculations,
								);
								$ins_id = $this->mongo_db->insert("reddi_comments", $ins_arr);
								
								
							//}
							foreach ($article->data->replies->data->children as $reply) {
								$comment_reply          = $reply->data->body;
								$comment_reply          = str_replace('"', '', $comment_reply);
								$score_reply            = $reply->data->score;
								$score_reply            = $reply->data->score;
								$parent_id              = $reply->data->parent_id;
								$link_id                = $reply->data->link_id;
								$created_reply          = $article->data->created;
								$this_tweet_day     = date('D. M j, Y', ($created_reply));
								// calculations:
								$scores_comment_rep     = $sentiment->score($comment_reply);
								$classs_comment_rep     = $sentiment->categorise($comment_reply);
								$negative_sentiment_rep = $scores_comment_rep['neg'];
								$positive_sentiment_rep = $scores_comment_rep['pos'];
								$neutral_sentiment_rep  = $scores_comment_rep['neu'];
								
								
								/*$this->db->dbprefix('reddit_comments');
								//$this->db->like('title', $comment_reply);
								$this->db->like('created_at', $created);
								$get_redditRecord = $this->db->get('reddit_comments');
								//echo $this->db->last_query();
								$row_reddit= $get_redditRecord->result_array();*/
									
								//if($row_reddit>0){}else{
								
									$ins_arr = array(
									'reddit_id' => $link_id,
									'source'   => 'reddit',
									'keyword'  => $keyword,
									'text'     => $comment_reply,
									'description'     => $description,
									'negative_sentiment' => (float) $negative_sentiment_rep,
									'neutral_sentiment'  => (float) $neutral_sentiment_rep,
									'positive_sentiment' => (float) $positive_sentiment_rep,
									'created_date'       => $this->mongo_db->converToMongodttime($this_tweet_day),
									'created_date_human_readable'       => $this_tweet_day,
									'class'   => (float) $class,
									'score'   => (float) $score,
									'sentiment_calculations' => $sentiment_calculations,
								);
								$ins_id = $this->mongo_db->insert("reddi_comments", $ins_arr);
								
								
								
								
							//}
							}
						}
						}
					}
				}
			}
		
		
			/// Secodn Goe here
			
			foreach($coins_arr as $coin){
				
				$coin_name =  $coin['coin_name'];
				$keyword =  $coin['symbol'];
					
			if ($_GET['after']) {
				$after = $_GET['after'];
			} else {
				$after = '';
			}
			$sentiment   = new \PHPInsight\Sentiment();
			$redditArray = $reddit->search($coin_name, "news", 200, '', $after);
		
		
		
			$mainRedditArray = array();
			$mainRedditArray = $redditArray->data->children;
			$count           = count($mainRedditArray);
			$totalrecord     = $count;
			$totalNewrecord  = $count - 1;
			
			foreach ($mainRedditArray as $key => $row) {
				$title          = $row->data->title;
				$description    = $row->data->selftext;
				$created        = $row->data->created;
				$permalink      = $row->data->permalink;
				$id             = $row->data->id;
				$score          = $row->data->score;
				$this_tweet_day = date('D. M j, Y', ($created));
				// calculations:
				$scores         = $sentiment->score($title);
				$class          = $sentiment->categorise($title);
				$rating_from    = 'title';
				if ($class == 'neu') {
					$description = $row->data->selftext;
					$scores      = $sentiment->score($description);
					$class       = $sentiment->categorise($description);
					$rating_from = 'description';
				}
				$negative_sentiment = $scores['neg'];
				$positive_sentiment = $scores['pos'];
				$neutral_sentiment  = $scores['neu'];
				
				$description        = str_replace('"', '', $description);
				$title              = str_replace('"', '', $title);
				$created_date       = date('Y-m-d G:i:s');
				
				
			/*	$this->db->dbprefix('reddit');
			$this->db->like('title', $title);
			$this->db->like('created_at', $created);
			$get_redditRecord = $this->db->get('reddit');
	
			//echo $this->db->last_query();
			$row_reddit= $get_redditRecord->result_array();
			
			if($row_reddit>0){}else{*/
			
				
				
			$ins_arr = array(
				'reddit_id' => $id,
				'source'   => 'reddit',
				'keyword'  => $keyword,
				'text'     => $title,
				'description'     => $description,
				'negative_sentiment' => (float) $negative_sentiment,
				'neutral_sentiment'  => (float) $neutral_sentiment,
				'positive_sentiment' => (float) $positive_sentiment,
				'created_date'       => $this->mongo_db->converToMongodttime($this_tweet_day),
				'created_date_human_readable'       => $this_tweet_day,
				'class'   => (float) $class,
				'score'   => (float) $score,
				'sentiment_calculations' => $sentiment_calculations,
			);
						
			$ins_id = $this->mongo_db->insert("redditnews", $ins_arr);
			
				
				
				
				
			//}
            
            //******************************* Insert Comments into DB *****************************//
            $dataArray   = json_decode(file_get_contents('https://www.reddit.com' . $permalink . '.json'));
			
			
			//echo "<pre>";  print_r($dataArray); exit;
			 
            foreach ($dataArray as $articles) {
                foreach ($articles->data->children as $key => $article) {
                    if ($key == 0) {
                        $score              = $article->data->score;
                        $parent_id          = $article->data->parent_id;
                        $comment            = $article->data->selftext;
                        $comment            = str_replace('"', '', $comment);
                        $created            = $article->data->created;
                        $subreddit_id       = $article->data->subreddit_id;
						$this_tweet_day     = date('D. M j, Y', ($created));
                        // calculations:
                        $scores_comment     = $sentiment->score($comment);
                        $class_comment      = $sentiment->categorise($comment);
                        $negative_sentiment = $scores_comment['neg'];
                        $positive_sentiment = $scores_comment['pos'];
                        $neutral_sentiment  = $scores_comment['neu'];
                        $created_date       = date('Y-m-d G:i:s');
						
						
						/*
						
						$this->db->dbprefix('reddit_comments');
						//$this->db->like('title', $comment);
			            $this->db->like('created_at', $created);
						$get_redditRecord = $this->db->get('reddit_comments');
						//echo $this->db->last_query();
						$row_reddit= $get_redditRecord->result_array();*/
							
						//if($row_reddit>0){}else{
						
							
							$ins_arr = array(
								'reddit_id' => $id,
								'source'   => 'reddit',
								'keyword'  => $keyword,
								'text'     => $comment,
								'description'     => $description,
								'negative_sentiment' => (float) $negative_sentiment,
								'neutral_sentiment'  => (float) $neutral_sentiment,
								'positive_sentiment' => (float) $positive_sentiment,
								'created_date'       => $this->mongo_db->converToMongodttime($this_tweet_day),
								'created_date_human_readable'       => $this_tweet_day,
								'class'   => (float) $class,
								'score'   => (float) $score,
								'sentiment_calculations' => $sentiment_calculations,
							);
							$ins_id = $this->mongo_db->insert("reddi_comments", $ins_arr);
							
							
					   //}
                    } else {
                        $score              = $article->data->score;
                        $parent_id          = $article->data->parent_id;
                        $comment            = $article->data->body;
                        $comment            = str_replace('"', '', $comment);  
                        $created            = $article->data->created;
                        $subreddit_id       = $article->data->subreddit_id;
						$this_tweet_day     = date('D. M j, Y', ($created));
                        // calculations:
                        $scores_comment     = $sentiment->score($comment);
                        $class_comment      = $sentiment->categorise($comment);
                        $negative_sentiment = $scores_comment['neg'];
                        $positive_sentiment = $scores_comment['pos'];
                        $neutral_sentiment  = $scores_comment['neu'];
                        $created_date       = date('Y-m-d G:i:s');
						
						$this->db->dbprefix('reddit_comments');
						//$this->db->like('title', $comment);
			            $this->db->like('created_at', $created);
						$get_redditRecord = $this->db->get('reddit_comments');
						//echo $this->db->last_query();   exit;
						$row_reddit= $get_redditRecord->result_array();
							
						//if($row_reddit>0){}else{
						
							
							$ins_arr = array(
								'reddit_id' => $id,
								'source'   => 'reddit',
								'keyword'  => $keyword,
								'text'     => $comment,
								'description'     => $description,
								'negative_sentiment' => (float) $negative_sentiment,
								'neutral_sentiment'  => (float) $neutral_sentiment,
								'positive_sentiment' => (float) $positive_sentiment,
								'created_date'       => $this->mongo_db->converToMongodttime($this_tweet_day),
								'created_date_human_readable'       => $this_tweet_day,
								'class'   => (float) $class,
								'score'   => (float) $score,
								'sentiment_calculations' => $sentiment_calculations,
							);
							$ins_id = $this->mongo_db->insert("reddi_comments", $ins_arr);
							
							
						//}
                        foreach ($article->data->replies->data->children as $reply) {
                            $comment_reply          = $reply->data->body;
                            $comment_reply          = str_replace('"', '', $comment_reply);
                            $score_reply            = $reply->data->score;
                            $score_reply            = $reply->data->score;
                            $parent_id              = $reply->data->parent_id;
                            $link_id                = $reply->data->link_id;
                            $created_reply          = $article->data->created;
							$this_tweet_day     = date('D. M j, Y', ($created_reply));
                            // calculations:
                            $scores_comment_rep     = $sentiment->score($comment_reply);
                            $classs_comment_rep     = $sentiment->categorise($comment_reply);
                            $negative_sentiment_rep = $scores_comment_rep['neg'];
                            $positive_sentiment_rep = $scores_comment_rep['pos'];
                            $neutral_sentiment_rep  = $scores_comment_rep['neu'];
							
							
							/*$this->db->dbprefix('reddit_comments');
							//$this->db->like('title', $comment_reply);
			                $this->db->like('created_at', $created);
							$get_redditRecord = $this->db->get('reddit_comments');
							//echo $this->db->last_query();
							$row_reddit= $get_redditRecord->result_array();*/
								
							//if($row_reddit>0){}else{
							
								$ins_arr = array(
								'reddit_id' => $link_id,
								'source'   => 'reddit',
								'keyword'  => $keyword,
								'text'     => $comment_reply,
								'description'     => $description,
								'negative_sentiment' => (float) $negative_sentiment_rep,
								'neutral_sentiment'  => (float) $neutral_sentiment_rep,
								'positive_sentiment' => (float) $positive_sentiment_rep,
								'created_date'       => $this->mongo_db->converToMongodttime($this_tweet_day),
								'created_date_human_readable'       => $this_tweet_day,
								'class'   => (float) $class,
								'score'   => (float) $score,
								'sentiment_calculations' => $sentiment_calculations,
							);
							$ins_id = $this->mongo_db->insert("reddi_comments", $ins_arr);
							
							
							
							
						  //}
						}
					   }
                    }
				}
            }
        }
    }
	
	
	public function redditCoinName2()
    {
        $this->load->file('application/libraries/lib/Reddit.php');
        $reddit = new reddit();
        $this->load->file('application/libraries/lib/autoload.php');
        
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;
		
		foreach($coins_arr as $coin){
			
			$coin_name =  $coin['coin_name'];
			$keyword =  $coin['symbol'];
				
			if ($_GET['after']) {
				$after = $_GET['after'];
			} else {
				$after = '';
			}
			$sentiment   = new \PHPInsight\Sentiment();
			$redditArray = $reddit->search($coin_name, "news", 200, '', $after);
		
		
		
			$mainRedditArray = array();
			$mainRedditArray = $redditArray->data->children;
			$count           = count($mainRedditArray);
			$totalrecord     = $count;
			$totalNewrecord  = $count - 1;
			foreach ($mainRedditArray as $key => $row) {
				$title          = $row->data->title;
				$description    = $row->data->selftext;
				$created        = $row->data->created;
				$permalink      = $row->data->permalink;
				$id             = $row->data->id;
				$score          = $row->data->score;
				$this_tweet_day = date('D. M j, Y', ($created));
				// calculations:
				$scores         = $sentiment->score($title);
				$class          = $sentiment->categorise($title);
				$rating_from    = 'title';
				if ($class == 'neu') {
					$description = $row->data->selftext;
					$scores      = $sentiment->score($description);
					$class       = $sentiment->categorise($description);
					$rating_from = 'description';
				}
				$negative_sentiment = $scores['neg'];
				$positive_sentiment = $scores['pos'];
				$neutral_sentiment  = $scores['neu'];
				
				$description        = str_replace('"', '', $description);
				$title              = str_replace('"', '', $title);
				$created_date       = date('Y-m-d G:i:s');
				
				
				/*$this->db->dbprefix('reddit');
				$this->db->where('reddit_id',$id);
				$get_redditRecord = $this->db->get('reddit');
		
				//echo $this->db->last_query();
				$row_reddit= $get_redditRecord->result_array();
				
				if($row_reddit>0){}else{*/
				
				$ins_data           = array(
					'reddit_id' => $this->db->escape_str(trim($id)),
					'source' => $this->db->escape_str(trim('reddit')),
					'keyword' => $this->db->escape_str(trim($keyword)),
					'title' => $this->db->escape_str($title),
					'description' => $this->db->escape_str(trim($description)),
					'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
					'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
					'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
					'created_at' => $this->db->escape_str(trim($created)),
					'origional_date' => $this->db->escape_str(trim()),
					'sentiment_rating' => $this->db->escape_str(trim()),
					'class' => $this->db->escape_str(trim($class)),
					'score' => $this->db->escape_str(trim($score))
				);
					
				//Insert the record into the database.
				$this->db->dbprefix('reddit');
				$ins_into_db = $this->db->insert('reddit', $ins_data);
					
					
					
				//}
				
				//******************************* Insert Comments into DB *****************************//
				$dataArray   = json_decode(file_get_contents('https://www.reddit.com' . $permalink . '.json'));
				
				
				//echo "<pre>";  print_r($dataArray); exit;
				
				foreach ($dataArray as $articles) {
					foreach ($articles->data->children as $key => $article) {
						if ($key == 0) {
							$score              = $article->data->score;
							$parent_id          = $article->data->parent_id;
							$comment            = $article->data->selftext;
							$comment            = str_replace('"', '', $comment);
							$created            = $article->data->created;
							$subreddit_id       = $article->data->subreddit_id;
							// calculations:
							$scores_comment     = $sentiment->score($comment);
							$class_comment      = $sentiment->categorise($comment);
							$negative_sentiment = $scores_comment['neg'];
							$positive_sentiment = $scores_comment['pos'];
							$neutral_sentiment  = $scores_comment['neu'];
							$created_date       = date('Y-m-d G:i:s');
							
							
							
							/*$this->db->dbprefix('reddit_comments');
							$this->db->like('title', $comment);
							$get_redditRecord = $this->db->get('reddit_comments');
							//echo $this->db->last_query();
							$row_reddit= $get_redditRecord->result_array();
								
							if($row_reddit>0){}else{*/
							
							
								$ins_data           = array(
									'reddit_id' => $this->db->escape_str(trim($id)),
									'source' => $this->db->escape_str(trim('reddit')),
									'keyword' => $this->db->escape_str(trim($keyword)),
									'title' => $this->db->escape_str($comment),
									'description' => $this->db->escape_str(trim($description)),
									'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
									'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
									'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
									'created_at' => $this->db->escape_str(trim($created)),
									'origional_date' => $this->db->escape_str(trim()),
									'sentiment_rating' => $this->db->escape_str(trim()),
									'class' => $this->db->escape_str(trim($class_comment)),
									'score' => $this->db->escape_str(trim($score))
								);
								//Insert the record into the database.
								$this->db->dbprefix('reddit_comments');
								$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
							//}
						} else {
							$score              = $article->data->score;
							$parent_id          = $article->data->parent_id;
							$comment            = $article->data->body;
							$comment            = str_replace('"', '', $comment);  
							$created            = $article->data->created;
							$subreddit_id       = $article->data->subreddit_id;
							// calculations:
							$scores_comment     = $sentiment->score($comment);
							$class_comment      = $sentiment->categorise($comment);
							$negative_sentiment = $scores_comment['neg'];
							$positive_sentiment = $scores_comment['pos'];
							$neutral_sentiment  = $scores_comment['neu'];
							$created_date       = date('Y-m-d G:i:s');
							
							/*$this->db->dbprefix('reddit_comments');
							$this->db->like('title', $comment);
							$get_redditRecord = $this->db->get('reddit_comments');
							//echo $this->db->last_query();   exit;
							$row_reddit= $get_redditRecord->result_array();
								
							if($row_reddit>0){}else{*/
							
								$ins_data           = array(
									'reddit_id' => $this->db->escape_str(trim($id)),
									'source' => $this->db->escape_str(trim('reddit')),
									'keyword' => $this->db->escape_str(trim($keyword)),
									'title' => $this->db->escape_str($comment),
									'description' => $this->db->escape_str(trim($description)),
									'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
									'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
									'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
									'created_at' => $this->db->escape_str(trim($created)),
									'origional_date' => $this->db->escape_str(trim()),
									'sentiment_rating' => $this->db->escape_str(trim()),
									'class' => $this->db->escape_str(trim($class_comment)),
									'score' => $this->db->escape_str(trim($score))
								);
								//Insert the record into the database.
								$this->db->dbprefix('reddit_comments');
								$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
							//}
							foreach ($article->data->replies->data->children as $reply) {
								$comment_reply          = $reply->data->body;
								$comment_reply          = str_replace('"', '', $comment_reply);
								$score_reply            = $reply->data->score;
								$score_reply            = $reply->data->score;
								$parent_id              = $reply->data->parent_id;
								$link_id                = $reply->data->link_id;
								$created_reply          = $article->data->created;
								// calculations:
								$scores_comment_rep     = $sentiment->score($comment_reply);
								$classs_comment_rep     = $sentiment->categorise($comment_reply);
								$negative_sentiment_rep = $scores_comment_rep['neg'];
								$positive_sentiment_rep = $scores_comment_rep['pos'];
								$neutral_sentiment_rep  = $scores_comment_rep['neu'];
								
								
								/*$this->db->dbprefix('reddit_comments');
								$this->db->like('title', $comment_reply);
								$get_redditRecord = $this->db->get('reddit_comments');
								//echo $this->db->last_query();
								$row_reddit= $get_redditRecord->result_array();
									
								if($row_reddit>0){}else{*/
								
								$ins_data               = array(
									'reddit_id' => $this->db->escape_str(trim($link_id)),
									'source' => $this->db->escape_str(trim('reddit')),
									'keyword' => $this->db->escape_str(trim($keyword)),
									'title' => $this->db->escape_str($comment_reply),
									'description' => $this->db->escape_str(trim($description)),
									'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment_rep)),
									'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment_rep)),
									'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment_rep)),
									'created_at' => $this->db->escape_str(trim($created_reply)),
									'origional_date' => $this->db->escape_str(trim()),
									'sentiment_rating' => $this->db->escape_str(trim()),
									'class' => $this->db->escape_str(trim($classs_comment_rep)),
									'score' => $this->db->escape_str(trim($score_reply))
								);
								//Insert the record into the database.
								$this->db->dbprefix('reddit_comments');
								$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
							}
						}
					}
				}
			}
		}
	}
	
	public function redditsymbol2()
    {
        $this->load->file('application/libraries/lib/Reddit.php');
        $reddit = new reddit();
        $this->load->file('application/libraries/lib/autoload.php');
        
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;
		
		foreach($coins_arr as $coin){
			
			$keyword =  $coin['symbol'];
				
        if ($_GET['after']) {
            $after = $_GET['after'];
        } else {
            $after = '';
        }
        $sentiment   = new \PHPInsight\Sentiment();
        $redditArray = $reddit->search($keyword, "news", 200, '', $after);
		
		
		
        $mainRedditArray = array();
        $mainRedditArray = $redditArray->data->children;
        $count           = count($mainRedditArray);
        $totalrecord     = $count;
        $totalNewrecord  = $count - 1;
        foreach ($mainRedditArray as $key => $row) {
            $title          = $row->data->title;
            $description    = $row->data->selftext;
            $created        = $row->data->created;
            $permalink      = $row->data->permalink;
            $id             = $row->data->id;
            $score          = $row->data->score;
            $this_tweet_day = date('D. M j, Y', ($created));
            // calculations:
            $scores         = $sentiment->score($title);
            $class          = $sentiment->categorise($title);
            $rating_from    = 'title';
            if ($class == 'neu') {
                $description = $row->data->selftext;
                $scores      = $sentiment->score($description);
                $class       = $sentiment->categorise($description);
                $rating_from = 'description';
            }
            $negative_sentiment = $scores['neg'];
            $positive_sentiment = $scores['pos'];
            $neutral_sentiment  = $scores['neu'];
            
            $description        = str_replace('"', '', $description);
            $title              = str_replace('"', '', $title);
            $created_date       = date('Y-m-d G:i:s');
			
			
			/*$this->db->dbprefix('reddit');
			$this->db->where('reddit_id',$id);
			$get_redditRecord = $this->db->get('reddit');
	
			//echo $this->db->last_query();
			$row_reddit= $get_redditRecord->result_array();
			
			if($row_reddit>0){}else{*/
			
				$ins_data           = array(
				'reddit_id' => $this->db->escape_str(trim($id)),
				'source' => $this->db->escape_str(trim('reddit')),
				'keyword' => $this->db->escape_str(trim($keyword)),
				'title' => $this->db->escape_str($title),
				'description' => $this->db->escape_str(trim($description)),
				'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
				'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
				'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
				'created_at' => $this->db->escape_str(trim($created)),
				'origional_date' => $this->db->escape_str(trim()),
				'sentiment_rating' => $this->db->escape_str(trim()),
				'class' => $this->db->escape_str(trim($class)),
				'score' => $this->db->escape_str(trim($score))
			);
			
			//Insert the record into the database.
			$this->db->dbprefix('reddit');
			$ins_into_db = $this->db->insert('reddit', $ins_data);
			
				
				
			//}
            
            //******************************* Insert Comments into DB *****************************//
            $dataArray   = json_decode(file_get_contents('https://www.reddit.com' . $permalink . '.json'));
			
			
			//echo "<pre>";  print_r($dataArray); exit;
			 
            foreach ($dataArray as $articles) {
                foreach ($articles->data->children as $key => $article) {
                    if ($key == 0) {
                        $score              = $article->data->score;
                        $parent_id          = $article->data->parent_id;
                        $comment            = $article->data->selftext;
                        $comment            = str_replace('"', '', $comment);
                        $created            = $article->data->created;
                        $subreddit_id       = $article->data->subreddit_id;
                        // calculations:
                        $scores_comment     = $sentiment->score($comment);
                        $class_comment      = $sentiment->categorise($comment);
                        $negative_sentiment = $scores_comment['neg'];
                        $positive_sentiment = $scores_comment['pos'];
                        $neutral_sentiment  = $scores_comment['neu'];
                        $created_date       = date('Y-m-d G:i:s');
						
						
						
						/*$this->db->dbprefix('reddit_comments');
						$this->db->like('title', $comment);
						$get_redditRecord = $this->db->get('reddit_comments');
						//echo $this->db->last_query();
						$row_reddit= $get_redditRecord->result_array();
							
						if($row_reddit>0){}else{*/
						
						
							$ins_data           = array(
								'reddit_id' => $this->db->escape_str(trim($id)),
								'source' => $this->db->escape_str(trim('reddit')),
								'keyword' => $this->db->escape_str(trim($keyword)),
								'title' => $this->db->escape_str($comment),
								'description' => $this->db->escape_str(trim($description)),
								'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
								'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
								'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
								'created_at' => $this->db->escape_str(trim($created)),
								'origional_date' => $this->db->escape_str(trim()),
								'sentiment_rating' => $this->db->escape_str(trim()),
								'class' => $this->db->escape_str(trim($class_comment)),
								'score' => $this->db->escape_str(trim($score))
							);
							//Insert the record into the database.
							$this->db->dbprefix('reddit_comments');
							$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
					   //}
                    } else {
                        $score              = $article->data->score;
                        $parent_id          = $article->data->parent_id;
                        $comment            = $article->data->body;
                        $comment            = str_replace('"', '', $comment);  
                        $created            = $article->data->created;
                        $subreddit_id       = $article->data->subreddit_id;
                        // calculations:
                        $scores_comment     = $sentiment->score($comment);
                        $class_comment      = $sentiment->categorise($comment);
                        $negative_sentiment = $scores_comment['neg'];
                        $positive_sentiment = $scores_comment['pos'];
                        $neutral_sentiment  = $scores_comment['neu'];
                        $created_date       = date('Y-m-d G:i:s');
						
						/*$this->db->dbprefix('reddit_comments');
						$this->db->like('title', $comment);
						$get_redditRecord = $this->db->get('reddit_comments');
						//echo $this->db->last_query();   exit;
						$row_reddit= $get_redditRecord->result_array();
							
						if($row_reddit>0){}else{*/
						
							$ins_data           = array(
								'reddit_id' => $this->db->escape_str(trim($id)),
								'source' => $this->db->escape_str(trim('reddit')),
								'keyword' => $this->db->escape_str(trim($keyword)),
								'title' => $this->db->escape_str($comment),
								'description' => $this->db->escape_str(trim($description)),
								'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
								'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
								'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
								'created_at' => $this->db->escape_str(trim($created)),
								'origional_date' => $this->db->escape_str(trim()),
								'sentiment_rating' => $this->db->escape_str(trim()),
								'class' => $this->db->escape_str(trim($class_comment)),
								'score' => $this->db->escape_str(trim($score))
							);
							//Insert the record into the database.
							$this->db->dbprefix('reddit_comments');
							$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
							//}
                        foreach ($article->data->replies->data->children as $reply) {
                            $comment_reply          = $reply->data->body;
                            $comment_reply          = str_replace('"', '', $comment_reply);
                            $score_reply            = $reply->data->score;
                            $score_reply            = $reply->data->score;
                            $parent_id              = $reply->data->parent_id;
                            $link_id                = $reply->data->link_id;
                            $created_reply          = $article->data->created;
                            // calculations:
                            $scores_comment_rep     = $sentiment->score($comment_reply);
                            $classs_comment_rep     = $sentiment->categorise($comment_reply);
                            $negative_sentiment_rep = $scores_comment_rep['neg'];
                            $positive_sentiment_rep = $scores_comment_rep['pos'];
                            $neutral_sentiment_rep  = $scores_comment_rep['neu'];
							
							
							/*$this->db->dbprefix('reddit_comments');
							$this->db->like('title', $comment_reply);
							$get_redditRecord = $this->db->get('reddit_comments');
							//echo $this->db->last_query();
							$row_reddit= $get_redditRecord->result_array();
								
							if($row_reddit>0){}else{*/
							
                            $ins_data               = array(
                                'reddit_id' => $this->db->escape_str(trim($link_id)),
                                'source' => $this->db->escape_str(trim('reddit')),
                                'keyword' => $this->db->escape_str(trim($keyword)),
                                'title' => $this->db->escape_str($comment_reply),
                                'description' => $this->db->escape_str(trim($description)),
                                'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment_rep)),
                                'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment_rep)),
                                'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment_rep)),
                                'created_at' => $this->db->escape_str(trim($created_reply)),
                                'origional_date' => $this->db->escape_str(trim()),
                                'sentiment_rating' => $this->db->escape_str(trim()),
                                'class' => $this->db->escape_str(trim($classs_comment_rep)),
                                'score' => $this->db->escape_str(trim($score_reply))
                            );
                            //Insert the record into the database.
                            $this->db->dbprefix('reddit_comments');
                            $ins_into_db = $this->db->insert('reddit_comments', $ins_data);
						  }
                        }
                    }
				}
            }
        }
    }
	
	public function redditMongoInsertion(){
        $this->load->file('application/libraries/lib/Reddit.php');
        $reddit = new reddit();
        $this->load->file('application/libraries/lib/autoload.php');
        //Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;
		
		foreach($coins_arr as $coin){
			
			$keyword =  $coin['coin_name'];
			
			if ($_GET['after']) {
				$after = $_GET['after'];
			} else {
				$after = '';
			}
			$sentiment   = new \PHPInsight\Sentiment();
			$redditArray = $reddit->search($keyword, "news", 200, '', $after);
			
			$mainRedditArray = array();
			$mainRedditArray = $redditArray->data->children;
			$count           = count($mainRedditArray);
			$totalrecord     = $count;
			$totalNewrecord  = $count - 1;
			foreach ($mainRedditArray as $key => $row) {
				$title          = $row->data->title;
				$description    = $row->data->selftext;
				$created        = $row->data->created;
				$permalink      = $row->data->permalink;
				$id             = $row->data->id;
				$score          = $row->data->score;
				$this_tweet_day = date('D. M j, Y', ($created));
				// calculations:
				$scores         = $sentiment->score($title);
				$class          = $sentiment->categorise($title);
				$rating_from    = 'title';
				
				if ($class == 'neu') {
					$description = $row->data->selftext;
					$scores      = $sentiment->score($description);
					$class       = $sentiment->categorise($description);
					$rating_from = 'description';
				}
				$negative_sentiment = $scores['neg'];
				$positive_sentiment = $scores['pos'];
				$neutral_sentiment  = $scores['neu'];
				
				$description        = str_replace('"', '', $description);
				$title              = str_replace('"', '', $title);
				$created_date       = date('Y-m-d G:i:s');
				
				
				$ins_data           = array(
					'reddit_id' => $this->db->escape_str(trim($id)),
					'source' => $this->db->escape_str(trim('reddit')),
					'keyword' => $this->db->escape_str(trim($keyword)),
					'title' => $this->db->escape_str($title),
					'description' => $this->db->escape_str(trim($description)),
					'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
					'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
					'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
					'created_at' => $this->db->escape_str(trim($created)),
					'origional_date' => $this->db->escape_str(trim()),
					'sentiment_rating' => $this->db->escape_str(trim()),
					'class' => $this->db->escape_str(trim($class)),
					'score' => $this->db->escape_str(trim($score))
				);
				
				//Insert the record into the database.
				$this->db->dbprefix('reddit');
				$ins_into_db = $this->db->insert('reddit', $ins_data);
				
				//******************************* Insert Comments into DB *****************************//
				$dataArray   = json_decode(file_get_contents('https://www.reddit.com' . $permalink . '.json'));
				
				foreach ($dataArray as $articles) {
					foreach ($articles->data->children as $key => $article) {
						if ($key == 0) {
							$score              = $article->data->score;
							$parent_id          = $article->data->parent_id;
							$comment            = $article->data->body;
							$comment            = str_replace('"', '', $comment);
							$created            = $article->data->created;
							$subreddit_id       = $article->data->subreddit_id;
							// calculations:
							$scores_comment     = $sentiment->score($comment);
							$class_comment      = $sentiment->categorise($comment);
							$negative_sentiment = $scores_comment['neg'];
							$positive_sentiment = $scores_comment['pos'];
							$neutral_sentiment  = $scores_comment['neu'];
							$created_date       = date('Y-m-d G:i:s');
							
							$ins_data           = array(
								'reddit_id' => $this->db->escape_str(trim($id)),
								'source' => $this->db->escape_str(trim('reddit')),
								'keyword' => $this->db->escape_str(trim($keyword)),
								'title' => $this->db->escape_str($comment),
								'description' => $this->db->escape_str(trim($description)),
								'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
								'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
								'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
								'created_at' => $this->db->escape_str(trim($created)),
								'origional_date' => $this->db->escape_str(trim()),
								'sentiment_rating' => $this->db->escape_str(trim()),
								'class' => $this->db->escape_str(trim($class_comment)),
								'score' => $this->db->escape_str(trim($score))
							);
							//Insert the record into the database.
							$this->db->dbprefix('reddit_comments');
							$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
						} else {
							$score              = $article->data->score;
							$parent_id          = $article->data->parent_id;
							$comment            = $article->data->body;
							$comment            = str_replace('"', '', $comment);
							$created            = $article->data->created;
							$subreddit_id       = $article->data->subreddit_id;
							// calculations:
							$scores_comment     = $sentiment->score($comment);
							$class_comment      = $sentiment->categorise($comment);
							$negative_sentiment = $scores_comment['neg'];
							$positive_sentiment = $scores_comment['pos'];
							$neutral_sentiment  = $scores_comment['neu'];
							$created_date       = date('Y-m-d G:i:s');
							$ins_data           = array(
								'reddit_id' => $this->db->escape_str(trim($id)),
								'source' => $this->db->escape_str(trim('reddit')),
								'keyword' => $this->db->escape_str(trim($keyword)),
								'title' => $this->db->escape_str($comment),
								'description' => $this->db->escape_str(trim($description)),
								'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment)),
								'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment)),
								'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment)),
								'created_at' => $this->db->escape_str(trim($created)),
								'origional_date' => $this->db->escape_str(trim()),
								'sentiment_rating' => $this->db->escape_str(trim()),
								'class' => $this->db->escape_str(trim($class_comment)),
								'score' => $this->db->escape_str(trim($score))
							);
							//Insert the record into the database.
							$this->db->dbprefix('reddit_comments');
							$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
							foreach ($article->data->replies->data->children as $reply) {
								$comment_reply          = $reply->data->body;
								$comment_reply          = str_replace('"', '', $comment_reply);
								$score_reply            = $reply->data->score;
								$score_reply            = $reply->data->score;
								$parent_id              = $reply->data->parent_id;
								$link_id                = $reply->data->link_id;
								$created_reply          = $article->data->created;
								// calculations:
								$scores_comment_rep     = $sentiment->score($comment_reply);
								$classs_comment_rep     = $sentiment->categorise($comment_reply);
								$negative_sentiment_rep = $scores_comment_rep['neg'];
								$positive_sentiment_rep = $scores_comment_rep['pos'];
								$neutral_sentiment_rep  = $scores_comment_rep['neu'];
								$ins_data               = array(
									'reddit_id' => $this->db->escape_str(trim($link_id)),
									'source' => $this->db->escape_str(trim('reddit')),
									'keyword' => $this->db->escape_str(trim($keyword)),
									'title' => $this->db->escape_str($comment_reply),
									'description' => $this->db->escape_str(trim($description)),
									'negative_sentiment' => $this->db->escape_str(trim($negative_sentiment_rep)),
									'neutral_sentiment' => $this->db->escape_str(trim($neutral_sentiment_rep)),
									'positive_sentiment' => $this->db->escape_str(trim($positive_sentiment_rep)),
									'created_at' => $this->db->escape_str(trim($created_reply)),
									'origional_date' => $this->db->escape_str(trim()),
									'sentiment_rating' => $this->db->escape_str(trim()),
									'class' => $this->db->escape_str(trim($classs_comment_rep)),
									'score' => $this->db->escape_str(trim($score_reply))
								);
								//Insert the record into the database.
								$this->db->dbprefix('reddit_comments');
								$ins_into_db = $this->db->insert('reddit_comments', $ins_data);
							}
						}
					}
				}
			}
		}
    }
	
	public function gettweets() {
		
		$connetct = $this->mongo_db->customQuery();
		$collection->aggregate(

			array('$match' => array('keyword' => 'test', 'created_date' => array('$gte' => '12:2'), 
			'created_date' => array('$lte' => '12:2'))
			),
			array('$group' => array(
			 '_id' => array('id' => '$id'),
			 'totalrecord' => array('$sum' => 1),
			 'negative_sentiment' => array('$sum' => '$negative_sentiment'),
			 'positive_sentiment' => array('$sum' => '$positive_sentiment')
			),
	    )
       );
	   $out = $connetct->sentiments_tweet->aggregate($collection);
	   echo "<pre>";   print_r($out); exit;
	   
	}
     
	// public function deleteTweetsTable() {
		 
	// 	$db = $this->mongo_db->customQuery();
	// 	$res = $db->sentiments_tweet->drop();
	// 	var_dump($res);
	// 	exit(); 
	// 	$connetct = $this->mongo_db->delete('sentiments_tweet');
	// 	echo "<pre>";   print_r($connetct); exit;
	// }//deleteTweetsTable


}
