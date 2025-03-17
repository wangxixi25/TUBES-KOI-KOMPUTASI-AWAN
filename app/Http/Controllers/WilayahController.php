<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    public function getWilayah($level, Request $request)
    {
        $parent = $request->input('parent') ?? '';
        $url = "https://sig.bps.go.id/rest-bridging/getwilayah?level={$level}" . ($parent ? "&parent={$parent}" : '');

        $response = Http::get($url);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Gagal mengambil data'], 500);
    }
}
