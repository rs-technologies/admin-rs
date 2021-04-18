<?php
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class Wordpress
{
    private $url,$json_version;

    public function __construct(){
        $this->url=env("WP_ADMIN_URL");
        $this->json_version="wp-json/wp/v2/";
    }

    public function createSite($domain){
        return $this->callServer($this->url.$this->json_version."sites/create",compact('domain'));
    }

    public function updateNetlifySettings($hook_url,$domain,$roles=['administrator']){
        $response=$this->callServer($domain.$this->json_version."netlify_options",[
            'auto_deploy'=>'off',
            'manual_deploy'=>'on',
            'build_hook'=>$hook_url,
            'auth_roles'=>$roles
        ]);

        return $response->success;
    }

    /**
     * Call the Wordpress Server
     * @param string $url
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    private function callServer(string $url,array $params){
        $response=Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . env("APP_AUTH")
        ])->asForm()->post($url,$params);


        if(!($response->status()>=200&&$response->status()<=299)){
            throw new Exception($response,$response->status());
        }

        return json_decode($response->body());
    }
}
