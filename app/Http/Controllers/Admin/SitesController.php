<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SiteRequest;
use App\Models\Site;
use App\Repositories\contract\SiteRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class SitesController extends Controller
{
    private $siteRepo;

    public function __construct(SiteRepositoryInterface $siteRepo)
    {
        $this->siteRepo=$siteRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $sites=$this->siteRepo->getAll();
        return view("admin.site.index",compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        //
        $site=new Site();
        return view('admin.site.create',compact('site'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SiteRequest $request
     * @return RedirectResponse
     */
    public function store(SiteRequest $request)
    {
        //
        $site=$request->all(['name','domain','custom_domain','domain_ssl']);
        if(!$this->siteRepo->store($site)){
            return redirect()->back()->withInput();
        }
        $msg="Successfully Created a Site";
        return redirect()->to("/sites")->with(compact('msg'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(int $id)
    {
        $site=Site::find($id);
        return view('admin.site.view',compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit(int $id)
    {
        //
        $site=Site::find($id);
        return view('admin.site.create',compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SiteRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(SiteRequest $request, $id)
    {
        //
        $site=Site::find($id);
        $this->siteRepo->update($site);
        return Redirect::back()->with(['msg'=>'Successfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
