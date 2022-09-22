<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Mailjet\Resources;

class MailController extends Controller
{
    public function sendMail()
    {
        $mj = new \Mailjet\Client('****************************1234','****************************abcd',true,['version' => 'v3.1']);
        $body = [
          'Messages' => [
            [
              'From' => [
                'Email' => "clavier.quentin@gmail.com",
                'Name' => "Quentin"
              ],
              'To' => [
                [
                  'Email' => "clavier.quentin@gmail.com",
                  'Name' => "Quentin"
                ]
              ],
              'Subject' => "Greetings from Mailjet.",
              'TextPart' => "My first Mailjet email",
              'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
              'CustomID' => "AppGettingStartedTest"
            ]
          ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }
}
