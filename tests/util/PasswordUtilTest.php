<?php

// TODO better way to include
require_once '/opt/lampp/htdocs/bl2items-backend/util/PasswordUtil.php';
require_once '/opt/lampp/htdocs/bl2items-backend/include/config.php';

class PasswordUtilTest extends PHPUnit_Framework_TestCase {

    /**
     * The PasswordUtil under test.
     * @var PasswordUtil
     */
    private $passwordUtil;

    public function __construct() {
        $this->passwordUtil = new PasswordUtil();
    }

    public function testCreateHashAndValidate() {
        $password = "foobar";

        $algorithm = "sha256";
        $iterations = 666;
        $salt = "dini mueter";

        $hashedPassword = $this->passwordUtil->createHash($password, $algorithm, $iterations, $salt);

        $this->validateHashedPassword($password, $hashedPassword, $algorithm, $iterations, $salt);
    }

    public function testCreateHashAndValidateWithDefaultValues() {
        $password = "foobar";

        $hashedPassword = $this->passwordUtil->createHash($password);

        $this->validateHashedPassword($password, $hashedPassword, PBKDF2_HASH_ALGORITHM, PBKDF2_ITERATIONS,
            $hashedPassword->getSalt());
    }

    private function validateHashedPassword($password, $hashedPassword, $expAlgortihm, $expIterations, $expSalt) {
        $this->assertNotNull($hashedPassword);
        $this->assertEquals($expAlgortihm, $hashedPassword->getAlgorithm());
        $this->assertEquals($expIterations, $hashedPassword->getIterations());
        $this->assertEquals($expSalt, $hashedPassword->getSalt());
        $hash = $hashedPassword->getHash();
        $this->assertNotEmpty($hash);

        $this->assertTrue($this->passwordUtil->validatePassword($password, $hashedPassword));
    }
}