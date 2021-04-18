<?php

namespace App\Repositories;


use App\Models\Site;
use App\Repositories\contract\SiteRepositoryInterface;
use App\Services\Netlify;
use App\Services\Wordpress;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SiteRepository implements SiteRepositoryInterface
{
    private $netlify,$wp;

    public function __construct(Netlify $netlify,Wordpress $wp)
    {
        $this->netlify=$netlify;
        $this->wp=$wp;
    }

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
     * @throws Exception
     */
    public function store(array $site): bool
    {
        $domain = Str::slug($site['domain']) . "." . env('WP_DOMAIN');
        $wp=$this->wp->createSite($domain);

        $front=$this->netlify->createSite($domain);

        $build_url=$this->netlify->createBuildHook($front->id);

        $domain="https://".$domain;

        $this->wp->updateNetlifySettings($build_url,$domain,['administrator','editor','author']);

        $new_site=new Site();
        $new_site->name=$site['name'];
        $new_site->domain=$site['domain'];
        $new_site->site_id=$wp;
        $new_site->frontend_id=$front->id;
        $new_site->frontend_url=$front->url;
        $new_site->build_url=$build_url;

        if(isset($site['custom_domain'])){
            $new_site->custom_domain=$site['domain_ssl'].$site['custom_domain'];
        }

        $new_site->touch();
        return $new_site->save();
    }

    public function update($site)
    {
        // TODO: Implement update() method.
    }
}
