<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Classes\ApiResponse;

class ValidApiClient
{

    public function handle(Request $request, Closure $next): Response
    {
        $client_id = $request->header('client_id');
        $client_secret = $request->header('client_secret');
        if (!$client_id) {
            return ApiResponse::sendError(__('response.client_empty'));
        }
        if (!$client_secret) {
            return ApiResponse::sendError(__('response.key_empty'));
        }
        $row = _singleData("central", "sso_client", "id", "client_id = '" . $client_id . "' AND api = 1 AND `status` = 1 AND is_deleted = 0");
        if (!$row) {
            return ApiResponse::sendError(__('response.client_invalid'));
        }
        $row = _singleData("central", "sso_client", "id", "client_id = '" . $client_id . "' AND client_secret = '" . $client_secret . "' AND api = 1 AND `status` = 1 AND is_deleted = 0");
        if (!$row) {
            return ApiResponse::sendError(__('response.key_invalid'));
        }
        return $next($request);
    }
}
