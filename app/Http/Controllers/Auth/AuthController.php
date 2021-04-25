<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ClientLoginRequest;
use App\Http\Requests\Auth\CodeRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\Client;
use App\Models\Sms;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    use ResponseTrait;

    /**
     * @param UserLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginUser(UserLoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            if (Hash::check($data['password'], $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response['token'] = $token;
                return self::okResponse($response);
            }
            $response['message'] = "Password mismatch";
            return self::badResponse($response);
        }
        return self::notFoundResponse();
    }

    /**
     * @param ClientLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginClient(ClientLoginRequest $request)
    {
        $data = $request->validated();
        $client = Client::where('phone', $data['phone'])->first();

        if($client) {
            $code = rand(000000, 999999);
            $token = config('app.turbo_token');
            $sms = Sms::where('phone', $data['phone'])->first();
            if($sms) {
                $sms->update(['code' => $code]);
            } else {
                 Sms::create([
                    'phone' => $data['phone'],
                    'code' => $code
                ]);
            }

            $url = "https://api.turbosms.ua/message/send.json?recipients[0]=" . $data['phone'] . "&sms[sender]=TAXI&sms[text]=" . $code . "&token=" . $token;
            Http::get($url);
            return self::okResponse([['message' => 'Code was sent on your phone']]);
        }
        return self::notFoundResponse();
    }

    /**
     * @param CodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function phoneCode(CodeRequest $request)
    {
        $data = $request->validated();
        $code = Sms::where('phone', $data['phone'])->where('code', $data['code'])->first();
        if($code) {
            $client = Client::where('phone', $data['phone'])->first();
            $token = $client->createToken('Laravel Password Grant Client')->accessToken;
            $response['token'] = $token;
            return self::okResponse($response);
        }
        return self::badResponse(['message' => 'Code is not right']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $token = auth()->user()->token();
        $token->revoke();
        $response['message'] = 'You have been successfully logged out!';
        return self::okResponse($response);
    }
}





