<?php
/**
 * Created by PhpStorm.
 * User: eras0r
 * Date: 9/13/14
 * Time: 4:21 PM
 */

namespace Bl2\Util;

use JMS\Serializer\SerializerBuilder;
use Spore\ReST\Data\Base;

/**
 * Spore serializer which uses the JMS Serializer to serialize objects in JSON format.
 * This serializer is able to serialize non public object member by using the JMS serializer's annoutations put on
 * the objects to be serialized.
 * @package Bl2\Util
 */
class JsonSerializer extends Base {

    public static function parse($data) {
        $serializer = SerializerBuilder::create()->build();
        return $serializer->serialize($data, "json");
    }
}