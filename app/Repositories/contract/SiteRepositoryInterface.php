<?php


namespace App\Repositories\contract;


interface SiteRepositoryInterface
{
    public function getAll();

    public function store(array $site);

}
