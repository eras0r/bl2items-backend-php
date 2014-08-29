<?php

require_once 'AbstractEntity.php';
require_once 'Manufacturer.php';
require_once 'Weapon.php';
require_once 'Shield.php';

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Abstract superclass for all item entity objects. This class is not extending {@link AbstractEntity} because
 * otherwise the discriminator won't be serialized to JSON.
 * @ORM\Entity
 * @ORM\Table(name="abstract_item", uniqueConstraints={@ORM\UniqueConstraint(name="unique_name", columns={"name"})})
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="itemType", type="string")
 * @ORM\DiscriminatorMap({"weapon" = "Weapon", "shield" = "Shield"})
 * @Serializer\Discriminator(field = "itemType", map = {"weapon": "Weapon", "shield": "Shield"})
 */
abstract class AbstractItem {

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected $id;

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
     * @ORM\ManyToOne(targetEntity="Manufacturer")
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
        foreach ($data as $key => $val) {
            if (property_exists(get_class($this), $key) && $key != "id") {
                $this->$key = $val;
            }
        }
    }

    /**
     * Gets the entity name for this entity. This is useful for the doctrine entity manager which will use the entity name.
     */
    public static function entityName() {
        echo "dini mueter";
        echo get_called_class();
        return get_called_class();
    }

    /**
     * Gets the id.
     * @return int the id
     */
    public function getId() {
        return $this->id;
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
     * Validates the item and returns an array containing validation errors (if any).
     * @return array associative array containing validation errors (if any).
     */
    public function validate() {
        $errors = array();
        if (empty($this->level)) {
            $errors["level"] = "Level is required";
        }
        if (empty($this->name)) {
            $errors["name"] = "Name is required";
        }
        if ($this->manufacturer == null) {
            $errors["manufacturer"] = "Manufacturer is required";
        }
        if ($this->rarity == null) {
            $errors["rarity"] = "Rarity is required";
        }

        return $errors;
    }
}