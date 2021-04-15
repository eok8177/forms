<?php

/**
* Description:
* Model (based on MVC architecture) with all API calls in one place 
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - newUser($user) | trigger create new user in MARS
* - updateUser($user) | trigger update user in MARS
* - deleteUser($user) | trigger delete user's details in MARS
* - getDashboard() | get dashboard details from MARS
* - newResponse($responseData = null) | create/update response
* - newUpdateForm($formData) | create/update form definition
* - deleteForm($formData) | delete form definition
* - call($method = false, $postData = false, $type = 'POST') | Generic API call
*/

namespace App;

use App\ApiLog;


class ApiCall
{
    public function test()
    {
        return $this->call('test', false, 'GET');
    }

    public function newLog($logData = null)
    {
        return $this->call('log-new', $logData);
    }


    /**
    * Description:
    * trigger create new user in MARS
    *
    * List of parameters:
    * - $user : User
    *
    * Return:
    *
    * Example of usage:
    * see method Http/Controllers/UserController.store()
    */
    public function newUser($user)
    {
        return $this->call('user-new', $user);
    }


    /**
    * Description:
    * trigger update user in MARS
    *
    * List of parameters:
    * - $user : User
    *
    * Return:
    *
    * Example of usage:
    * see method Http/Controllers/UserController.update()
    */
    public function updateUser($user)
    {
        return $this->call('user-update', $user);
    }


    /**
    * Description:
    * trigger delete user's details in MARS
    *
    * List of parameters:
    * - $user : User
    *
    * Return:
    *
    * Example of usage:
    * see method Http/Controllers/UserController.destroy()
    */
    public function deleteUser($user)
    {
        return $this->call('user-delete', $user);
    }


    /**
    * Description:
    * get dashboard details from MARS
    *
    * List of parameters:
    * - none
    *
    * Return:
    *
    * Example of usage:
    * see method Http/Controllers/UserController.index()
    */
    public function getDashboard()
    {
        return $this->call('get-dashboard', false, 'GET');
    }


    /**
    * Description:
    * create/update response
    *
    * List of parameters:
    *
    * Return:
    *
    * Example of usage:
    * see method app/Application.createEntry()
    */
    public function newResponse($responseData = null)
    {
        return $this->call('response-new', $responseData);
    }


    /**
    * Description:
    * create/update form definition
    *
    * List of parameters:
    *
    * Return:
    *
    * Example of usage:
    * see method Http/Controllers/Admin/AjaxController.status()
    */
    public function newUpdateForm($formData)
    {
        return $this->call('form-new-update', $formData);
    }


    /**
    * Description:
    * delete form definition
    *
    * List of parameters:
    * - $formData: object{ 'portal_form_id' => <formID>, 'portal_form_name' => <formName> }
    *
    * Return:
    *
    * Example of usage:
    * see method Http/Controllers/Admin/FormController.destroy()
    */
    public function deleteForm($formData)
    {
        return $this->call('form-delete', $formData);
    }


    public function isOutreachUser($formData)
    {
        return true;
        // return $this->call('is-outreach-user', $formData, 'GET');
    }


    public function getOrganisations($formData)
    {
        return [12 => 'org1', 15 => 'org2'];
        // return $this->call('get-organisations', $formData, 'GET');
    }


    public function getHealthCategories($formData)
    {
        return [15 => 'health1', 20 => 'health2'];
        // return $this->call('get-health-categories', $formData, 'GET');
    }

    public function getOutreachServices($formData)
    {
        $dummyServices = [
            (object)[
                "ref" => "1A",
                "location" => "Melbourne",
                "organisation" => "org1",
                "healthCategory" => "health1",
                "totalVisits" => 12,
                "visitsRemaining" => 2,
                /*[
                    [
                        "visitRef" => "V1",
                        "visitStatus" => "Accepted",
                        "visitMethodOfDelivery" => "",
                        "visitDate" => "",
                        "visitSubmittedDate" => "",
                        "visitSubmitter" => "",
                        "Accepted" => "",
                    ]
                ]*/
            ],
            (object)[
                "ref" => "3B",
                "location" => "Sydney",
                "organisation" => "org1",
                "healthCategory" => "health1",
                "totalVisits" => 12,
                "visitsRemaining" => 20
            ],
            (object)[
                "ref" => "1A",
                "location" => "Brisbane",
                "organisation" => "org2",
                "healthCategory" => "health2",
                "totalVisits" => 20,
                "visitsRemaining" => 0
            ]
        ];
        return $dummyServices; 
        //return $this->call('get-outreach-services', $formData, 'GET');
    }
    
    public function getOutreachServiceDetails($id)
    {
        $data = [
            0 => [
                "visitRef" => 'visitRef 000',
                "visitStatus" => 'visitStatus 000',
                "visitMethodOfDelivery" => 'visitMethodOfDelivery 000',
                "visitDate" => 'visitDate 000',
                "visitSubmittedDate" => 'visitSubmittedDate 000',
                "visitSubmitter" => 'visitSubmitter 000',
                "Accepted" => 'Accepted 000',
            ],
            1 => [
                "visitRef" => 'visitRef 001',
                "visitStatus" => 'visitStatus 001',
                "visitMethodOfDelivery" => 'visitMethodOfDelivery 001',
                "visitDate" => 'visitDate 001',
                "visitSubmittedDate" => 'visitSubmittedDate 001',
                "visitSubmitter" => 'visitSubmitter 001',
                "Accepted" => 'Accepted 001',
            ],
            2 => [
                "visitRef" => 'visitRef 002',
                "visitStatus" => 'visitStatus 002',
                "visitMethodOfDelivery" => 'visitMethodOfDelivery 002',
                "visitDate" => 'visitDate 002',
                "visitSubmittedDate" => 'visitSubmittedDate 002',
                "visitSubmitter" => 'visitSubmitter 002',
                "Accepted" => 'Accepted 002',
            ],
        ];

        return $data[$id];
    }



    /**
    * Description:
    * Generic API call
    * 
    * List of parameters:
    * - $method : false|string
    * - $postData : boolean
    * - $type : string (POST|GET)
    *
    * Return:
    * false|array
    *
    * Example of usage:
    * this method is widely used within ApiCall (this file) class
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