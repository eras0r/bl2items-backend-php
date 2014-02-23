<?php

require_once 'vendor/autoload.php';

use Tonic\Response;

/**
 * This class defines an example resource that is wired into the URI /example
 * @uri /weapons/:id
 * @uri /weapons/:id/
 */
// FIXME use doctrine ORM mapper
class WeaponResource extends AbstractWeaponResource {

    /**
     * Gets a single weapon
     *
     * @method GET
     * @provides application/json
     */
    public function display() {
        $link = $this->connectDb();
        $result = $link->query("SELECT * FROM weapon WHERE id = '$this->id'");
        $weapon = $result->fetch_object();
        mysqli_free_result($result);
        return json_encode($weapon);
    }

    /**
     * Updates a single weapon
     *
     * @method PUT
     * @accepts application/json
     * @provides application/json
     */
    public function update() {
        $weapon = json_decode($this->request->data);

        // TODO proper validation
        if (empty($weapon->name) || empty($weapon->country)) {
            return new Response(Response::NOTACCEPTABLE);
        } else {
            $link = $this->connectDb();
            $result = $link->query("UPDATE weapon SET name='$weapon->name', country='$weapon->country' WHERE id = '$this->id'");
            $weapon = $result->fetch_object();
            mysqli_free_result($result);
        }

        return $this->display();
    }

    /**
     * Deletes a single weapon
     *
     * @method DELETE
     */
    public function remove() {
        $link = $this->connectDb();
        $result = $link->query("DELETE FROM weapon WHERE id = '$this->id'");
        mysqli_free_result($result);
        return new Response(Response::NOCONTENT);
    }

}
