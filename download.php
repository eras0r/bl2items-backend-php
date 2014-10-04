<?php

require_once 'vendor/autoload.php';

require_once 'config.php';

// TODO introduce setupHeaders(boolean useCors) method
// CORS hack (UI can be on different domain than API)
// e.g. 	API: 	http://localhost/
// 	 		UI:		http://localhost:9000
//header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Credentials: true');
//header("Access-Control-Max-Age: 86400");
//header('Access-Control-Request-Method: *');
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
//header("Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With, X-MICRO-TIME, X-SESSION-TOKEN, X-HMAC-HASH, X-URL");

$entityManager = \Bl2\Util\EntityManagerFactory::getEntityManager();

$file = $entityManager->find(\Bl2\Model\File::entityName(), $_REQUEST["id"]);

// send file headers (file download)
//header('Content-Description: File Transfer');
//header('Content-Type: application/octet-stream');
//header('Content-Disposition: attachment; filename='.basename($file->gteName()));
//header('Content-Transfer-Encoding: binary');
//header('Expires: 0');
//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//header('Pragma: public');
//header('Content-Length: ' . filesize($file->getSize()));

header('Content-type: ' . $file->getMediatype());

$data = stream_get_contents($file->getData());

echo $data;
