<?php

    require_once("../Models/Ticket.php");

    class Chatgpt extends Conectar{

        public function get_respuestaia($tick_id){
            $ticket = new Ticket();
            $datos = $ticket->listar_ticket_x_id($tick_id);
            foreach ($datos as $row){
                $tick_descrip = $row["tick_descrip"];
            }

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

        }

    }
?>