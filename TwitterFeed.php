<?php

namespace AMLDigital;


class TwitterFeed {
    /*
     * @param $consumer_key
     * @param $consumer_secret
     * @param $user_token
     * @param $user_secret
     */

    public function __construct($consumer_key,$consumer_secret,$user_token,$user_secret)
    {
        $this->connection =  new tmhOAuth(array(
            'consumer_key' => $consumer_key,
            'consumer_secret' => $consumer_secret,
            'user_token' => $user_token,
            'user_secret' => $user_secret,
        ));
    }

    public function getUserTimeline($user='aml_group', $count=5)
    {
        $connection = $this->connection;

        $connection->request('GET',
            $connection->url('1.1/statuses/user_timeline'),
            array(  'count' => 10,
                    'exclude_replies' => 'true',
                    'include_rts' => 'true',
            )
        );
        $result = array(    'code' => $connection->response['code'],
                            'content' => json_decode($connection->response['response'])
        );
        return $result;
    }

}