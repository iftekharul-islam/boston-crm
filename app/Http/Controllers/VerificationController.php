<?php

namespace App\Http\Controllers;

use App\Events\UserMailVerificationEvent;
use App\Helpers\Helper;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller {
    protected UserRepository $repository;

    public function __construct( UserRepository $user_repository ) {
        $this->repository = $user_repository;
    }

    /**
     * Validate email user.
     *
     * @param         $user_id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function verify( $user_id, Request $request ): RedirectResponse {
        if ( ! $request->hasValidSignature() ) {
            return abort( 401 );
        }
        $user = $this->repository->findById( $user_id )->findByFirst();
        if ( ! $user->hasVerifiedEmail() ) {
            $user->markEmailAsVerified();
        }

        return redirect()->route( 'login' );
    }

    /**
     * Resend mail for verification.
     *
     * @param null $valid_user
     *
     * @return Application|Response|ResponseFactory
     */
    public function resend( $valid_user = null ): Response|Application|ResponseFactory {
        $user = $valid_user !== null ? $valid_user : auth()->user();
        if ( $user->hasVerifiedEmail() ) {
            return abort( 400 );
        }
        event( new UserMailVerificationEvent( $user ) );

        return response( Helper::responseMessage( true, 200, trans( 'lang.verify_email_notify' ) ), 200 );
    }
}
