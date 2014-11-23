<?php

namespace Bl2\Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Abstract superclass for all item entity objects. This class is not extending {@link AbstractEntity} because
 * otherwise the discriminator won't be serialized to JSON.
 * @ORM\Entity
 * @ORM\Table(name="abstract_item", uniqueConstraints={@ORM\UniqueConstraint(name="unique_name", columns={"name"})})
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="itemType", type="string")
 * @ORM\DiscriminatorMap({"weapon" = "Bl2\Model\Weapon", "shield" = "Bl2\Model\Shield"})
 * @Serializer\Discriminator(field = "itemtype", map = {"weapon": "Bl2\Model\Weapon", "shield": "Bl2\Model\Shield"})
 */
//abstract class AbstractItem  {
abstract class AbstractItem extends AbstractEntity {

    /**
     * @ORM\Column(type="integer")
     * @var int
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
     * @ORM\Column(type="text")
     * @Serializer\SerializedName("string")
     * @var string
     **/
    protected $gibbedCode;

    /**
     * Create a new entity object by using the given array to initialize the new objects properties.
     *
     * @param array $data array holding the new entity objects property (key = property name, value = property value)
     */
    public function __construct(array $data = array()) {
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
     * @param string $gibbedCode
     */
    public function setGibbedCode($gibbedCode) {
        $this->gibbedCode = $gibbedCode;
    }

    /**
     * @return string
     */
    public function getGibbedCode() {
        return $this->gibbedCode;
    }

    protected function doValidation() {
        parent::doValidation();

        if (empty($this->level)) {
            $this->addValidationError("level", "Level is required");
        }
        if (empty($this->name)) {
            $this->addValidationError("name", "Name is required");
        }
        if ($this->manufacturer == null) {
            $this->addValidationError("manufacturer", "Manufacturer is required");
        }
        if ($this->rarity == null) {
            $this->addValidationError("rarity", "Rarity is required");
        }
        if ($this->gibbedCode == null) {
            $this->addValidationError("gibbedCode", "Gibbed Code is required");
        }
    }
}