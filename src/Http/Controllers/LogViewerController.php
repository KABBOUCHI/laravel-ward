<?php

namespace KABBOUCHI\LogViewer\Http\Controllers;

class LogViewerController extends Controller
{
    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('log-viewer::app');
    }
}