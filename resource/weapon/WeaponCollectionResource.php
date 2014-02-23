<?php

require_once 'vendor/autoload.php';

use Tonic\Response;

/**
 * This class defines an example resource that is wired into the URI /example
 * @uri /weapons
 * @uri /weapons/
 */
// FIXME use doctrine ORM mapper
class WeaponCollectionResource extends AbstractWeaponResource {

    /**
     * Gets a list containing all weapons.
     *
     * @json
     * @method GET
     * @provides application/json
     */
    public function getAll() {
        $link = $this->connectDb();

        $weapons = array();

        // Select queries return a resultset
        if ($result = $link->query("SELECT * FROM weapon")) {
            while ($obj = $result->fetch_object()) {
                $weapons[] = $obj;
            }

            // free result set
            mysqli_free_result($result);
        }

        return json_encode($weapons);
    }

    /**
     * Adds a new weapon
     *
     * @method POST
     * @accepts application/json
     */
    public function add() {
        $weapon = json_decode($this->request->data);

        // TODO proper validation
        if (empty($weapon->name)) {
            return new Response(Response::NOTACCEPTABLE);
        } else {
            $link = $this->connectDb();

            $link->query("INSERT INTO weapon (name, level, rarity, damage, damageMultiplier, accuracy, fireRate, reloadSpeed, magazineSize, elementalType, elementalDmg, elementalChance, manufacturer, weaponType, code) VALUES ('" . $weapon->name . "', '" . $weapon->level . "', '" . $weapon->rarity . "', '" . $weapon->damage . "', '" . $weapon->damageMultiplier . "', '" . $weapon->accuracy . "', '" . $weapon->fireRate . "', '" . $weapon->reloadSpeed . "', '" . $weapon->magazineSize . "', '" . $weapon->elementalType . "', '" . $weapon->elementalDmg . "', '" . $weapon->elementalChance . "', '" . $weapon->manufacturer . "', '" . $weapon->weaponType . "', '" . $weapon->code . "')");

            if (!$link->error) {
                return new Response(Response::CREATED);
            } else {
                echo "error: " . $link->error;
                return new Response(Response::BADREQUEST);
            }
        }
    }

}
