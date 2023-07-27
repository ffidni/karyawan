<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Resources\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            "email" => "required|email",
            "password" => "required|string|min:6",
        ]);
        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(HttpResponse::HTTP_BAD_REQUEST, $validatorData['messages']);
        }
        $user = $this->authService->login($data);
        return new Response(HttpResponse::HTTP_OK, "Berhasil login", $user);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            "nama" => "required|string|min:2|max:50",
            "email" => "required|email",
            "password" => "required|string|min:6|max:20",
        ]);

        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(HttpResponse::HTTP_BAD_REQUEST, $validatorData['messages']);
        }
        $user = $this->authService->register($data);
        return new Response(HttpResponse::HTTP_OK, "Berhasil register", $user);

    }

    public function updateUser(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            "nama" => "required|string|min:2|max:50",
            "email" => "required|email",
            "password" => "required|string|min:6|max:20",
        ]);

        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(HttpResponse::HTTP_BAD_REQUEST, $validatorData['messages']);
        }
        $user = $this->authService->updateUser($id, $data);
        return new Response(HttpResponse::HTTP_OK, "Berhasil merubah user", $user);

    }

    public function deleteUser(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|numeric|exists:absensi,id',
        ]);

        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(HttpResponse::HTTP_BAD_REQUEST, $validatorData['messages'], null);
        }

        $this->authService->deleteUser($id);

        return new Response(HttpResponse::HTTP_OK, 'Berhasil menghapus user', null);
    }

    public function me(Request $request)
    {
        $token = $request->header("Authorization");
        $user = $this->authService->me($token);
        return new Response(HttpResponse::HTTP_OK, "Berhasil mendapatkan user", $user);
    }

    public function logout()
    {
        $this->authService->logout();
        return new Response(HttpResponse::HTTP_OK, "Berhasil logout", null);
    }


    public function refreshToken()
    {
        $token = $this->authService->refresh();
        return new Response(HttpResponse::HTTP_OK, "Berhasil refresh token", $token);

    }

}