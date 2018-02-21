<?php

namespace KABBOUCHI\Ward\Http\Controllers\Api;

use KABBOUCHI\Ward\Http\Controllers\Controller;
use KABBOUCHI\Ward\Ward;

class LogsController extends Controller
{
    public function index()
    {
        return Ward::all();
    }
}