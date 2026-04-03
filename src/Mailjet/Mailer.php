<?php

namespace App\Mailjet;

use Mailjet\Client;
use Mailjet\Resources;

class Mailer
{
    private string $api_key = '52d10d13ceaabceb7b16eb004609e138';
    private string $api_secret_key = '0bb889c6723660a86f48c8a635eb4035';

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
                    'TemplateID' => 7899211,
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
