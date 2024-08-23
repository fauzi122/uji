<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckForMaliciousUploads
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
        $maliciousExtensions = ['php', 'php3', 'php4', 'php5', 'phtml'];
        $files = Storage::disk('public')->allFiles();

        foreach ($files as $file) {
            if (in_array(pathinfo($file, PATHINFO_EXTENSION), $maliciousExtensions)) {
                Storage::disk('public')->delete($file);
            }
        }

        return $next($request);
    }
}
