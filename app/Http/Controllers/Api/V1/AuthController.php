<?php

namespace App\Http\Controllers\Api\V1;

use App\Classes\ApiResponse;
use App\Models\Users\UserLogin;
use App\Models\Users\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class AuthController extends ApiResponse
{

    public function login(Request $request)
    {
        $this->_validRequest($request);
        try {
            $validator = Validator::make($request->all(), [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]);
            if ($validator->fails()) {
                return $this->sendError(implode("\n", $validator->errors()->all()), $validator->errors());
            }
            $username = Str::lower(preg_replace('/\s+/', '', $request->string('username')));
            $password = $request->string('password');
            $ref = $this->_ref($username);
            if ($ref == "email") {
                $query = Pegawai::where('email', $username)->whereNotNull('email');
            } else if ($ref == "nip_nik") {
                $query = Pegawai::where('nip_nik', $username)->whereNotNull('nip_nik');
            } else if ($ref == "nrk_id_pjlp") {
                $query = Pegawai::where('nrk_id_pjlp', $username)->whereNotNull('nrk_id_pjlp');
            } else if ($ref == "phone") {
                $query = Pegawai::where('no_telepon', $username)->whereNotNull('no_telepon');
            } else {
                $query = Pegawai::where('email', $username)->whereNotNull('email')
                    ->orWhere(function (Builder $q) use ($username) {
                        $q->where('nip_nik', $username)
                            ->whereNotNull('nip_nik');
                    })
                    ->orWhere(function (Builder $q) use ($username) {
                        $q->where('nrk_id_pjlp', $username)
                            ->whereNotNull('nrk_id_pjlp');
                    })
                    ->orWhere(function (Builder $q) use ($username) {
                        $q->where('no_telepon', $username)
                            ->whereNotNull('no_telepon');
                    });
            }
            $pegawai = $query->first();

            if (!$pegawai) {
                return $this->sendError(__('auth.failed'));
            }
            $pass_valid = Hash::check($password, $pegawai->password);
            if (!$pass_valid) {
                return $this->sendError(__('auth.failed'));
            }
            if ($pegawai->id_status != 1) {
                return $this->sendError(__('auth.suspend'));
            }

            $client_id = _singleData("central", "sso_client", "id", "client_id = '" . $request->header('client-id') . "'")->id ?? -1;
            $ip_address = $request->ip();
            $user_agent = $request->userAgent();
            $expiry = now()->addWeek();
            $user = UserLogin::where(['user_id' => $pegawai->nrk_id_pjlp])->first();
            if ($user) {
                $user->tokens()->delete();
                $token = $user->createToken($user_agent, ['*'], $expiry)->plainTextToken;
                $data['client_id'] = $client_id;
                $data['token'] = $token;
                $user->update($data);
            } else {
                $data['user_id'] = $pegawai->nrk_id_pjlp;
                $data['client_id'] = $client_id;
                $user = UserLogin::create($data);
                $token = $user->createToken($user_agent, ['*'], $expiry)->plainTextToken;
                $data['token'] = $token;
                $user->update($data);
            }
            $access_token =
                [
                    "token" => "Bearer " . $token,
                    "expiry" => $expiry,
                ];
            $user->access_token = $access_token;

            $d_login['user_id'] = $pegawai->nip;
            $d_login['client_id'] = $client_id;
            $d_login['token'] = $token;
            $d_login['ip_address'] = $ip_address;
            $d_login['user_agent'] = $user_agent;
            $d_login['created_from'] = "Api";
            _insertData("default", "user_activity", $d_login);

            return $this->sendResponse($user, __('response.login_success'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError($e->getMessage(), $e->errors());
        } catch (\Exception $e) {
            if (!app()->isProduction()) {
                return $this->sendError($e->getMessage());
            }
            return $this->sendError(__('response.failed_request'));
        }
    }

    public function forgot(Request $request)
    {
        $this->_validRequest($request);
        try {
            $request->validate(
                [
                    'email' => 'required|email',
                ]
            );
            $email = $request->email;
            $pegawai = Pegawai::where('email', $email)->whereNotNull('email')->first();
            if (!$pegawai) {
                return $this->sendError(__('auth.email'));
            }

            $recovery_id = _newId("default", "password_recovery");
            $code = Str::random(35);
            $expired_at = now()->addMinute(30);
            $url = "https://pemadam.jakarta.go.id/damkarone/reset-password/" . md5($recovery_id . $code);
            $_email = [
                'subject' => 'Reset Password',
                'title' => 'Reset Password',
                'content' => 'email.auth.reset_password',
                'expired_at' => $expired_at->format('d F Y H:i'),
                'url' => $url,
            ];
            $request = app(\App\Classes\EmailController::class)->sendNow($pegawai->email, $_email);
            if (!$request->status) {
                return $this->sendError($request->message);
            }

            $d_recovery['id'] = $recovery_id;
            $d_recovery['ref'] = "pegawai";
            $d_recovery['ref_id'] = $pegawai->nip;
            $d_recovery['email'] = $email;
            $d_recovery['code'] = $code;
            $d_recovery['expired_at'] = $expired_at;
            $d_recovery['status'] = 0;
            $d_recovery['created_from'] = "Apps";
            _insertData("default", "password_recovery", $d_recovery);

            return $this->sendResponse(NULL, __('response.forgot_success'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError($e->getMessage(), $e->errors());
        } catch (\Exception $e) {
            if (!app()->isProduction()) {
                return $this->sendError($e->getMessage());
            }
            return $this->sendError(__('response.failed_request'));
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->update(['token' => '']);
        $user->tokens()->delete();
        return $this->sendResponse(NULL, __('response.logout_success'));
    }

    public function client_auth(Request $request)
    {
        try {
            $request->validate(['auth_code' => 'required|string']);
            $client_id = $request->header('client-id');
            $client_secret = $request->header('client-secret');
            $client = _singleData("central", "sso_client", "id", "client_id = '" . $client_id . "' AND client_secret = '" . $client_secret . "'");
            if (!$client) {
                return $this->sendError(__('response.key_invalid'));
            }
            $auth_code = $request->string('auth_code');
            $row = _singleData("default", "auth_codes", "id,user_id", "client_id = '" . $client->id . "' AND token = '" . $auth_code . "' AND revoked = 0 AND expires_at > NOW()");
            if (!$row) {
                return $this->sendError(__('Invalid authentication code'));
            }
            $pegawai = Pegawai::find($row->user_id);
            if (!$pegawai) {
                return $this->sendError(__('auth.failed'));
            }
            if ($pegawai->id_status != 1) {
                return $this->sendError(__('auth.suspend'));
            }

            $ip_address = $request->ip();
            $user_agent = $request->userAgent();
            $expiry = now()->addWeek();
            $user = UserLogin::where(['user_id' => $pegawai->nrk_id_pjlp])->first();
            if ($user) {
                $user->tokens()->delete();
                $token = $user->createToken($user_agent, ['*'], $expiry)->plainTextToken;
                $data['client_id'] = $client->id;
                $data['token'] = $token;
                $user->update($data);
            } else {
                $data['user_id'] = $pegawai->nrk_id_pjlp;
                $data['client_id'] = $client->id;
                $user = UserLogin::create($data);
                $token = $user->createToken($user_agent, ['*'], $expiry)->plainTextToken;
                $data['token'] = $token;
                $user->update($data);
            }
            $access_token =
                [
                    "token" => "Bearer " . $token,
                    "expiry" => $expiry,
                ];
            $user->access_token = $access_token;

            return $this->sendResponse($user, __('response.login_success'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError($e->getMessage(), $e->errors());
        } catch (\Exception $e) {
            if (!app()->isProduction()) {
                return $this->sendError($e->getMessage());
            }
            return $this->sendError(__('response.failed_request'));
        }
    }

    private function _validRequest()
    {
        $user = auth('employee')->user();
        if ($user) {
            return $this->sendResponse($user, __('response.login_already'));
        }
    }

    private function _ref($_username)
    {
        $ref = "username";
        if (filter_var($_username, FILTER_VALIDATE_EMAIL)) {
            $ref = "email";
        } else if (is_numeric($_username) and strlen($_username) >= 16) {
            $ref = "nip_nik";
        } else if (is_numeric($_username) and strlen($_username) >= 8) {
            $ref = "phone";
        } else if (is_numeric($_username) and strlen($_username) >= 6) {
            $ref = "nrk_id_pjlp";
        }
        return $ref;
    }
}
