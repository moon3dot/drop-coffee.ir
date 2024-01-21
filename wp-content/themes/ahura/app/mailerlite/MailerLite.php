<?php
namespace ahura\app\mailerlite;

abstract class MailerLite {
    protected $api = 'https://connect.mailerlite.com/api/';
    protected $api_key;
    protected $endpoint;
    protected $endpoint_routes;
    protected $method = 'POST';
    protected $body;
    protected $has_status;

    public function __construct($api_key){
        $this->api_key = $api_key;
    }

    protected function setEndpoint($endpoint){
        $this->endpoint = $endpoint;
    }

    protected function setEndpointRoutes(array $routes = []){
        $this->endpoint_routes = implode('/', $routes);
    }

    protected function post(){
        $this->method = 'POST';
        return $this;
    }

    protected function get(){
        $this->method = 'GET';
        return $this;
    }

    protected function push(){
        $this->method = 'PUSH';
        return $this;
    }

    protected function delete(){
        $this->method = 'DELETE';
        return $this;
    }

    protected function hasStatus(array $status = []){
        $this->has_status = $status;
        return $this;
    }

    private function resetParams(){
        $this->endpoint_routes = '';
    }

    protected function request(){
        $url = $this->api . $this->endpoint . '/' . $this->endpoint_routes;
        
        $params = array(
            'method' => $this->method,
            'headers' => array(
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key
            )
        );

        if(!empty($this->body)){
            $params['body'] = $this->body;
        }

        $res = wp_remote_request($url, $params);
        
        if((is_array($this->has_status) && count($this->has_status) > 0) && is_array($res)){
            if(!isset($res['response']['code']) || (isset($res['response']['code']) && !in_array($res['response']['code'], $this->has_status))){
                return false;
            }
        }

        if(!is_wp_error($res)) {
            $body = json_decode($res['body']);
            if(json_last_error() == JSON_ERROR_NONE){
                return $body;
            }
        }

        $this->resetParams();

        return false;
    }
}