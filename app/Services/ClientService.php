<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ClientService
{
    /**
     * @var ClientRepository
     */
    protected ClientRepository $clientRepository;

    /**
     * @param ClientRepository $client_repository
     */
    public function __construct(ClientRepository $client_repository)
    {
        $this->clientRepository = $client_repository;
    }

    /**
     * @param string $type
     * @param int $page_number
     * @param string $search_key
     * @param int $company_id
     * @return array
     */
    public function getClients(string $type, int $page_number,string $search_key,int $company_id): array
    {
        return $this->clientRepository->getClientsData(strtolower($type), $page_number,$search_key,$company_id);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function saveClientData(array $data): Model
    {
        return $this->clientRepository->create($data);
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function getClientData(int $id): ?Model
    {
        return $this->clientRepository->getClientDetails($id);
    }


    /**
     * @param array $data
     * @param int $id
     *
     * @return Model
     */
    public function updateClientData(array $data, int $id): Model
    {
        return $this->clientRepository->update($data, $id);
    }

    /**
     * @param int $id
     * @return bool|null
     */
    public function deleteClientData(int $id): ?bool
    {
        return $this->clientRepository->delete($id);
    }
}
