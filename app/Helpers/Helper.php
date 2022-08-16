<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class Helper
{
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
	 #[ArrayShape([
		 'status_code' => "string",
		 'success'     => "bool",
		 'message'     => "string",
		 'data'        => "array|null",
	 ])] public static function responseMessage(
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
	 public static function getPermissionGroupList($permissions): Collection
	 {
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
	 
	 /**
		* @param string $text
		* @param int    $max_char
		* @param string $end
		*
		* @return string
		*/
	 public static function subStrWords(string $text, int $max_char, string $end = '...'): string
	 {
			if ( ! $text ) {
				 return $text;
			}
			if ( strlen( $text ) > $max_char || $text == '' ) {
				 $words  = preg_split( '/\s/', $text );
				 $output = '';
				 $i      = 0;
				 while ( 1 ) {
						$length = strlen( $output ) + strlen( $words[ $i ] );
						if ( $length > $max_char ) {
							 break;
						} else {
							 $output .= " " . $words[ $i ];
							 ++ $i;
						}
				 }
				 $output .= $end;
				 
				 return $output;
			}
			
			return $text;
	 }
	 
	 /**
		* @param object $clients
		*
		* @return array
		*/
	 public static function getClientsGroupBy(object $clients): array
	 {
			$amc_clients    = collect();
			$lender_clients = collect();
			$both_client = collect();
			foreach ( $clients as $client ) {
				 if ($client->client_type === 'amc') {
					$amc_clients[] = $client;
				 } else if($client->client_type === 'lender') {
					$lender_clients[] = $client;
				 } else if($client->client_type === 'both'){
					$both_client[] = $client;
				 }
			}

			if ($both_client->count() > 0) {
				$amc_clients = $amc_clients->merge($both_client);
				$lender_clients = $lender_clients->merge($both_client);
			}
			
			return [ $amc_clients, $lender_clients ];
	 }


}
