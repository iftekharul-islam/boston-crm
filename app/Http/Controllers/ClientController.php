<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Services\ClientService;
use App\Services\CompanyService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use App\Imports\ImportAmc;
use App\Imports\ImportLender;
use Maatwebsite\Excel\Facades\Excel;

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
    public function index(): View|Factory|Application
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
        $page_number = request()->query('page');
        $search_key = request()->query('searchKey') ?? '';
        $company_id = $this->companyService->getAuthUserCompany()->id;

        $clients = $this->clientService->getClients($type, $page_number,$search_key,$company_id);


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
        $merged_data = array_merge($request_data, ["company_id" => $this->companyService->getAuthUserCompany()->id,"created_by" => auth()->user()->id]);
        $client = $this->clientService->saveClientData($merged_data);

        return redirect()
            ->to('/clients/' . $client->id)
            ->with(["success" => 'Client added successfully']);
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
        $client = $this->clientService->updateClientData($request->validated(), $id);

        return redirect()
            ->to('/clients/' . $client->id)
            ->with(['success' => 'Client updated successfully']);
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

    /**
     * @param Request $request
     * @return View|Factory|Application
     */
    public function importClient(Request $request): View|Factory|Application
    {
        if($request->isMethod('post')){
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            str_contains($file_name,'amc') ? $this->importFile(new ImportAmc,$file) : $this->importFile(new ImportLender,$file);
        }
        return view('clients.import-client');
    }

    /**
     * @param $dependency
     * @param $file
     * @return void
     */
    public function importFile($dependency,$file): void
    {
        Excel::import($dependency, $file);
    }

}
