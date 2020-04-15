<?php

namespace App;

class ApiCall
{
    public function test()
    {
        return $this->call('test', false, 'GET');
    }

    public function newUser($user)
    {
        return $this->call('new-user', $user);
    }

    private function call($method = false, $postData = false, $type = 'POST')
    {
        $url = "http://37.53.93.30:9302/api/".$method;
        $api_token = "0123456";

        $headers[] = "Content-type: application/json";
        $headers[] = "Authorization: ".$api_token;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_HTTPHEADER => $headers
        );

        if ($postData) {
            $options[CURLOPT_POSTFIELDS] = json_encode($postData);
        }


        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}