<?php

namespace KABBOUCHI\Ward\Http\Controllers;

class WardController extends Controller
{
    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ward::app');
    }
}
