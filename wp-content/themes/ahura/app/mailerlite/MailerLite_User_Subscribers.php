<?php
namespace ahura\app\mailerlite;

class MailerLite_User_Subscribers extends \ahura\app\mailerlite\MailerLite {
    protected $endpoint = 'subscribers';

    public function addSubscriber($params){
        $this->body = $params;
        // request returned response if has status 200 | 201
        return $this->post()->hasStatus([200, 201])->request();
    }

    public function getSubscriber($email){
        $this->setEndpointRoutes([$email]);
        // request returned response if has status 200
        return $this->get()->hasStatus([200])->request();
    }
}