<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanTypeCreateRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Repositories\LoanTypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoanTypeController extends BaseController
{
    protected LoanTypeRepository $repository;

    public function __construct(LoanTypeRepository $appraisal_type_repository)
    {
        parent::__construct();
        $this->repository = $appraisal_type_repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $company_id = auth()->user()->companies()->first()->id;
        $loan_types = $this->repository->allLoanTypes($company_id);

        return view('loan-type.index', compact('loan_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('loan-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LoanTypeCreateRequest $request
     *
     * @return RedirectResponse
     */
    public function store(LoanTypeCreateRequest $request): RedirectResponse
    {
        $loan_type_data = [
            'company_id' => auth()->user()->companies()->first()->id,
            'name' => $request->name,
            'is_fha' => $request->is_fha
        ];
        $this->repository->create($loan_type_data);

        return redirect()->route('loan-types.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|View
     */
    public function edit(int $id): View|Factory|Application
    {
        $loan_type = $this->repository->find($id);

        return view('loan-type.edit', compact('loan_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LoanTypeCreateRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|unique:loan_types,name,'. $id,
        ]);

        $loan_type_data = [
            'name' => $request->name,
            'is_fha' => $request->is_fha
        ];
        $this->repository->update(attributes: $loan_type_data, id: $id);

        return redirect()->route('loan-types.index');
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
        return response()->json(['success' => $this->repository->delete($id)]);
    }
}
