<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Serializer\ArraySerializer;

class UserController extends BaseController {
	private UserRepository $repository;
	private UserTransformer $transformer;

	/**
	 * @param UserRepository  $user_repository
	 * @param UserTransformer $user_transformer
	 */
	public function __construct( UserRepository $user_repository, UserTransformer $user_transformer ) {
		parent::__construct();
		$this->repository  = $user_repository;
		$this->transformer = $user_transformer;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index( Request $request ): Response {
		if ( auth()->user()->id === 1 ) {
			$users = $this->repository->relations( $request->get( 'include' ) ?? '' )->all();

			return response( Helper::responseMessage( true, 200, trans( 'lang.success' ),
				$this->userCollection( $users, 'user_list' ) ) );
		}

		return response( Helper::responseMessage( false, 404, trans( 'lang.not_found' ) ), 404 );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 *
	 * @return Response
	 */
	public function show( int $id ): Response {
		if ( auth()->user()->id === $id ) {
			$user = $this->repository->find( $id );
			if ( ! $user ) {
				return response( Helper::responseMessage( false, 404, trans( 'lang.not_found' ) ), 404 );
			}

			return response( Helper::responseMessage( true, 200, trans( 'lang.success' ), $this->userItem( $user ) ) );
		}

		return response( Helper::responseMessage( false, 404, trans( 'lang.not_found' ) ), 404 );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 *
	 * @return Response
	 */
	public function destroy( int $id ): Response {
		if ( auth()->user()->id === $id ) {
			$user = $this->repository->find( $id );
			if ( ! $user ) {
				return response( Helper::responseMessage( false, 404, trans( 'lang.not_found' ) ), 404 );
			}
			if ( $user->delete() ) {
				return response( Helper::responseMessage( true, 200, trans( 'lang.success' ) ) );
			}

			return response( Helper::responseMessage( false, 422,
				trans( 'lang.delete_fail', [ 'title' => 'User' ] ) ) );
		}

		return response( Helper::responseMessage( false, 404, trans( 'lang.not_found' ) ), 404 );
	}

	/**
	 * Get User Details.
	 *
	 * @param object $user
	 *
	 * @return array|null
	 */
	public function userItem( object $user ): ?array {
		return fractal()->item( $user, $this->transformer )->serializeWith( new ArraySerializer )->toArray();
	}

	/**
	 * Return User Collection
	 *
	 * @param object $users
	 * @param string $resource_key_name
	 *
	 * @return array
	 */
	public function userCollection( object $users, string $resource_key_name = '' ): array {
		return fractal()->collection( $users, $this->transformer,
			$resource_key_name )->serializeWith( new ArraySerializer )->toArray();
	}
}
