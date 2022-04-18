<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\TestService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use PHPUnit\Exception;

class ClientController extends Controller {
    protected $clientService;
    protected $companyService;

    public function __construct( ClientService $client_service,CompanyService $company_service ) {
        $this->clientService = $client_service;
        $this->companyService = $company_service;
    }

    /**
     * @return Application|View|Factory
     */
    public function index() {
        $clients = $this->clientService->getAllClients();

        return view( 'clients.index', compact( 'clients' ) );
    }

    /**
     * @return View
     */
    public function create(): View {
        return view( 'clients.create' );
    }

    /**
     * @param ClientRequest $request
     *
     * @return RedirectResponse
     */
    public function store( ClientRequest $request ): RedirectResponse {
        $request_data = $request->validated();
        $merged_data = array_push($request_data,$this->companyService->getAuthUserCompany());
        $response = $this->clientService->saveClientData( $merged_data );

        return redirect()->back()->with( [ 'success' => 'Client added successfully' ] );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return View
     */
    public function show( int $id ): View {
        $client = $this->clientService->showClientData( $id );

        return view( 'client.show', compact( 'client' ) );
    }

    /**
     * @param ClientRequest $request
     * @param int           $id
     *
     * @return RedirectResponse
     */
    public function update( ClientRequest $request, int $id ): RedirectResponse {
        $response = $this->clientService->updateClientData( $request->validated(), $id );
        if ( $response ) {
            return redirect()->back()->with( [ 'success' => 'Client updated successfully' ] );
        }

        return redirect()->back()->with( [ 'error' => 'Something went wrong' ] );
    }

    /**
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy( int $id ): RedirectResponse {
        $response = $this->clientService->deleteClientData( $id );
        if ( $response ) {
            return redirect()->back()->with( [ 'success' => 'Client deleted successfully' ] );
        }

        return redirect()->back()->with( [ 'error' => 'Something went wrong' ] );
    }
}
