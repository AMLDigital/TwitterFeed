<?php
/**
 * TwitterFeed
 *
 * An easy-to-manage way of integrating a TwitterFeed into a website,
 * developed further to get more generic ways that a twitter feed can
 * be tailored to integrate with a web page.
 *
 * @author andylockran
 * @version 0.0.5
 *
 * 24 June 2013
 */
class TwitterFeed {

   /**
     * Passes the authentication details to create the connection to Twitter
     * Required since API release 1.1.
     * @param string $consumer_key The twitter app consumer key.
     * @param string $consumer_secret The twitter app consumer secret.
     * @param string $user_token The twitter user authentication token.
     * @param string $user_secret The twitter user authentication secret.
     * @param string $user The user's screen name without the @ (eg, andylockran)
     */
   public function __construct($consumer_key,$consumer_secret,$user_token,$user_secret,$user)
    {
        $this->connection =  new tmhOAuth(array(
            'consumer_key' => $consumer_key,
            'consumer_secret' => $consumer_secret,
            'user_token' => $user_token,
            'user_secret' => $user_secret,
        ));
        $this->user = $user;
    }
  /**
    * Gets a user timeline and returns a return code, a 'tidied' version of the content, and the raw json.
    * @param int $count the number of tweets to return.
    * @return array
    */
  public function getUserTimeline($count=10)
    {
        $connection = $this->connection;

        $connection->request('GET',
            $connection->url('1.1/statuses/user_timeline'),
            array(  'count' => $count,
                    'exclude_replies' => 'true',
                    'include_rts' => 'true'
            )
        );
        $result = array(    'code' => $connection->response['code'],
                            'content' => json_decode($connection->response['response']),
                            'raw' => $connection->response['response']
        );
        return $result;
    }

}
