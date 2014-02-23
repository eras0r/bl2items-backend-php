<?php
/**
 * Abstract super class for all entities.
 */
abstract class AbstractEntity {

    // constructor used for JSON
    protected function __construct(array $data) {
        foreach ($data as $key => $val) {
            if (property_exists(get_class($this), $key) && $key != "id") {
                $this->$key = $val;
            }
        }
    }

    /*
     * Gets the JSON representation of this entity
     * TODO try using http://jmsyst.com/libs/serializer#documentation instead
     * TODO add         "jms/serializer-bundle": "dev-master" to composer.json
     */
    public function getJson() {
        return get_object_vars($this);
    }

    /**
     * Gets the entity name for this entity. This is useful for the doctrine entity manager which will use the entity name.
     */
    public static function getEntityName() {
        return get_called_class();
    }


}