<?php

namespace App;

use App\ApiLog;


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

	public function newUpdateForm($formData)
	{
		return $this->call('form-new-update', $formData);
	}

	public function deleteForm($formData)
	{
		return $this->call('form-delete', $formData);
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
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTPHEADER => $headers
        );

        if ($postData) {
            $options[CURLOPT_POSTFIELDS] = json_encode($postData);
        }

        // store in API_log straight before the actual CURL call
        // $apiLog1 = new ApiLog;
        // $apiLog1->method = $method . ' before';
        // $apiLog1->save();


        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $r = '';
        if ($httpCode != 200) {
            $r = curl_error($ch);
        }
        curl_close($ch);

        $res = json_decode($result);

        $apiLog = new ApiLog;
        $apiLog->method = $method;
        $apiLog->payload = json_encode($postData);
        $apiLog->response = json_encode($result).$r;
        $apiLog->save();

        if (isset($res->status) && $res->status == 'OK') return $res->data; else return false;
    }
}