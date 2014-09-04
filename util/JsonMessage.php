<?php

/**
 * Represents a simple message which can be transmitted to the client in JSON format.
 */
class JsonMessage implements JsonSerializable {

    private $message;

    function __construct($message) {
        $this->message = $message;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize() {
        return [
            'message' => $this->message
        ];
    }
}