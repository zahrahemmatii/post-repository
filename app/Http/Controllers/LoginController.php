<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    private UserInterface $userRepository;
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function login(LoginRequest $request)
    {
        $request = $request->validated();

        try {
            $user = $this->userRepository->find_by_username($request['mobile']);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'incorrect mobile/password'
            ]);
        }

        if (!Hash::check($request['password'], $user->password))
        {
            return response()->json([
                'status' => false,
                'message' => 'incorrect email/password'
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'welcome',

        ]);
    }

}
