<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\CompanyUser;
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

class UserController extends Controller {
    protected CompanyService $service;
    protected UserRepository $repository;

    /**
     * @param CompanyService $company_service
     * @param UserRepository $user_repository
     */
    public function __construct( CompanyService $company_service, UserRepository $user_repository ) {
        $this->service    = $company_service;
        $this->repository = $user_repository;
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

        return view( 'user.index', compact( 'users', 'company' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application {
        $roles = $this->service->getCompanyAllRoles();

        return view( 'user.create', compact( 'roles' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateRequest $request
     *
     * @return RedirectResponse
     */
    #[NoReturn] public function store( UserCreateRequest $request ): RedirectResponse {
        $company = $this->service->getAuthUserCompany();
        DB::transaction( function () use ( $request, $company ) {
            $password = Str::random( 10 );
            $this->service->createUser( [
                'name'     => $request->get( 'name' ),
                'email'    => $request->get( 'email' ),
                'password' => Hash::make( $password ),
            ] )->syncWithCompany( $company, $request->get( 'role' ) )->sendMailToUser( $password );
        } );

        return redirect()->route( 'users.index' );
    }

    /**
     * @param int $id
     *
     * @return Application|Factory|View
     */
    public function edit( int $id ): View|Factory|Application {
        $user         = $this->repository->find( $id );
        $company      = $user->companies()->first();
        $roles        = $this->service->getCompanyAllRoles();
        $company_user = CompanyUser::query()->where( 'company_id', $company->id )->where( 'user_id',
            $user->id )->first();

        return view( 'user.edit', compact( 'user', 'company_user', 'roles' ) );
    }

    public function update( UserUpdateRequest $request, int $id ) {
        $user    = $this->repository->find( $id );
        $company = $user->companies()->first();
        CompanyUser::query()->where( 'company_id', $company->id )->where( 'user_id',
            $user->id )->first()->update( [ 'role_id', $request->get( 'role' ) ] );

        return redirect()->route( 'users.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy( int $id ): JsonResponse {
        return response()->json( [ 'success' => $this->repository->delete( $id ) ] );
    }

    /**
     * @param $email
     *
     * @return RedirectResponse
     */
    public function acceptInviteUser( $email ): RedirectResponse {
        $user         = $this->repository->findByEmail( $email );
        $company      = $user->companies()->first();
        $company_user = CompanyUser::query()->where( 'company_id', $company->id )->where( 'user_id',
            $user->id )->first();
        if ( ! $company_user->status ) {
            $company_user->update( [ 'status' => 1, 'join_date' => Carbon::now()->format( 'Y-m-d' ) ] );
        }

        return redirect()->route( 'login' );
    }
}
