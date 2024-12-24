<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Classes\ApiResponse;

class EnsureHasAccess
{

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/v1/auth/*')) {
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
        } else if ($request->is('api/*')) {
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
            $token = $request->header('Authorization');
            if (!$token) {
                return ApiResponse::sendError(__('response.exception_401'), [], 401);
            }
            $user = auth('employee')->user();
            if (!$user) {
                return ApiResponse::sendError(__('response.exception_403'), [], 403);
            }
            Auth::setUser($user);
        } else {
            $user = auth('web')->user();
            if (!$user) {
                return redirect('auth/login');
            }
        }
        return $next($request);
    }
}
