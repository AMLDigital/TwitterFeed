<?php

namespace AMLDigital;

use \themattharris\tmhOAuth;

class TwitterFeed {
    /***
     * @param $consumer_key
     * @param $consumer_secret
     * @param $user_token
     * @param $user_secret
     * @param $user
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
                            'content' => json_decode($connection->response['response'])
        );
        return $result;
    }

}