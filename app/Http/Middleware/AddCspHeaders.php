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

        // $response->headers->set(
        //     'Content-Security-Policy',
        //     "default-src 'self';" .
        //         "script-src 'self' https://code.jquery.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://ajax.googleapis.com;" .
        //         "style-src 'self' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;" .
        //         "img-src 'self' data: https://ytimg.com;" .
        //         "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net;" .
        //         "frame-src 'self' https://www.youtube.com https://youtube.com;" .
        //         "connect-src 'self' https://127.0.0.1:8000;" .
        //         "object-src 'none';" .  // Memblokir penggunaan object tag untuk meningkatkan keamanan
        //         "base-uri 'self';" .  // Membatasi penggunaan base tag untuk mencegah serangan terkait redirection
        //         "form-action 'self';" .  // Membatasi pengiriman form hanya ke domain yang sama
        //         "frame-ancestors 'none';" .  // Mencegah aplikasi di-embed dalam iframe
        //         "report-uri /csp-violation-report-endpoint;"  // Endpoint untuk menerima laporan pelanggaran CSP
        // );

        // $response->headers->set(
        //     'Content-Security-Policy',
        //     "default-src 'self';" .
        //         "script-src 'self' https://code.jquery.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://ajax.googleapis.com;" .
        //         "style-src 'self' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;" .
        //         "img-src 'self' data: https://ytimg.com;" .
        //         "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net;" .
        //         "frame-src 'self' https://www.youtube.com https://youtube.com;" .
        //         "connect-src 'self' https://127.0.0.1:8000;" .
        //         "object-src 'none';" .  // Memblokir penggunaan object tag untuk meningkatkan keamanan
        //         "base-uri 'self';" .  // Membatasi penggunaan base tag untuk mencegah serangan terkait redirection
        //         "form-action 'self';" .  // Membatasi pengiriman form hanya ke domain yang sama
        //         "frame-ancestors 'none';" .  // Mencegah aplikasi di-embed dalam iframe
        //         "report-uri /csp-violation-report-endpoint;"  // Endpoint untuk menerima laporan pelanggaran CSP
        // );
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self';" .
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://code.jquery.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://ajax.googleapis.com http://localhost:5173;" .
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://unpkg.com http://localhost:5173;" .
                "img-src 'self' https://ytimg.com http://localhost:5173;" .
                "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net;" .
                "frame-src 'self' https://www.youtube.com https://youtube.com;" .
                "connect-src 'self' ws://localhost:5173 http://127.0.0.1:8001 http://127.0.0.1:8000 https://127.0.0.1:8000 https://apibap.bsi.ac.id;" // Menambahkan http dan https di port 8000
        );

        return $response;
    }
}
