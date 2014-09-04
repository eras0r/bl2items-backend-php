<?php

/**
 * Represents a hashed password.
 */
class HashedPassword {
    /**
     * The algorithm being used for the hash
     * @var string
     */
    private $algorithm;

    /**
     * Number of iterations
     * @var integer
     */
    private $iterations;

    /**
     * The salt which will be prepended to the original password to calculate the hashed password.
     * @var string
     */
    private $salt;

    /**
     * The hashed password
     * @var string
     */
    private $hash;

    function __construct($algorithm, $iterations, $salt, $hash) {
        $this->algorithm = $algorithm;
        $this->iterations = $iterations;
        $this->salt = $salt;
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getAlgorithm() {
        return $this->algorithm;
    }

    /**
     * @return string
     */
    public function getHash() {
        return $this->hash;
    }

    /**
     * @return int
     */
    public function getIterations() {
        return $this->iterations;
    }

    /**
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }
}