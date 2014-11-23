<?php

namespace Bl2\Service\Rest;

use Bl2\Model\DamageType;
use Bl2\Model\Manufacturer;
use Bl2\Model\Rarity;
use Bl2\Model\Weapon;
use Bl2\Service\AbstractRestService;
use Spore\ReST\Model\Request;
use Spore\ReST\Model\Response;

/**
 * REST Service providing operations on the {@link Weapon} entity.
 * @package Bl2\Service\Rest
 */
class WeaponService extends AbstractRestService {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Gets all weapons.
     * @url /weapons/
     * @verbs GET
     *
     * @param Request $request
     *
     * @return array
     */
    public function getAll(Request $request) {
        return parent::getAll($request);
    }

    /**
     * Gets the weapon with the given id.
     * @url /weapons/:id/
     * @verbs GET
     *
     * @param Request $request the HTTP request
     *
     * @return Weapon
     */
    public function get(Request $request) {
        return parent::load($request, $request->params['id']);
    }

    /**
     * Creates a new weapon.
     * @url /weapons/
     * @verbs POST
     * @auth admin
     *
     * @param Request $request the HTTP request.
     * @param Response $response the HTTP response.
     *
     * @return Weapon the created weapon
     */
    public function add(Request $request, Response $response) {
        // cast stdClass to array
        $properties = (array)$request->data;

        $weapon = new Weapon($properties);

        // load referenced entity instances
        $weapon->setRarity($this->getEntityManager()->find(Rarity::entityName(), $properties["rarity"]->id));
        $weapon->setManufacturer($this->getEntityManager()->find(Manufacturer::entityName(),
            $properties["manufacturer"]->id));
        $weapon->setDamageType($this->getEntityManager()->find(DamageType::entityName(),
            $properties["damageType"]->id));

        return $this->create($request, $response, $weapon);
    }

    /**
     * Updates the weapon with the given id
     * @url /weapons/:id/
     * @verbs PUT
     * @auth admin
     *
     * @param Request $request the HTTP request
     *
     * @return Weapon the updated weapon
     */
    public function update(Request $request) {
        $properties = (array)$request->data;

        $weapon = new Weapon($properties);

        // load referenced entity instances
        $weapon->setRarity($this->getEntityManager()->find(Rarity::entityName(), $properties["rarity"]->id));
        $weapon->setManufacturer($this->getEntityManager()->find(Manufacturer::entityName(),
            $properties["manufacturer"]->id));
        $weapon->setDamageType($this->getEntityManager()->find(DamageType::entityName(),
            $properties["damageType"]->id));

        return $this->save($weapon);
    }

    /**
     * Removes the weapon with the given id.
     * @url /weapons/:id/
     * @verbs DELETE
     * @auth admin
     *
     * @param Request $request the HTTP request
     * @param Response $response the HTTP response
     *
     * @return string
     */
    public function remove(Request $request, Response $response) {
        return parent::remove($request, $response, $request->params['id']);
    }

    /**
     * HTTP OPTIONS request used for CORS.
     * @url /weapons(/:id)/
     * @verbs OPTIONS
     *
     * @param Request $request the HTTP request
     */
    public function options(Request $request) {
        parent::options($request);
    }

    /**
     * Gets the name of the entity on which this service is based.
     * @return string the name of the entity on which this service is based.
     */
    protected function getEntityName() {
        return Weapon::entityName();
    }
}
