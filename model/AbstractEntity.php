<?php
/**
 * Abstract super class for all entities.
 */
abstract class AbstractEntity {

    // constructor used for JSON
    protected function __construct(array $data) {
        foreach ($data as $key => $val) {
            if (property_exists(get_class($this), $key) && $key != "id") {
                echo "key = $key, val = $val<br />";
                $this->$key = $val;
            }
        }
    }

    /*
     * gets the JSON representation of this entity
     * TODO try using http://jmsyst.com/libs/serializer#documentation instead
     * TODO add         "jms/serializer-bundle": "dev-master" to composer.json
     */
    public function getJson() {
        return get_object_vars($this);
    }

}