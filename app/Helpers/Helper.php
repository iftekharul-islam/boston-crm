<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class Helper {
    /**
     * Get Custom msg
     *
     * @param bool       $success
     * @param string     $status_code
     * @param string     $message
     * @param array|null $data
     *
     * @return array
     */
    #[ArrayShape( [
        'status_code' => "string",
        'success'     => "bool",
        'message'     => "string",
        'data'        => "array|null",
    ] )] public static function responseMessage(
        bool $success,
        string $status_code,
        string $message = '',
        array $data = null
    ): array {
        return [ 'status_code' => $status_code, 'success' => $success, 'message' => $message, 'data' => $data ];
    }

    /**
     * Format collection model wise.
     *
     * @param $permissions
     *
     * @return Collection
     */
    public static function getPermissionGroupList( $permissions ): Collection {
        $permission_list       = collect();
        $data                  = collect();
        $permission_model_name = explode( '.', $permissions[0]->name )[1];
        foreach ( $permissions as $permission ) {
            $permission_new_model_name = explode( '.', $permission->name )[1];
            if ( $permission_model_name !== $permission_new_model_name ) {
                $permission_list[ $permission_model_name ] = $data;
                $permission_model_name                     = $permission_new_model_name;
                $data                                      = collect();
            }
            $data->push( $permission );
        }
        if ( count( $data ) ) {
            $permission_list[ $permission_model_name ] = $data;
        }

        return $permission_list;
    }
}
