<?php
    $apikey = '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';

    $data = [
        'model' => 'text-davinci-002',
        'prompt' => 'Responde como un tecnico de soporte ti: Problemas de inicio de sesion al SAP',
        'temperature' => 0.7,
        'max_tokens' => 300,
        'n' => 1,
        'stop' => ['\n']
    ];

    $ch = curl_init('https://api.openai.com/v1/completions');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apikey
    ));

    $response = curl_exec($ch);
    $responseArr = json_decode($response, true);

    echo $responseArr['choices'][0]['text'];

    /* echo $responseArr['choices'][0]['text']; */

?>