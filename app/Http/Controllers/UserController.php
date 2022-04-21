<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserRepository;
use App\Services\CompanyService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;

class UserController extends Controller
{
	protected CompanyService $service;
	protected UserRepository $repository;
	protected UserProfileRepository $profileRepository;
	
	/**
	 * @param CompanyService        $company_service
	 * @param UserRepository        $user_repository
	 * @param UserProfileRepository $profile_repository
	 */
	public function __construct(
		CompanyService $company_service,
		UserRepository $user_repository,
		UserProfileRepository $profile_repository
	) {
		$this->service           = $company_service;
		$this->repository        = $user_repository;
		$this->profileRepository = $profile_repository;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Application|Factory|View
	 */
	public function index(): View|Factory|Application {
		$company_users = $this->service->getCompanyAllUsers();
		$company       = $company_users['company'];
		$users         = $company_users['users'];
		
		return view('user.index', compact('users', 'company'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Application|Factory|View
	 */
	public function create(): View|Factory|Application {
		$roles = $this->service->getCompanyAllRoles();
		
		return view('user.create', compact('roles'));
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param UserCreateRequest $request
	 *
	 * @return RedirectResponse
	 */
	#[NoReturn] public function store(UserCreateRequest $request): RedirectResponse {
		$company = $this->service->getAuthUserCompany();
		DB::transaction(function () use ($request, $company) {
			$password = Str::random(10);
			$this->service->createUser([
				'name'     => $request->get('name'),
				'email'    => $request->get('email'),
				'password' => Hash::make($password),
			])->syncWithCompany($company, $request->get('role'))->sendMailToUser($password);
		});
		
		return redirect()->route('users.index');
	}
	
	/**
	 * @param int $id
	 *
	 * @return Application|Factory|View
	 */
	public function edit(int $id): View|Factory|Application {
		$user         = $this->repository->find($id);
		$company      = $user->companies()->first();
		$roles        = $this->service->getCompanyAllRoles();
		$company_user = CompanyUser::query()->where('company_id', $company->id)->where('user_id', $user->id)->first();
		
		return view('user.edit', compact('user', 'company_user', 'roles'));
	}
	
	/**
	 * @param UserUpdateRequest $request
	 * @param int               $id
	 *
	 * @return RedirectResponse
	 */
	public function update(UserUpdateRequest $request, int $id) {
		$user    = $this->repository->find($id);
		$company = $user->companies()->first();
		CompanyUser::query()->where('company_id', $company->id)->where('user_id',
			$user->id)->first()->update([ 'role_id', $request->get('role') ]);
		
		return redirect()->route('users.index');
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 *
	 * @return JsonResponse
	 */
	public function destroy(int $id): JsonResponse {
		return response()->json([ 'success' => $this->repository->delete($id) ]);
	}
	
	/**
	 * @param $email
	 *
	 * @return RedirectResponse
	 */
	public function acceptInviteUser($email): RedirectResponse {
		$user         = $this->repository->findByEmail($email);
		$company      = $user->companies()->first();
		$company_user = CompanyUser::query()->where('company_id', $company->id)->where('user_id', $user->id)->first();
		if ( ! $company_user->status ) {
			$company_user->update([ 'status' => 1, 'join_date' => Carbon::now()->format('Y-m-d') ]);
		}
		
		return redirect()->route('login');
	}
	
	/**
	 * @return Application|Factory|View
	 */
	public function getProfile(): View|Factory|Application {
		$profile = $this->profileRepository->getAuthUserProfile();
		$company = $this->service->getAuthUserCompany();
		$user    = auth()->user();
		
		return view('user.user-profile', compact('profile', 'company', 'user'));
	}
	
	/**
	 * @param ProfileUpdateRequest $request
	 *
	 * @return RedirectResponse
	 */
	public function updateProfile(ProfileUpdateRequest $request): RedirectResponse {
		$user    = auth()->user();
		$company = $this->service->getAuthUserCompany();
		DB::transaction(function () use ($request, $user, $company) {
			if ( $company->owner_id === $user->id ) {
				Company::where('id', $company->id)->update([ 'name' => $request->get('company_name') ]);
			}
			$user->update([ 'name' => $request->get('user_name') ]);
			$profile = $this->profileRepository->updateProfile(attributes: [
				'address'  => $request->get('address'),
				'city'     => $request->get('city'),
				'state'    => $request->get('state'),
				'zip_code' => $request->get('zip_code'),
				'phone'    => $request->get('phone'),
			], user_id: $user->id);
			if ( $request->has('image') ) {
				$this->profileRepository->updateProfileImage(profile_id: $profile->id, image: $request->file('image'));
			}
		});
		
		return redirect()->route('profile');
	}
}
