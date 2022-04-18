<?php

namespace App\Services;

use App\Repositories\ClientRepository;

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
     * @return void
     */
    public function getAllClients() {
        $this->clientRepository->allPagination();
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
     *
     * @return void
     */
    public function showClientData( int $id ) {
        $this->clientRepository->find( $id );
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return void
     */
    public function updateClientData( array $data, int $id ) {
        $this->clientRepository->update( $data, $id );
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
