<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display the resource page for user.
     */
    public function index()
    {
        return view('user.resource');
    }
}
