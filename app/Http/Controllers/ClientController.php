<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Rules\UniqueEmail;
use App\Rules\UniquePhone;
use App\Imports\ImportAmc;
use Illuminate\Http\Request;
use App\Imports\ImportLender;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Http\Requests\ClientRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Foundation\Application;

class ClientController extends BaseController
{
    protected ClientService $clientService;
    protected CompanyService $companyService;
    protected OrderRepository $repository;

    public function __construct(ClientService $client_service, CompanyService $company_service,OrderRepository $order_repository)
    {
        parent::__construct();
        $this->clientService = $client_service;
        $this->companyService = $company_service;
        $this->repository = $order_repository;
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

        $clients = $this->clientService->getClients($type, $page_number, $search_key, $company_id);


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
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse|array|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "name"                   => "required|unique:clients,name",
            "email"                  => ["required", "array", new UniqueEmail(0)],
            "phone"                  => ["required", "array", new UniquePhone(0)],
            "client_type"            => "required",
            "address"                => "required_if:client_type,lender,both",
            "city"                   => "required_if:client_type,lender,both",
            "state"                  => "required_if:client_type,lender,both",
            "zip"                    => "required_if:client_type,lender,both",
            "processing_fee"         => "required_if:client_type,amc,both",
            "deducts_technology_fee" => "required_if:client_type,amc,both",
            "fee_for_1004uad"        => "required_if:client_type,amc,both",
            "fee_for_1004d"          => "required_if:client_type,amc,both",
            "can_sign"               => "required_if:client_type,amc,both",
            "can_inspect"            => "required_if:client_type,amc,both",
            "com_required"           => "required_if:client_type,amc,both",
            "instruction"            => "nullable",
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return [
                    "error" => true,
                    "message" => $validator->errors()->first()
                ];
            } else {
                return redirect()
                    ->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }
        }
        $request_data = $request->all();
        $merged_data = array_merge($request_data, ["company_id" => $this->companyService->getAuthUserCompany()->id, "created_by" => auth()->user()->id]);
        $client = $this->clientService->saveClientData($merged_data);

        $amcs = $this->repository->getAllClientByType('amc');
        $lenders = $this->repository->getAllClientByType('lender');

        if ($client) {
            if ($request->ajax()) {
                return [
                    "error" => false,
                    "amcs" => $amcs,
                    "lenders" => $lenders,
                    "message" => 'Client added successfully'
                ];
            } else {
                return redirect()
                    ->to('/clients/' . $client->id)
                    ->with(["success" => 'Client added successfully']);
            }
        }
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
        if ($request->isMethod('post')) {
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            str_contains($file_name, 'amc') ? $this->importFile(new ImportAmc, $file) : $this->importFile(new ImportLender, $file);
        }
        return view('clients.import-client');
    }

    /**
     * @param $dependency
     * @param $file
     * @return void
     */
    public function importFile($dependency, $file): void
    {
        Excel::import($dependency, $file);
    }
}
