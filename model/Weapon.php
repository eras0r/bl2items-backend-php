<?php

require_once 'AbstractEntity.php';
require_once 'Manufacturer.php';

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Entity object representing a weapon.
 * @ORM\Entity
 * @ORM\Table(name="weapon", uniqueConstraints={@ORM\UniqueConstraint(name="unique_name", columns={"name"})})
 */
class Weapon extends AbstractEntity {

    /**
     * @ORM\Column(type="integer")
     * @var string
     **/
    protected $level;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $name;

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
     * @ORM\ManyToOne(targetEntity="Manufacturer", inversedBy="weapons")
     * @ORM\JoinColumn(name="manufacturer_id", nullable=false)
     * @var Manufacturer
     */
    protected $manufacturer;

    /**
     * @ORM\ManyToOne(targetEntity="Rarity")
     * @ORM\JoinColumn(name="rarity_id", nullable=false)
     * @var Rarity
     */
    protected $rarity;

    /**
     * @ORM\Column(type="string")
     * @Serializer\SerializedName("uniqueText")
     * @var string
     **/
    protected $uniqueText;

    /**
     * @ORM\Column(type="text")
     * @Serializer\SerializedName("additionalText")
     * @var string
     **/
    protected $additionalText;

    /**
     * Creates a new manufacturer by initializing is properties by using hte values given in the associative array.
     *
     * @param array $data associative array holding the properties for the manufacturer.
     */
    public function __construct(array $data) {
        parent::__construct($data);
    }

    /**
     * @param string $level
     */
    public function setLevel($level) {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getLevel() {
        return $this->level;
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
     * @param \Manufacturer $manufacturer
     */
    public function setManufacturer($manufacturer) {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return \Manufacturer
     */
    public function getManufacturer() {
        return $this->manufacturer;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
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

    /**
     * @param \Rarity $rarity
     */
    public function setRarity($rarity) {
        $this->rarity = $rarity;
    }

    /**
     * @return \Rarity
     */
    public function getRarity() {
        return $this->rarity;
    }

    /**
     * @param string $additionalText
     */
    public function setAdditionalText($additionalText) {
        $this->additionalText = $additionalText;
    }

    /**
     * @return string
     */
    public function getAdditionalText() {
        return $this->additionalText;
    }

    /**
     * @param string $uniqueText
     */
    public function setUniqueText($uniqueText) {
        $this->uniqueText = $uniqueText;
    }

    /**
     * @return string
     */
    public function getUniqueText() {
        return $this->uniqueText;
    }

    /**
     * Validates the entity and returns an array containing validation errors (if any).
     * @return array associative array containing validation errors (if any).
     */
    public function validate() {
        $errors = array();
        if (empty($this->name)) {
            $errors["name"] = "Name is required";
        }
        if (empty($this->damage)) {
            $errors["damage"] = "Damage is required";
        }
        if (empty($this->accuracy)) {
            $errors["accuracy"] = "Accuracy is required";
        }
        if (empty($this->fireRate)) {
            $errors["fireRate"] = "Fire rate is required";
        }
        if (empty($this->reloadSpeed)) {
            $errors["reloadSpeed"] = "Reload speed is required";
        }
        if (empty($this->magazineSize)) {
            $errors["magazineSize"] = "Magazine size is required";
        }
        if (!isset($this->damageType)) {
            $errors["damageType"] = "Damage type is required";
        }

        // validate elemental damage if necessary
        if ($this->damageType->getDamageLabel() != null && !isset($this->elemDamage)) {
            $errors["elemDamage"] = "Elemental damage is required for weapons with damage type '"
                . $this->damageType->getName() . "'";
        }

        // validate elemental chance if necessary
        if ($this->damageType->getChanceLabel() != null && !isset($this->elemChance)) {
            $errors["elemChance"] = "Elemental chance is required for weapons with damage type '"
                . $this->damageType->getName() . "'";
        }

        // TODO create weaponType entity
//        if (!isset($this->type)) {
//            $errors["type"] = "Type is required";
//        }
        if (!isset($this->manufacturer)) {
            $errors["manufacturer"] = "Manufacturer is required";
        }
        return $errors;
    }
}