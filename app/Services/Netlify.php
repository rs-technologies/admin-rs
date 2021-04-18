<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class Netlify
{
    public function createSite($domain){
        $domain = "https://" . $domain;
        return $this->callServer("sites",[
            'build_settings' => array(
                'env' => array(
                    'SITE_URL' => $domain,
                    'GRAPHQL_URL' => $domain . "graphql",
                )
            ),
            'repo' => array(
                'repo_path' => env("GIT_REPO_PATH"),
                "repo_url"=>env("GIT_REPO_URL"),
                'public_repo' => false,
                'deploy_key_id' => env('NETLIFY_DEPLOY'),
                'cmd' => 'gatsby build',
                'dir' => 'public/',
                'env' => array(
                    'SITE_URL' => $domain,
                    'GRAPHQL_URL' => $domain . "graphql",
                )
            )
        ]);
    }

    public function updateSite(){

    }

    public function deleteSite(){

    }

    public function createBuildHook($site_id){
        $res=$this->callServer("sites/{$site_id}/build_hooks",[
            "title"=>"Wordpress",
            "site_id"=>$site_id
        ]);

        return $res->url;
    }

    private function callServer($url,$params){
        $response=Http::withToken(env('NETLIFY_API'))
                    ->asJson()
                    ->post(env("NETLIFY_URL") . $url,$params);

        $res=json_decode($response->body());

        if(!($response->status()>=200&&$response->status()<=299)){
            throw new \Exception($response,$response->status());
        }
        return $res;
    }
}
