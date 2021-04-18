<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="/sites @if(!empty($site->id))/{{$site->id}}@endif" method="POST">
                        @csrf
                        @if(!empty($errors->get('server_errors')))
                            <div class="flex items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-red-100 bg-red-700 border border-red-700 ">
                                <div slot="avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon w-5 h-5 mx-2">
                                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    </svg>
                                </div>
                                <div class="font-normal max-w-full flex-initial">
                                    <h2>Server Error:</h2>
                                    @foreach($errors->get('server_errors') as $error)
                                        {{$error}}
                                    @endforeach
                                </div>
                            </div>

                        @endif
                        @if(!empty($site->id))
                            @method('PUT')
                        @endif
                        <div class="form-group pb-2 ">
                            <label>Site Name:</label>
                            <input type="text" value="{{$site->name}}" class="w-full rounded @if($errors->has('name')) border-red-300  @else border-gray-300 @endif" name="name" />
                        </div>
                        <div class="form-group pb-2">
                            <label>Domain Name:</label>
                            <div class="flex flex-wrap items-stretch">
                                <div class="items-center flex flex-wrap bg-gray-300 rounded-l">
                                    <span class="px-3">https://</span>
                                </div>
                                <div class="flex-1">
                                    <input type="text" value="{{$site->domain}}" class="w-full @if($errors->has('domain')) border-red-300  @else border-gray-300 @endif" name="domain"  />
                                </div>
                                <div class="items-center flex flex-wrap bg-gray-300 rounded-r">
                                    <span class="px-3">rstechnologies.com.au</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pb-2">
                            <label>Custom Domain:</label>
                            <div class="flex flex-wrap items-stretch">
                                <div>
                                    <select name="domain_ssl" class="border-r-0 rounded-l bg-gray-300 border-gray-300">
                                        <option>https://</option>
                                        <option>http://</option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <input type="text" value="{{$site->custom_domain}}" class="w-full rounded-r border-gray-300" name="custom_domain"  />
                                </div>
                            </div>
                        </div>
                        <div class="form-group pb-2">
                            <button class="px-4 py-3 bg-blue-400 text-white rounded">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
