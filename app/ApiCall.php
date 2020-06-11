<?php

namespace App;

class ApiCall
{
    public function test()
    {
        return $this->call('test', false, 'GET');
    }

	/**
	 * User
	 */
    public function newUser($user)
    {
        return $this->call('user-new', $user);
    }

    public function updateUser($user)
    {
        return $this->call('user-update', $user);
    }

    public function deleteUser($user)
    {
        return $this->call('user-delete', $user);
    }

	/**
	 * Dashboard
	 */
    public function getDashboard()
    {
        return $this->call('get-dashboard', false, 'GET');
    }
	
	/**
	 * Response
	 */
	public function newResponse($responseData = null)
	{
		return $this->call('response-new', $responseData);
	}

    /**
     * 
     * 
     * @return false|array
     */
    private function call($method = false, $postData = false, $type = 'POST')
    {
        $url = env('API_HOST', 'http://37.53.93.30:9302') . "/api/". $method;
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

        $res = json_decode($result);
        if (isset($res->status) && $res->status == 'OK') return $res->data; else return false;
    }
}