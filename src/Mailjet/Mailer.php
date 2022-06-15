<?php

namespace App\Mailjet;

use Mailjet\Client;
use Mailjet\Resources;

class Mailer
{
    private string $api_key = 'c48d9346266a5b48ec4c4cd8bdccd5df';
    private string $api_secret_key = 'd9255dd791e22d0af0910d764030e712';

    public function send(
        string $email,
        string $name,
        string $subject,
        string $title,
        string $content
    ): void
    {
        $mj = new Client($this->api_key, $this->api_secret_key, true,['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "matine.nassirpour@gmail.com",
                        'Name' => "Meta Galeries"
                    ],
                    'To' => [
                        [
                            'Email' => $email,
                            'Name' => $name
                        ]
                    ],
                    'TemplateID' => 4008990,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'title' => $title,
                        'content' => $content
                    ]
                ]
            ]
        ];

        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && $response->getData();
    }
}
