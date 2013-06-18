<?php



class Model extends CI_Model {

	/** @type object|null Stores the twiter api connection object */
	var $twitter_api = NULL;

    /**
   * 
   * Model constructor
   *
   * @return void
   */

    function __construct()
    {
        parent::__construct();
                								
        $this->twitter_api = new tmhOAuth(array
			(
				'consumer_key' => $this->config->item('twitter_api_key'),
				'consumer_secret' => $this->config->item('twitter_api_secret'),
				'user_token'      => $this->config->item('twitter_access_token'),
				'user_secret'     => $this->config->item('twitter_token_secret'),
			)
		);
    }
    
	/**
	* 
	* Gets a users timeline from twitter using API v1.1
	*
	* @param string $count  the number of tweets to get
	* @return array|boolean Contains tweets if successfull, false if unsuccessful
	*/

	function getUserTimeline($count == 10)
	{
		// set paramaters for request
		$params = array(
			'q'        => $this->config->item('twitter_user'),
			'count'    => $count,
			'exclude_replies' => TRUE,
			'include_rts' => TRUE
		);
		
		// runs request to twitter to get user tweets using the above parameters
		$this->twitter_api->request(
			'GET',
			'https://api.twitter.com/1.1/statuses/user_timeline.json',
			$params
		);
		
		// stores the response in a variable
		$response = $this->twitter_api->response;
		
		// Check response code is ok (200) before seting variable.	    	
		if($response['code'] === 200)
		{
			$tweets = json_decode($response['response'], TRUE);
		}
		else
		{
			$tweets = FALSE;
		}
		
		// returns array of tweets
		return $tweets;
	}
}