<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Services\ClientService;
use App\Services\CompanyService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use PHPUnit\Exception;

class ClientController extends BaseController
{
    protected ClientService $clientService;
    protected CompanyService $companyService;

    public function __construct(ClientService $client_service, CompanyService $company_service)
    {
        parent::__construct();
        $this->clientService = $client_service;
        $this->companyService = $company_service;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('clients.index');
    }

    /**
     * @param $type
     *
     * @return JsonResponse
     */
    public function getClientsByType($type): JsonResponse
    {
        $pageNumber = request()->query('page');
        $searchKey = request()->query('searchKey') ?? '';

        $clients = $this->clientService->getClients($type, $pageNumber,$searchKey);


        return response()->json([
            'data' => $clients,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('clients.create');
    }

    /**
     * @param ClientRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ClientRequest $request): RedirectResponse
    {
        $request_data = $request->validated();
        $merged_data = array_merge($request_data, ["company_id" => $this->companyService->getAuthUserCompany()->id]);
        $this->clientService->saveClientData($merged_data);

        Session::flash('success', 'Client added successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return View
     */
    public function show(int $id): View
    {
        $client = $this->clientService->getClientData($id);

        return view('clients.show', compact('client'));
    }

    public function edit(int $id)
    {
        $client = $this->clientService->getClientData($id);

        return view('clients.edit', compact('client'));
    }

    /**
     * @param ClientRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(ClientRequest $request, int $id): RedirectResponse
    {
        $response = $this->clientService->updateClientData($request->validated(), $id);
        if ($response) {
            return redirect()->back()->with(['success' => 'Client updated successfully']);
        }

        return redirect()->back()->with(['error' => 'Something went wrong']);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->clientService->deleteClientData($id);

        return response()->json([
            'success' => true,
        ]);
    }
}
