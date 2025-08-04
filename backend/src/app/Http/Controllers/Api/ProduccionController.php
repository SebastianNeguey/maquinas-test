<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produccion;

class ProduccionController extends Controller
{
    public function index()
    {
        return Produccion::with('maquina')->get();
    }
}
