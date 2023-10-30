<?php
    $apikey = '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';

    $model = 'gpt-3.5-turbo';

    $messages = [
        [
            'role' => 'system',
            'content' => 'Eres un tecnico en TI'
        ],
        [
            'role' => 'user',
            'content' => 'Que es un CPU?'
        ]
    ];

    $data = [
        'model' => $model,
        'messages' => $messages,
        'temperature' => 0.5,
        'max_tokens' => 1024,
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

    echo $response;

    /* $responseArr = json_decode($response, true);

    if (isset($responseArr['choices'])) {
        $generatedText = $responseArr['choices'][0]['message']['content'];
        echo $generatedText;
    } else {
        echo "La respuesta de la API no contiene 'choices'.";
    }
 */
?>