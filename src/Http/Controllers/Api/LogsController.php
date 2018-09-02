<?php

namespace KABBOUCHI\Ward\Http\Controllers\Api;

use KABBOUCHI\Ward\Ward;
use Illuminate\Pagination\LengthAwarePaginator;
use KABBOUCHI\Ward\Http\Controllers\Controller;

class LogsController extends Controller
{
    public function index()
    {
        Ward::setFile($file = request()->input('file', 'laravel.log'));

        $logs = cache()->remember($file, config('ward.cache_duration', 0), function () {
            return Ward::all();
        });

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $collection = collect($logs);

        $perPage = config('ward.logs_per_page', 6);

        $currentPageSearchResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values()->toArray();

        return new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
    }

    public function dailyLogFiles()
    {
        return collect(Ward::getFiles(true))->filter(function ($file) {
            return strpos($file, 'laravel') === 0;
        });
    }

    /**
     * @param $log
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function show($log)
    {
        return response()->download(Ward::pathToLogFile($log));
    }

    /**
     * @throws \Exception
     */
    public function delete()
    {
        app('files')->delete(Ward::pathToLogFile(request('file')));

        cache()->clear();
    }
}
