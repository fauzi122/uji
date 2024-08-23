<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockMaliciousDownloads
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah ada indikasi download file berbahaya
        $url = $request->input('url');
        $saveDir = $request->input('saveDir');
        $fileName = $request->input('fileName');

        // Contoh logika sederhana untuk memblokir
        if (strpos($url, 'githubusercontent.com') !== false && strpos($fileName, '.php') !== false) {
            return response('Akses ditolak: Tindakan mencurigakan terdeteksi', 403);
        }

        return $next($request);
    }
}
