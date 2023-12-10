<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserLoginRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Repositories\UserRepository;
use App\Services\TokenManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use ThrottlesLogins;

    /** @param User $user */
    public function __construct(
        private UserRepository $userRepository,
        private HashManager $hash,
        private TokenManager $tokenManager,
        private UserService $userService,
        private ?Authenticatable $user
    ) {
    }

    public function login(UserLoginRequest $request)
    {
        /** @var User|null $user */
        $user = $this->userRepository->getFirstWhere('email', $request->email);

        if (!$user || !$this->hash->check($request->password, $user->password)) {
            abort(Response::HTTP_UNAUTHORIZED, 'Invalid credentials');
        }

        $token = $this->tokenManager->createCompositionToken($user);

        return response()->json([
            'token' => $token->apiToken,
            'audio-token' => $token->audioToken,
        ]);
    }

    public function register(UserLoginRequest $request)
    {
        /** @var User|null $user */
        $user = $this->userRepository->getFirstWhere('email', $request->email);
        if($user || $request->password != $request->rePassword){
            abort(Response::HTTP_UNAUTHORIZED, 'Invalid credentials');
        }else{
            
            return UserResource::make($this->userService->createUser(
                $request->fullName,
                $request->email,
                $request->password,
                false
            ));
        }


    }

    public function logout(Request $request)
    {
        if ($this->user) {
            attempt(fn () => $this->tokenManager->deleteCompositionToken($request->bearerToken()));
        }

        return response()->noContent();
    }
}
