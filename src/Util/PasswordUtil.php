<?php

namespace Bl2\Util;

    /*
     * Password Hashing With PBKDF2 (http://crackstation.net/hashing-security.htm).
     * Copyright (c) 2013, Taylor Hornby
     * All rights reserved.
     *
     * Redistribution and use in source and binary forms, with or without
     * modification, are permitted provided that the following conditions are met:
     *
     * 1. Redistributions of source code must retain the above copyright notice,
     * this list of conditions and the following disclaimer.
     *
     * 2. Redistributions in binary form must reproduce the above copyright notice,
     * this list of conditions and the following disclaimer in the documentation
     * and/or other materials provided with the distribution.
     *
     * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
     * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
     * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
     * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
     * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
     * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
     * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
     * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
     * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
     * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
     * POSSIBILITY OF SUCH DAMAGE.
     */

/**
 * Utility class responsible for creating hashed password which then can be stored in the database.
 */
class PasswordUtil {

    /**
     * Creates a random salt.
     * @return string the randomly created salt.
     */
    private function createSalt() {
        return base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));
    }

    /**
     * Creates a hashed password for the given password.
     *
     * @param $password The password to be hashed
     * @param string $algorithm Name of selected hashing algorithm (i.e. md5, sha256, haval160,4, etc..) See hash_algos() for a list of supported algorithms.
     * @param int $iterations The number of internal iterations to perform for the derivation.
     * @param string $salt The salt to use for the derivation. This value should be generated randomly.
     *
     * @return HashedPassword the hashed password
     */
    public function createHash($password, $algorithm = null, $iterations = null, $salt = null) {

        // init optional argument with default values
        if ($algorithm == null) {
            $algorithm = PBKDF2_HASH_ALGORITHM;
        }
        if ($iterations == null) {
            $iterations = PBKDF2_ITERATIONS;
        }
        if ($salt == null) {
            $salt = $this->createSalt();
        }

        $hash = base64_encode($this->pbkdf2($algorithm, $password, $salt, $iterations, PBKDF2_HASH_BYTE_SIZE, true));

        return new HashedPassword($algorithm, $iterations, $salt, $hash);
    }

    /**
     * Validates if the hash of the given password matched the hashed password.
     *
     * @param $password the password to be checked.
     * @param $hashedPassword the hashed password to be checked against.
     *
     * @return bool true if the password's hash matches the given hashed password
     */
    public function validatePassword($password, $hashedPassword) {
        $pbkdf2 = base64_decode($hashedPassword->getHash());
        return $this->slowEquals($pbkdf2,
            $this->pbkdf2($hashedPassword->getAlgorithm(), $password, $hashedPassword->getSalt(), $hashedPassword->getIterations(), strlen($pbkdf2), true)
        );
    }

    /**
     * Compares two strings $a and $b in length-constant time.
     *
     * @param string $a the first string to be compared
     * @param string $b the second string to be compared
     *
     * @return bool true if the two given strings are equal, false otherwise.
     */
    private function slowEquals($a, $b) {
        $diff = strlen($a) ^ strlen($b);
        for ($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $diff === 0;
    }

    /*
     * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
     * $algorithm - The hash algorithm to use. Recommended: SHA256
     * $password - The password.
     * $salt - A salt that is unique to the password.
     * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
     * $key_length - The length of the derived key in bytes.
     * $raw_output - If true, the key is returned in raw binary format. Hex encoded otherwise.
     * Returns: A $key_length-byte key derived from the password and salt.
     *
     * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
     *
     * This implementation of PBKDF2 was originally created by https://defuse.ca
     * With improvements by http://www.variations-of-shadow.com
     */
    private function pbkdf2($algorithm, $password, $salt, $count, $keyLength, $rawOutput = false) {
        $algorithm = strtolower($algorithm);
        if (!in_array($algorithm, hash_algos(), true)) {
            trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
        }

        if ($count <= 0 || $keyLength <= 0) {
            trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);
        }

        if (function_exists("hash_pbkdf2")) {
            // The output length is in NIBBLES (4-bits) if $raw_output is false!
            if (!$rawOutput) {
                $keyLength = $keyLength * 2;
            }
            return hash_pbkdf2($algorithm, $password, $salt, $count, $keyLength, $rawOutput);
        }

        $hashLength = strlen(hash($algorithm, "", true));
        $blockCount = ceil($keyLength / $hashLength);

        $output = "";
        for ($i = 1; $i <= $blockCount; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt . pack("N", $i);
            // first iteration
            $last = $xorSum = hash_hmac($algorithm, $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < $count; $j++) {
                $xorSum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorSum;
        }

        if ($rawOutput) {
            return substr($output, 0, $keyLength);
        } else {
            return bin2hex(substr($output, 0, $keyLength));
        }
    }
}