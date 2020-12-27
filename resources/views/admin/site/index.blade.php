<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight pr-4">
                {{ __('Sites') }}
            </h2>
            <a href="/sites/create" class="bg-blue-400 py-3 px-2 rounded text-white">
                Create A Site
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-fixed">
                        <thead>
                        <tr>
                            <th class="w-1/3">Name</th>
                            <th class="w-1/2">URL</th>
                            <th class="w-1/3">Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sites as $site)
                            <tr>
                                <td>{{$site->name}}</td>
                                <td><a href="{{$site->url}}" target="__blank">{{$site->url}}</a></td>
                                <td>{{$site->updated_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
