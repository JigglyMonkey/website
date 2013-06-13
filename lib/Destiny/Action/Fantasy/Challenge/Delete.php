<?php

namespace Destiny\Action\Fantasy\Challenge;

use Destiny\Service\Fantasy\Db\Challenge;
use Destiny\Utils\Http;
use Destiny\Mimetype;
use Destiny\Session;
use Destiny\AppException;

class Delete {

	public function execute(array $params) {
		if (! isset ( $params ['teamId'] ) || empty ( $params ['teamId'] )) {
			throw new AppException ( 'teamId required.' );
		}
		if (intval ( $params ['teamId'] ) == intval ( Session::get ( 'teamId' ) )) {
			throw new AppException ( 'Play with yourself?' );
		}
		$response = array (
				'success' => true,
				'data' => array (),
				'message' => '' 
		);
		$response ['response'] = Challenge::getInstance ()->deleteChallenge ( intval ( Session::get ( 'teamId' ) ), intval ( $params ['teamId'] ) );
		$response ['message'] = ($response ['response']) ? 'Deleted' : 'Failed!';
		Http::header ( Http::HEADER_CONTENTTYPE, Mimetype::JSON );
		Http::sendString ( json_encode ( $response ) );
	}

}