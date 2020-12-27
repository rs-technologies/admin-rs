<?php

namespace App\Repositories;


use App\Models\Site;
use App\Repositories\contract\SiteRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SiteRepository implements SiteRepositoryInterface
{
    private $site;

    /**
     * Get All Sites
     * @return mixed
     */
    public function getAll()
    {
        return Site::paginate(15);
    }

    /**
     * Save all Site
     * @param array $site
     * @return boolean
     */
    public function store(array $site)
    {
        $domain = Str::slug($site['domain']) . "." . env('WP_DOMAIN');
        $wp=$this->createWpSite($domain);
        if(!$wp){
            return false;
        }
        $front=$this->createFrontEnd($domain);

        if(!$front){
            return false;
        }

        $new_site=new Site();
        $new_site->name=$site['name'];
        $new_site->domain=$site['domain'];
        $new_site->site_id=$wp;
        $new_site->frontend_id=$front->id;
        $new_site->frontend_url=$front->url;
        if(isset($site['custom_domain'])){
            $new_site->custom_domain=$site['domain_ssl'].$site['custom_domain'];
        }
        $new_site->touch();
        return $new_site->save();
    }

    private function createWpSite($domain)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . env("APP_AUTH")
        ])->asForm()->post(env("WP_ADMIN_URL"), [
            'domain' => $domain
        ]);
        $response=intval($response->body());
        if ( $response=== 0) {
            return false;
        }
        return $response;
    }

    private function createFrontEnd($domain)
    {
        $domain = "https://" . $domain;
        $response = Http::withToken(env('NETLIFY_API'))->asJson()->post(env("NETLIFY_URL") . "sites", [
            'build_settings' => array(
                'env' => array(
                    'SITE_URL' => $domain,
                    'GRAPHQL_URL' => $domain . "/graphql",
                )
            ),
            'repo' => array(
                'repo_path' => "eclatsujan/gastby_theme",
                "repo_url"=>"https://github.com/eclatsujan/gastby_theme",
                'public_repo' => false,
                'deploy_key_id' => env('NETLIFY_DEPLOY'),
                'cmd' => 'gatsby build',
                'dir' => 'public/',
                'env' => array(
                    'SITE_URL' => $domain,
                    'GRAPHQL_URL' => $domain . "/graphql",
                )
            )
        ]);

        if(!($response->status()>=200&&$response->status()<=299)){
            return false;
        }

        return json_decode($response->body());
    }
}
