<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
   * Controller
   * 
   * 
   * @package    CI
   * @subpackage Controller
   * @author     Andy Wotherspoon <andywotherspoon@gmail.com>
   */

class Controller extends CI_Controller {

	/** @type object|null Stores tmhUtilities object */
	public $tmhUtilities = NULL;
	
	/**
	* 
	* Controller constructor
	*
	* @return void
	*/

	function __construct()
    {
        parent::__construct();
        		
		$this->tmhUtilities = new tmhUtilities();
		
		// Caching
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		
		// Models
        $this->load->model('Model');
    }

	/**
	* 
	* Loads the index page
	*
	* 
	* @return void
	*/
    
	public function index()
	{
		// Check cache exists
		if(! $this->cache->get("twitter_feed"))
		{
			// Load feed from twitter
			if($data['twitter'] = $this->Model->getUserTimeline())
			{				
				// Save into the cache for 30 minutes
				$this->cache->save("twitter_feed", $data['twitter'], $this->config->item('twitter_cache_expiry'));
				
				// Save backup for 30 days
				$this->cache->save("twitter_feed_backup", $data['twitter'], $this->config->item('twitter_backup_expiry'));
			}
			else
			{				
				// if feed doesn't load from API, go to backup
				$data['twitter'] = $this->cache->get("twitter_feed");

				// Save backup into the cache for 30 minutes
				$this->cache->save("twitter_feed", $data['twitter'], $this->config->item('twitter_cache_expiry'));
				
				// Update the backup for 30 days so it can't time out if there's a break in the API
				$this->cache->save("twitter_feed_backup", $data['twitter'], $this->config->item('twitter_backup_expiry'));
			}
		}
		else
		{			
			// Load cache
			$data['twitter'] = $this->cache->get("twitter_feed");
		}
		
		$this->load->view('index', $data);
	}
}