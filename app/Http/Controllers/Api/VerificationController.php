<?php

namespace App\Http\Controllers\Api;

use App\Events\UserMailVerificationEvent;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller {
	protected $repository;
	
	public function __construct( UserRepository $user_repository ) {
		$this->repository = $user_repository;
	}
	
	/**
	 * Validate email user.
	 *
	 * @param         $user_id
	 * @param Request $request
	 *
	 * @return Application|ResponseFactory|Response
	 */
	public function verify( $user_id, Request $request ) {
		if ( ! $request->hasValidSignature() ) {
			return response( Helper::responseMessage( false, 401, trans( 'lang.invalid_url' ) ), 401 );
		}
		$user = $this->repository->findById( $user_id )->findByFirst();
		if ( ! $user->hasVerifiedEmail() ) {
			$user->markEmailAsVerified();
		}
		
		return response( Helper::responseMessage( true, 200, trans( 'lang.verify_email' ) ), 200 );
	}
	
	/**
	 * Resend mail for verification.
	 *
	 * @return Application|Response|ResponseFactory
	 */
	public function resend( $valid_user = null ) {
		$user = $valid_user !== null ? $valid_user : auth()->user();
		if ( $user->hasVerifiedEmail() ) {
			return response( Helper::responseMessage( false, 400, trans( 'lang.already_verify_email' ) ), 400 );
		}
		event( new UserMailVerificationEvent( $user ) );
		
		return response( Helper::responseMessage( true, 200, trans( 'lang.verify_email_notify' ) ), 200 );
	}
}
