<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class MenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $menuRef = $request->segment(3);

        $menu = Menu::where('path', $menuRef)->select('id')->first();

        if(Auth::user()->hasAaccess($menu->id)){
            return $next($request);
        }

        return response()->json([
            'message' => 'თქვენ არ გაქვთ წვდომა მითითებულ მენიუზე!'
        ], 401);
    }
}
