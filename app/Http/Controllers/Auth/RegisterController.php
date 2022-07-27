<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Events\UserCreatedEvent;
use App\Events\UserMailVerificationEvent;
use App\Helpers\CrmHelper;
use App\Http\Controllers\Controller;
use App\Notifications\NewUserCreateNotification;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Repositories\CompanyRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;

class RegisterController extends Controller {
    use PasswordValidationRules, CrmHelper;

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default, this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;
    protected CompanyRepository $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( CompanyRepository $company_repository ) {
        $this->middleware( 'guest' );
        $this->repository = $company_repository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator( array $data ): \Illuminate\Contracts\Validation\Validator {
        return Validator::make( $data, [
            'name'         => [ 'required', 'string', 'max:255' ],
            'email'        => [ 'required', 'string', 'email', 'max:255', 'unique:users' ],
            'password'     => $this->passwordRules(),
            'company_name' => [ 'required', 'string', 'max:255' ],
        ] );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create( array $data ): User {
        return DB::transaction( function () use ( $data ) {
            $user = User::create( [
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make( $data['password'] ),
            ] );
            if ( $user ) {
                $this->repository->setAndGetCompanyDetails( $user, $data['company_name'] );
                event( new UserCreatedEvent ( $user ) );
                event( new UserMailVerificationEvent( $user ) );
                Notification::route( 'mail', $data['email'] )->notify( new NewUserCreateNotification($data['name']) );
                $user->companies()->where( 'active_company', 1 )->first();
                $this->addActivity($user, "Your account's registration has been successful along with others information.");
                return $user;
            }

            return [];
        } );
    }

    /**
     * Make password 6 digit minimum
     *
     * @return array
     */
    protected function passwordRules(): array {
        return [
            'required',
            'string',
            ( new Password )->length( 6 ),
        ];
    }
}
