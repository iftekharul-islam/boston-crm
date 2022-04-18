<?php

namespace App\Http\Controllers\Api;

use App\Events\ResetPasswordEvent;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller {
    protected UserRepository $repository;

    /**
     * @param UserRepository $user_repository
     */
    public function __construct( UserRepository $user_repository ) {
        $this->repository = $user_repository;
    }

    /**
     * @param ForgetPasswordRequest $request
     *
     * @return Application|ResponseFactory|Response
     */
    public function forgetPassword( ForgetPasswordRequest $request ): Response|Application|ResponseFactory {
        $user = $this->repository->findByEmail( $request->email );
        if ( ! $user ) {
            return response( Helper::responseMessage( false, 404, trans( 'lang.can_not_find_email' ) ) );
        }
        event( new ResetPasswordEvent( $user ) );

        return response( Helper::responseMessage( true, 200, trans( 'lang.mail_send' ) ) );
    }

    /**
     * @param ResetPasswordRequest $request
     *
     * @return Application|ResponseFactory|Response
     */
    public function resetPassword( ResetPasswordRequest $request ): Response|Application|ResponseFactory {
        $status = Password::reset( $request->only( 'email', 'password', 'password_confirmation', 'token' ),
            function ( $user ) use ( $request ) {
                $user->forceFill( [
                    'password'       => Hash::make( $request->password ),
                    'remember_token' => Str::random( 60 ),
                ] )->save();
                $user->tokens()->delete();
                event( new PasswordReset( $user ) );
            } );
        if ( $status == Password::PASSWORD_RESET ) {
            return response( Helper::responseMessage( true, 200, trans( 'lang.password_reset_successfully' ) ) );
        }

        return response( Helper::responseMessage( false, 401, __( $status ) ) );
    }
}
