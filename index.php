<?php

require_once 'vendor/autoload.php';

require_once 'config.php';

use Bl2\Exception\EntityObjectValidationException;
use Bl2\Exception\NotFoundException;
use Bl2\Exception\UnauthorizedException;
use Bl2\Exception\UniqueKeyConstraintException;
use Spore\ReST\Model\Status;
use Spore\Spore;

// TODO introduce setupHeaders(boolean useCors) method
// CORS hack (UI can be on different domain than API)
// e.g. 	API: 	http://localhost/
// 	 		UI:		http://localhost:9000
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Max-Age: 86400");
header('Access-Control-Request-Method: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With, X-MICRO-TIME, X-SESSION-TOKEN, X-HMAC-HASH, X-URL");

$sporeConfig = array(
    "include-examples" => false,
    "debug" => false, // debug false, otherwise exception handling won't work properly
    "serializers" => array(
        "application/json" => '\Bl2\Util\JsonSerializer'
    )
);

$app = new Spore($sporeConfig);

// scan recursively for services
// TODO find a better way than Foo for the directory :-)
$app->addServicesDirectory("src/Service/Rest/", 'Bl2\Service\Rest');

// override error handler
$app->error(function (Exception $e) use ($app) {
    // handle not found exception
    if ($e instanceof NotFoundException) {
        $app->halt(Status::NOT_FOUND, $e->getMessage());
    } else if ($e instanceof UnauthorizedException) {
        // TODO give a better hint than just the "Unauthorized" text
        $app->halt(Status::UNAUTHORIZED, "Unauthorized");
    } else if ($e instanceof EntityObjectValidationException) {
        // TODO give a better hint than just the "Unauthorized" text
        $app->halt(Status::UNPROCESSABLE_ENTITY, json_encode($e->getValidationErrors()));
    } else if ($e instanceof UniqueKeyConstraintException) {
        // TODO give a better hint than just the "Unauthorized" text
        $app->halt(Status::UNPROCESSABLE_ENTITY, json_encode($e->getConstraintViolations()));
    }

    // delegate to default spore error handler
    $app->errorHandler($e);
});

$app->run();
