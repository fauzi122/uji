<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddCspHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Generate nonce
        $nonce = base64_encode(random_bytes(16));

        // Store nonce in the session for later use in views
        $request->session()->put('csp-nonce', $nonce);

        $response = $next($request);

        // Set the CSP header with nonce
        // $response->headers->set(
        //     'Content-Security-Policy',
        //     "default-src 'self';" .
        //         "script-src 'self' 'unsafe-inline' 'unsafe-eval' example.com https://code.jquery.com https://cdnjs.cloudflare.com;" .  // 'unsafe-eval' added here
        //         "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://code.ionicframework.com https://cdnjs.cloudflare.com;" .
        //         "font-src 'self' https://fonts.gstatic.com;" .
        //         "connect-src 'self';"
        // );

        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self';" .
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' example.com https://code.jquery.com https://cdnjs.cloudflare.com;" . // 'unsafe-eval' added here
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://code.ionicframework.com https://cdnjs.cloudflare.com;" . // cdnjs.cloudflare.com already included
                "font-src 'self' https://fonts.gstatic.com;" .
                "img-src 'self' https://ytimg.com;" . // Added for YouTube images
                "frame-src 'self' https://www.youtube.com https://youtube.com;" . // Added for YouTube iframes
                "connect-src 'self';"
        );



        return $response;
    }
}
