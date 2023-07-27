<?php

use App\Models\User;

function validatorErrorHandler($validator)
{
    $message = implode("\n", $validator->errors()->all());
    // $errors = json_decode($validator->messages(), true);
    return ["messages" => $message];
}

function getUser($param)
{
    $user = User::where("id", $param)
        ->orWhere("email", $param)
        ->first();
    return $user;
}