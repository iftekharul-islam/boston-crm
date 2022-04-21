<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ClientService {
    /**
     * @var ClientRepository
     */
    protected ClientRepository $clientRepository;

    /**
     * @param ClientRepository $client_repository
     */
    public function __construct( ClientRepository $client_repository ) {
        $this->clientRepository = $client_repository;
    }

    /**
     * @param string $type
     * @return array
     */
    public function getClients(string $type,int $pageNumber): array
    {
        return $this->clientRepository->getClientsData(strtolower($type),$pageNumber);
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function saveClientData( array $data ) {
        $this->clientRepository->create( $data );
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function getClientData( int $id ): ?Model
    {
        return $this->clientRepository->find( $id );
    }


    /**
     * @param array $data
     * @param int   $id
     *
     * @return Model
     */
    public function updateClientData( array $data, int $id ) {
        return $this->clientRepository->update( $data, $id );
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function deleteClientData( int $id ) {
        $this->clientRepository->delete( $id );
    }
}
