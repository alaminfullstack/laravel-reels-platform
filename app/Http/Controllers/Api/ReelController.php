<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reel;
use Illuminate\Http\Request;

class ReelController extends Controller
{
    public function index()
    {
        $reels = Reel::paginate(3);
        return response()->json($reels);
    }
}
