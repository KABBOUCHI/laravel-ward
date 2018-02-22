<?php

namespace KABBOUCHI\Ward\Http\Controllers\Api;

use Illuminate\Pagination\LengthAwarePaginator;
use KABBOUCHI\Ward\Http\Controllers\Controller;
use KABBOUCHI\Ward\Ward;

class LogsController extends Controller
{
    public function index()
    {
        $logs = Ward::all();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $collection = collect($logs);

        $perPage = 6;

        $currentPageSearchResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        return new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

    }
}