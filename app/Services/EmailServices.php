<?php


namespace App\Services;


use SendGrid\Mail\Mail;

class EmailServices
{
    private $Client;

    public function __construct()
    {
        $this->Client = new \SendGrid(env('SENGRID_API_KEY'));
    }

    /**
     * @param array $to
     * @param string $html
     * @param string $subject
     * @param string string $from
     * @return int|string
     * @throws \SendGrid\Mail\TypeException
     */
    public function sendSimpleEmail(
        $to,
        $html,
        $subject,
        $from = "test@example.com",
        $name = "Example User"
    )
    {
        if (!is_array($to)) {
            $email_address = [];
            $email_address[] = $to;
        } else {
            $email_address = $to;
        }
        $email = new Mail();
//        dd($email_address);
        foreach ($email_address as $v) {
            $email->addTo($v);
        }
        $email->setSubject($subject);
        $email->setFrom($from, $name);
        $email->addContent(
            "text/html", $html
        );
        try {
            $response = $this->Client->send($email);
            return $response->statusCode();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
