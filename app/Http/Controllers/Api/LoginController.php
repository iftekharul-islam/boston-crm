<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Requests\AuthLoginRequest;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use League\Fractal\Serializer\ArraySerializer;
use Spatie\Permission\Models\Role;

class LoginController extends BaseController {
    private UserTransformer $transformer;
    private UserRepository $repository;

    public function __construct( UserTransformer $user_transformer, UserRepository $user_repository ) {
        parent::__construct();
        $this->transformer = $user_transformer;
        $this->repository  = $user_repository;
    }

    /**
     * User login with email and password
     *
     * @param AuthLoginRequest $request
     *
     * @return Application|ResponseFactory|Response
     */
    public function login( AuthLoginRequest $request ): Response|Application|ResponseFactory {
        $user = $this->repository->findByEmail( $request->get( 'email' ) );
        if ( ! $user ) {
            return response( Helper::responseMessage( false, 401, trans( 'auth.invalid_email' ) ), 401 );
        }
        if ( ! $user->password ) {
            return response( Helper::responseMessage( false, 401,
                trans( 'auth.social_login', [ 'social' => $user->provider ] ) ), 401 );
        }
        if ( ! Hash::check( $request->get( 'password' ), $user->password ) ) {
            return response( Helper::responseMessage( false, 401, trans( 'auth.failed' ) ), 401 );
        }
        $user->tokens()->delete();
        $user_company = $user->companies()->where( 'active_company', 1 )->first();
        $role         = Role::query()->find( $user_company->pivot->role_id );
        $this->transformer->setAuthToken( $user->createToken( 'auth_token' )->plainTextToken );
        $this->transformer->setPermissions( $role->permissions()->pluck( 'name' ) );
        $this->transformer->setActiveCompany( $user_company );
        $user_data = fractal()->item( $user, $this->transformer )->serializeWith( new ArraySerializer )->toArray();

        return response( Helper::responseMessage( true, 201, trans( 'lang.success_login' ), $user_data ), 201 );
    }

    /**
     * User Token delete on logout
     *
     * @param Request $request
     *
     * @return Application|ResponseFactory|Response
     */
    public function logout( Request $request ): Response|Application|ResponseFactory {
        $request->user()->currentAccessToken()->delete();

        return response( Helper::responseMessage( true, 200, trans( 'lang.success_logout' ) ) );
    }
}
