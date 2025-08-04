<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inactividad;

class InactividadController extends Controller
{
    public function index()
    {
        return Inactividad::with('produccion')->get();
    }
}
