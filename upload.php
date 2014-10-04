<?php

require_once 'vendor/autoload.php';

require_once 'config.php';

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
header("Content-Type: application/json");

// TODO refactor security

// check HMAC hash
$environment = \Slim\Environment::getInstance();
$request = new \Slim\Http\Request($environment);
$hmacCalculator = new \Bl2\Util\HmacHashCalculator($request);
$user = $hmacCalculator->checkHmacHash();

// the user need at least onb of the roles in this array
$requiredRoles = array("admin");

$accessGranted = false;

// check whethe the user has one of the required roles
foreach ($user->getRoles() as $role) {
    if (in_array($role->getRolename(), $requiredRoles)) {
        $accessGranted = true;
        break;
    }
}

if (!$accessGranted) {
    throw new \Bl2\Exception\UnauthorizedException();
}

// id is provided -> existing file will be overwritten
$fileId = null;
if (isset($_REQUEST["id"])) {
    $fileId = $_REQUEST["id"];
}

$storage = new \Bl2\Util\Upload\DatabaseStorage($fileId);
$file = new \Upload\File('file', $storage);

// Optionally you can rename the file on upload
//$new_filename = uniqid();
//$file->setName($new_filename);

// Validate file upload
// MimeType List => http://www.webmaster-toolkit.com/mime-types.shtml
$file->addValidations(array(
    // Ensure file is of type "image/png"
    new \Upload\Validation\Mimetype(array('image/png', 'image/jpeg', 'image/gif')),

    //You can also add multi mimetype validation
    //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

    // Ensure file is no larger than 5M (use "B", "K", M", or "G")
    new \Upload\Validation\Size('5M')
));

// Access data about the file that has been uploaded
$data = array(
    'name' => $file->getNameWithExtension(),
    'extension' => $file->getExtension(),
    'mime' => $file->getMimetype(),
    'size' => $file->getSize(),
    'md5' => $file->getMd5(),
    'dimensions' => $file->getDimensions()
);

// Try to upload file
try {
    // Success!
    $file->upload();
} catch (\Exception $e) {
    // Fail!
    $errors = $file->getErrors();
}