<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteUserUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\CompanyUser;
use App\Models\UserInvite;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserRepository;
use App\Services\CompanyService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends BaseController
{
	 protected CompanyService $service;
	 protected UserService $userService;
	 protected UserRepository $repository;
	 protected UserProfileRepository $profileRepository;

	 /**
		* @param CompanyService        $company_service
		* @param UserService           $user_service
		* @param UserRepository        $user_repository
		* @param UserProfileRepository $profile_repository
		*/
	 public function __construct(
		 CompanyService $company_service,
		 UserService $user_service,
		 UserRepository $user_repository,
		 UserProfileRepository $profile_repository
	 ) {
			parent::__construct();
			$this->service           = $company_service;
			$this->userService       = $user_service;
			$this->repository        = $user_repository;
			$this->profileRepository = $profile_repository;
	 }

	 /**
		* Display a listing of the resource.
		*
		* @return Application|Factory|View
		*/
	 public function index(): View|Factory|Application
	 {
			$company_users = $this->service->getCompanyAllUsers();
			$company       = $company_users['company'];
			$users         = $company_users['users'];
			$roles         = $this->service->getCompanyAllRoles();

			return view( 'user.index', compact( 'users', 'company', 'roles' ) );
	 }

	 /**
		* Show the form for creating a new resource.
		*
		* @return Application|Factory|View
		*/
	 public function create(): View|Factory|Application
	 {
			$roles = $this->service->getCompanyAllRoles();

			return view( 'user.create', compact( 'roles' ) );
	 }

	 /**
		* Store a newly created resource in storage.
		*
		* @param UserCreateRequest $request
		*
		* @return JsonResponse
		*/
	 public function store(UserCreateRequest $request): JsonResponse
	 {
			$company = $this->service->getAuthUserCompany();
			DB::transaction( function () use ($request, $company) {
				 $code = Str::random( 20 );
				 $this->service->createUser( [
					 'email' => $request->get( 'email' ),
				 ] )->syncWithCompany( $company, $request->get( 'role' ) )->createInvite( email: $request->get( 'email' ),
					 code: $code )->sendMailToUser( code: $code );
			} );

			return response()->json([
                'success' => true,
                'email' => $request->get( 'email' )
            ]);
	 }

	 /**
		* @param int $id
		*
		* @return Application|Factory|View
		*/
	 public function edit(int $id): View|Factory|Application
	 {
			$user         = $this->repository->find( $id );
			$company      = $user->companies()->first();
			$roles        = $this->service->getCompanyAllRoles();
			$company_user = CompanyUser::query()->where( 'company_id', $company->id )->where( 'user_id', $user->id )->first();

			return view( 'user.edit', compact( 'user', 'company_user', 'roles' ) );
	 }

	 /**
		* @param UserUpdateRequest $request
		* @param int               $id
		*
		* @return JsonResponse
		*/
	 public function update(UserUpdateRequest $request, int $id): JsonResponse
	 {
			$user    = $this->repository->find( $id );
			$company = $user->companies()->first();
			CompanyUser::query()->where( 'company_id', $company->id )->where( 'user_id',
				$user->id )->first()->update( [ 'role_id' => $request->get( 'role' ) ] );

			return response()->json( [ 'success' => true ] );
	 }

	 /**
		* Remove the specified resource from storage.
		*
		* @param int $id
		*
		* @return JsonResponse
		*/
	 public function destroy(int $id): JsonResponse
	 {
			return response()->json( [ 'success' => $this->repository->delete( $id ) ] );
	 }

	 /**
		* Company user status change.
		*
		* @param int $id
		*
		* @return JsonResponse
		*/
	 public function statusChange(int $id): JsonResponse
	 {
			$user = $this->repository->find( $id );
			if ( $user ) {
				 $company      = $user->companies()->first();
				 $company_user = CompanyUser::query()->where( 'company_id', $company->id )->where( 'user_id',
					 $user->id )->first();
				 $company_user->update( [ 'status' => ! $company_user->status ] );

				 return response()->json( [ 'success' => true ] );
			}

			return response()->json( [ 'success' => false ], 404 );
	 }

	 /**
		* @param $code
		*
		* @return Application|Factory|View
		*/
	 public function acceptInviteUser($code): Application|Factory|View
	 {
			$invite_user = UserInvite::query()->where( 'code', $code )->first();
			if ( $invite_user ) {
				 $user    = $this->repository->findByEmail( email: $invite_user->email );
				 $company = $user->companies()->first();

				 return view( 'auth.invite-user-registration', compact( 'user', 'company' ) );
			}

			return abort( 404 );
	 }

	 /**
		* @param InviteUserUpdateRequest $request
		* @param int                     $id
		*
		* @return RedirectResponse
		*/
	 public function inviteUserUpdate(InviteUserUpdateRequest $request, int $id): RedirectResponse
	 {
			$user = $this->repository->find( $id );
			DB::transaction( function () use ($request, $user) {
				 $company = $user->companies()->first();
				 $this->userService->updateUser( [
					 'name'     => $request->get( 'name' ),
					 'password' => Hash::make( $request->get( 'password' ) ),
				 ], $user )->updateProfile( attributes: [
					 'address'  => $request->get( 'address' ),
					 'city'     => $request->get( 'city' ),
					 'state'    => $request->get( 'state' ),
					 'zip_code' => $request->get( 'zip_code' ),
					 'phone'    => $request->get( 'phone' ),
				 ], user_id: $user->id )->activeUser( company_id: $company->id,
					 user_id: $user->id )->profileImage( request: $request, image: $request->file( 'image' ),
					 user: $user )->deleteInvite( email: $user->email );
			} );

			return redirect()->route( 'login' );
	 }

	 /**
		* @return Application|Factory|View
		*/
	 public function getProfile(): View|Factory|Application
	 {
			$profile = $this->profileRepository->getAuthUserProfile();
			$company = $this->service->getAuthUserCompany();
			$user    = auth()->user();

			return view( 'user.user-profile', compact( 'profile', 'company', 'user' ) );
	 }

	 /**
		* @param ProfileUpdateRequest $request
		*
		* @return RedirectResponse
		*/
	 public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
	 {
			$user    = auth()->user();
			$company = $this->service->getAuthUserCompany();
			DB::transaction( function () use ($request, $user, $company) {
				 $this->userService->updateCompanyName( company: $company, user: $user,
					 company_name: $request->get( 'company_name' ) )->updateUserName( user: $user,
						 user_name: $request->get( 'user_name' ) )->updateProfileInformation( attributes: [
						 'address'  => $request->get( 'address' ),
						 'city'     => $request->get( 'city' ),
						 'state'    => $request->get( 'state' ),
						 'zip_code' => $request->get( 'zip_code' ),
						 'phone'    => $request->get( 'phone' ),
					 ], user_id: $user->id )->profileImage( request: $request, image: $request->file( 'image' ), user: $user );
			} );

			return redirect()->route( 'profile' )->with('success', 'Profile Update successfully.');
	 }

     public function updateColor(Request $request,$id){
        $user = User::find($id);
        $user->color_id= $request->get('color_id');
        $user->save();
        return response()->json( [ 'success' => true ] );
     }

    public function authUser()
    {
        return Auth::user();
    }
    public function userList()
    {
        return User::all();
    }
}
