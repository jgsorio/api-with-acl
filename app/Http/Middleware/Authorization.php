<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class Authorization
{
    public function __construct(protected UserRepository $userRepository) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routerName = Route::currentRouteName();
        $user = auth()->user();

        if (!$this->userRepository->hasPermission($user, $routerName)) {
            return response()->json(['error' => 'you do not have permission to access this'], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
