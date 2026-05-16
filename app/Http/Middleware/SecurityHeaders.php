<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Tambahkan security headers ke setiap response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Cegah iframe clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Cegah MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Aktifkan XSS protection di browser lama
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Batasi referrer info yang dikirim ke situs lain
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Larang akses kamera, mikrofon, geolocation, dll
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        return $response;
    }
}
