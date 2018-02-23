<?php

namespace KABBOUCHI\Ward\Http\Controllers\Api;

use Illuminate\Pagination\LengthAwarePaginator;
use KABBOUCHI\Ward\Http\Controllers\Controller;
use KABBOUCHI\Ward\Ward;

class LogsController extends Controller
{
    public function index()
    {

        Ward::setFile(base64_decode($file = request()->input('file', 'laravel.log')));

        $logs = cache()->remember($file, 1, function () {
            return Ward::all();
        });

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $collection = collect($logs);

        $perPage = 6;

        $currentPageSearchResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        return new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

    }

    public function dailyLogFiles()
    {
        return collect(Ward::getFiles(true))->filter(function ($file) {
            return strpos($file, "laravel") === 0;
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
    }

}