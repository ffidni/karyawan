<?php
namespace App\Services;

use App\Exceptions\ApiException;
use Illuminate\Http\Response as HttpResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthService
{
    public function login(array $credentials)
    {
        $token = JWTAuth::attempt($credentials);
        if (!$token) {
            throw new ApiException(HttpResponse::HTTP_BAD_REQUEST, "Email atau password salah");
        }
        $userResponse = getUser($credentials['email']);
        $userResponse->token = $token;
        $userResponse->token_type = "bearer";
        $userResponse->token_expires_in = auth()->factory()->getTTL() * 60 + time();
        return $userResponse;
    }

    public function register(array $data)
    {
        $user = User::where("email", $data['email'])->exists();
        if ($user) {
            throw new ApiException(HttpResponse::HTTP_BAD_REQUEST, "Email sudah digunakan akun lain");
        }

        $defaultPass = $data['password'];
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $userResponse = $this->login(["email" => $data['email'], "password" => $defaultPass]);
        return $userResponse;
    }

    public function updateUser($id, array $data)
    {
        $user = User::where("id", $id)->first();
        $user->nama = $data['nama'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::where("id", $id)->first();
        $user->delete();
        return $user;
    }

    public function me($token)
    {
        $user = getUser(auth()->id());
        if (!$user) {
            throw new ApiException(HttpResponse::HTTP_UNAUTHORIZED, "Invalid token", null);
        }
        $user->token = str_replace("Bearer ", "", $token);
        $user->token_type = "bearer";
        $user->token_expires_in = auth()->factory()->getTTL() * 60 + time();
        return $user;
    }

    public function logout()
    {
        return JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refresh()
    {
        // auth()->invalidate();
        $refreshedToken = auth()->fromUser(auth()->user());
        return $refreshedToken;
    }
}