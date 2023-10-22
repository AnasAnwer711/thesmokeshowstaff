<?php

namespace App\Http\Middleware;

use App\Models\PaymentConfiguration;
use Closure;
use Illuminate\Http\Request;

class EnsurePaymentModuleIsConfigured
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
        $pc = PaymentConfiguration::first();
        if (!$pc) {
            abort (403, 'Admin must configure compulsory modules before using this site.');
        }
        return $next($request);
    }
}
