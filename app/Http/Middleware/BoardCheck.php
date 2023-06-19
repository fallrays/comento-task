<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Board;

class BoardCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // board_id 체크
        if (!$request->board_id) {
            return response([], '404');
        }
        // 원글존재 체크
        $board = Board::find($request->board_id);
        if (empty($board)) {
            return response([], '404');
        }

        return $next($request);
    }
}
