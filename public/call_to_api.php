<?php

// Get Users
$postData = ['from' => '2020-02-20'];
echo "<pre>". print_r(json_decode(getData('users', $postData)),true);

// get Entries, can filter by date
// $postData = ['from' => '2020-02-20'];
// echo "<pre>". print_r(json_decode(getData('entries', $postData)),true);


function getData($method = false, $postData = false)
{
    $url = "https://forms.ek.ks.ua/api/".$method;
    $api_token = "sknXBvo7xaVDG3k9q1WdeisFEhfQrrga6cunbBdxOeRVGsQdBFzhfF7SQPm0";

    $headers[] = "Content-type: application/json";
    $headers[] = "Authorization: Bearer ".$api_token;

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => 'POST',
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