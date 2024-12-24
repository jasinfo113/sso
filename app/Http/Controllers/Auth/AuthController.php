<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Users\Pegawai;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function validate(Request $request)
    {
        $this->_validRequest($request);
        try {
            $validator = Validator::make($request->all(), [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
                'device' => ['string'],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => FALSE,
                    'message' => implode("\n", $validator->errors()->all())
                ]);
            }
            $username = Str::lower(preg_replace('/\s+/', '', $request->username));
            $password = $request->password;
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
                return response()->json([
                    'status' => FALSE,
                    'message' => __('auth.failed')
                ]);
            }
            $pass_valid = Hash::check($password, $pegawai->password);
            if (!$pass_valid) {
                return response()->json([
                    'status' => FALSE,
                    'message' => __('auth.failed')
                ]);
            }
            Auth::login($pegawai); //, $request->boolean('remember')

            $request->session()->regenerate();
            $token = $request->session()->token();
            $ip_address = $request->ip();
            $user_agent = $request->userAgent();

            $d_login['user_id'] = $pegawai->nip;
            $d_login['token'] = $token;
            $d_login['description'] = "User melakukan login via Web SSO";
            $d_login['ip_address'] = $ip_address;
            $d_login['user_agent'] = $user_agent;
            $d_login['created_from'] = "Web";
            _insertData("default", "user_activity", $d_login);

            $_email = [
                'subject' => 'Informasi Login',
                'title' => 'Informasi Login',
                'content' => 'email.auth.login',
                'ip_address' => $ip_address,
                'user_agent' => $user_agent,
            ];
            app(\App\Classes\EmailController::class)->queue($pegawai->email, $_email);

            return response()->json([
                'status' => TRUE,
                'message' => __('response.login_success'),
                'url' => route('dashboard')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => FALSE,
                'message' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            if (!app()->isProduction()) {
                return response()->json([
                    'status' => FALSE,
                    'message' => $e->getMessage()
                ]);
            }
            return response()->json([
                'status' => FALSE,
                'message' => __('response.failed_request')
            ]);
        }
    }

    public function forgot()
    {
        return view('auth.forgot-password');
    }

    public function forgot_save(Request $request)
    {
        $this->_validRequest($request);
        try {
            $request->validate(
                [
                    'email' => 'required|email',
                ]
            );
            $email = $request->email;
            $user = _singleData("default", "users", "id,email,status_id", "email = '" . $email . "' AND email IS NOT NULL AND is_deleted = 0");
            if (!$user) {
                return response()->json([
                    'status' => FALSE,
                    'message' => __('auth.email')
                ]);
            }
            if ($user->status_id != 1) {
                return response()->json([
                    'status' => FALSE,
                    'message' => __('auth.suspend')
                ]);
            }

            $recovery_id = _newId("default", "password_recovery");
            $code = Str::random(35);
            $expired_at = now()->addMinute(30);
            $url = "https://pemadam.jakarta.go.id/sso/reset-password/" . md5($recovery_id . $code);
            $_email = [
                'subject' => 'Reset Password',
                'title' => 'Reset Password',
                'content' => 'email.auth.reset_password',
                'expired_at' => $expired_at->format('d F Y H:i'),
                'url' => $url,
            ];
            $request = app(\App\Classes\EmailController::class)->sendNow($user->email, $_email);
            if (!$request->status) {
                return response()->json([
                    'status' => FALSE,
                    'message' => $request->message
                ]);
            }

            $d_recovery['id'] = $recovery_id;
            $d_recovery['ref'] = "user";
            $d_recovery['ref_id'] = $user->id;
            $d_recovery['email'] = $email;
            $d_recovery['code'] = $code;
            $d_recovery['expired_at'] = $expired_at;
            $d_recovery['status'] = 0;
            $d_recovery['created_from'] = "SSO";
            _insertData("default", "password_recovery", $d_recovery);

            return response()->json([
                'status' => TRUE,
                'message' => __('response.forgot_success')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => FALSE,
                'message' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            if (!app()->isProduction()) {
                return response()->json([
                    'status' => FALSE,
                    'message' => $e->getMessage()
                ]);
            }
            return response()->json([
                'status' => FALSE,
                'message' => __('response.failed_request')
            ]);
        }
    }

    public function reset_password(Request $request)
    {
        if ($request->key) {
            $key = $request->key;
            $row = _singleData("default", "password_recovery", "email,DATE_FORMAT(expired_at, '%d %M %Y %H:%i') AS expired_at,`status`,IF(expired_at > NOW() AND `status` = 0, 1, 0) AS is_valid,IF(NOW() > expired_at, 1, 0) is_expired", "MD5(CONCAT(id,`code`)) = '" . $key . "'");
            $data["key"] = $key;
            $data["row"] = $row;
            return view('auth.reset-password', $data);
        }
        abort(404);
    }

    public function reset_password_save(Request $request)
    {
        $this->_validRequest($request);
        try {
            $request->validate([
                'key' => ['required', 'string'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            $key = $request->string('key');
            $row = _singleData("default", "password_recovery", "*", "MD5(CONCAT(id,`code`)) = '" . $key . "' AND expired_at > NOW() AND `status` = 0");
            if (!$row) {
                return response()->json([
                    'status' => FALSE,
                    'message' => __('response.data_invalid')
                ]);
            }

            return response()->json([
                'status' => FALSE,
                'message' => "valid"
            ]);

            if ($row->ref == "user" and $row->ref_id > 0) {
                $d_user['password'] = Hash::make($request->password);
                $d_user['remember_token'] = Str::random(100);
                _updateData("default", "users", $d_user, "id = '" . $row->ref_id . "'");

                $d_history['user_id'] = $row->ref_id;
                $d_history['description'] = "User melakukan perubahan password";
                $d_history['ip_address'] = $request->ip();
                $d_history['user_agent'] = $request->userAgent();
                $d_history['created_from'] = "Web";
                $d_history['created_by'] = -1;
                _insertData("default", "user_history", $d_history);
            } else if ($row->ref == "pegawai" and $row->ref_id > 0) {
                $d_pegawai['password'] = Hash::make($request->password);
                $d_pegawai['updated_at'] = now();
                $d_pegawai['updated_from'] = "Web";
                $d_pegawai['updated_by'] = -1;
                _updateData("central", "pegawai", $d_pegawai, "nip_nik = '" . $row->ref_id . "'");

                $d_history['nip_nik'] = $row->ref_id;
                $d_history['description'] = "Pegawai melakukan perubahan password";
                $d_history['ip_address'] = $request->ip();
                $d_history['user_agent'] = $request->userAgent();
                $d_history['created_from'] = "Web";
                $d_history['created_by'] = -1;
                _insertData("central", "pegawai_history", $d_history);
            }

            $d_recovery['ref'] = $row->ref;
            $d_recovery['ref_id'] = $row->ref_id;
            $d_recovery['email'] = $row->email;
            $d_recovery['code'] = $row->code;
            $d_recovery['expired_at'] = $row->expired_at;
            $d_recovery['status'] = 1;
            $d_recovery['created_at'] = $row->created_at;
            $d_recovery['created_from'] = $row->created_from;
            $d_recovery['updated_from'] = "Web";
            _insertData("default", "password_recovery_history", $d_recovery);

            _deleteData("default", "password_recovery", "id = '" . $row->id . "'");

            $_email = [
                'subject' => 'Informasi Perubahan Password',
                'title' => 'Informasi Perubahan Password',
                'content' => 'email.auth.change_password',
            ];
            app(\App\Classes\EmailController::class)->queue($row->email, $_email);
            return response()->json([
                'status' => TRUE,
                'message' => __($status),
                'url' => route('auth/login?email=' . $row->email)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => FALSE,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    private function _validRequest(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'status' => FALSE,
                'message' => __('response.no_process')
            ]);
        }
        if (Auth::check()) {
            return response()->json([
                'status' => TRUE,
                'message' => __('response.login_already'),
                'url' => route('dashboard')
            ]);
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
