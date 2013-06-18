<ul>
	<?php
		foreach($twitter as $tweet)
		{
			?><li><?php
				echo $this->tmhUtilities->entify($tweet);
				
				?><h4><a href="https://twitter.com/<?php echo $this->config->item('twitter_user'); ?>/status/<?php echo $tweet['id_str']; ?>" target="_blank"><?php echo date('d F', strtotime($tweet['created_at'])); ?></a></h4>
			</li><?php
		}
	?>
</ul>