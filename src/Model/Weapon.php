<?php

namespace Bl2\Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Entity object representing a weapon.
 * @ORM\Entity
 * @ORM\Table(name="weapon")
 */
class Weapon extends AbstractItem {

    /**
     * @ORM\Column(type="decimal")
     * @var double
     **/
    protected $damage;

    /**
     * @ORM\Column(type="integer", options={"default" = 1})
     * @Serializer\SerializedName("damageMultiplier")
     * @var int
     **/
    protected $damageMultiplier = 1;

    /**
     * @ORM\Column(type="decimal")
     * @var double
     **/
    protected $accuracy;

    /**
     * @ORM\Column(type="decimal")
     * @Serializer\SerializedName("fireRate")
     * @var double
     **/
    protected $fireRate;

    /**
     * @ORM\Column(type="decimal")
     * @Serializer\SerializedName("reloadSpeed")
     * @var double
     **/
    protected $reloadSpeed;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\SerializedName("magazineSize")
     * @var int
     **/
    protected $magazineSize;

    /**
     * @ORM\ManyToOne(targetEntity="DamageType")
     * @ORM\JoinColumn(name="damageType_id", nullable=false)
     * @Serializer\SerializedName("damageType")
     * @var DamageType
     */
    protected $damageType;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     * @Serializer\SerializedName("elemDamage")
     * @var double
     **/
    protected $elemDamage;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     * @Serializer\SerializedName("elemChance")
     * @var double
     **/
    protected $elemChance;

    // TODO create entity and map
    protected $type;

    /**
     * Creates a new weapon by initializing is properties by using the values given in the associative array.
     *
     * @param array $data associative array holding the properties for the weapon.
     */
    public function __construct(array $data) {
        parent::__construct($data);
    }

    /**
     * @param float $accuracy
     */
    public function setAccuracy($accuracy) {
        $this->accuracy = $accuracy;
    }

    /**
     * @return float
     */
    public function getAccuracy() {
        return $this->accuracy;
    }

    /**
     * @param float $damage
     */
    public function setDamage($damage) {
        $this->damage = $damage;
    }

    /**
     * @return float
     */
    public function getDamage() {
        return $this->damage;
    }

    /**
     * @param int $damageMultiplier
     */
    public function setDamageMultiplier($damageMultiplier) {
        $this->damageMultiplier = $damageMultiplier;
    }

    /**
     * @return int
     */
    public function getDamageMultiplier() {
        return $this->damageMultiplier;
    }

    /**
     * @param \DamageType $damageType
     */
    public function setDamageType($damageType) {
        $this->damageType = $damageType;
    }

    /**
     * @return \DamageType
     */
    public function getDamageType() {
        return $this->damageType;
    }

    /**
     * @param float $elemChance
     */
    public function setElemChance($elemChance) {
        $this->elemChance = $elemChance;
    }

    /**
     * @return float
     */
    public function getElemChance() {
        return $this->elemChance;
    }

    /**
     * @param float $elemDamage
     */
    public function setElemDamage($elemDamage) {
        $this->elemDamage = $elemDamage;
    }

    /**
     * @return float
     */
    public function getElemDamage() {
        return $this->elemDamage;
    }

    /**
     * @param float $fireRate
     */
    public function setFireRate($fireRate) {
        $this->fireRate = $fireRate;
    }

    /**
     * @return float
     */
    public function getFireRate() {
        return $this->fireRate;
    }

    /**
     * @param int $magazineSize
     */
    public function setMagazineSize($magazineSize) {
        $this->magazineSize = $magazineSize;
    }

    /**
     * @return int
     */
    public function getMagazineSize() {
        return $this->magazineSize;
    }

    /**
     * @param float $reloadSpeed
     */
    public function setReloadSpeed($reloadSpeed) {
        $this->reloadSpeed = $reloadSpeed;
    }

    /**
     * @return float
     */
    public function getReloadSpeed() {
        return $this->reloadSpeed;
    }

    /**
     * @param mixed $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    protected function doValidation() {
        parent::doValidation();

        if (empty($this->damage)) {
            $this->addValidationError("damage", "Damage is required");
        }
        if (empty($this->accuracy)) {
            $this->addValidationError("accuracy", "Accuracy is required");
        }
        if (empty($this->fireRate)) {
            $this->addValidationError("fireRate", "Fire rate is required");
        }
        if (empty($this->reloadSpeed)) {
            $this->addValidationError("reloadSpeed", "Reload speed is required");
        }
        if (empty($this->magazineSize)) {
            $this->addValidationError("magazineSize", "Magazine size is required");
        }
        if (!isset($this->damageType)) {
            $this->addValidationError("damageType", "Damage type is required");
        }

        // validate elemental damage if necessary
        if ($this->damageType->getDamageLabel() != null && !isset($this->elemDamage)) {
            $this->addValidationError("elemDamage", "Elemental damage is required for weapons with damage type '" .
                $this->damageType->getName() . "'");
        }

        // validate elemental chance if necessary
        if ($this->damageType->getChanceLabel() != null && !isset($this->elemChance)) {
            $this->addValidationError("elemChance", "Elemental chance is required for weapons with damage type '"
                . $this->damageType->getName() . "'");
        }
    }
}