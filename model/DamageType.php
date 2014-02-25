<?php

require_once 'AbstractEntity.php';

/**
 * @Entity @Table(name="damage_type", uniqueConstraints={@UniqueConstraint(name="unique_name", columns={"name"}), @UniqueConstraint(name="unique_sortOrder", columns={"sortOrder"})})
 **/
class DamageType extends AbstractEntity {

    /**
     * @Column(type="string")
     * @var string
     **/
    protected $name;

    /**
     * @Column(type="integer")
     * @var int
     **/
    protected $sortOrder;

    /**
     * @Column(type="string", length=7)
     * @var string
     **/
    protected $color;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     **/
    protected $damageLabel;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     **/
    protected $chanceLabel;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     **/
    protected $additionalText;

    /**
     * Creates a new damage type by initializing is properties by using hte values given in the associative array.
     *
     * @param array $data associative array holding the properties for the damage type.
     */
    public function __construct(array $data) {
        parent::__construct($data);
    }

    /**
     * Gets the name.
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param string $name the name to be set.
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Gets the sort order
     * @return int the sort order
     */
    public function getSortOrder() {
        return $this->sortOrder;
    }

    /**
     * Sets the sort order.
     *
     * @param int $sortOrder the sort order to be set.
     */
    public function setSortOrder($sortOrder) {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @return string
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color) {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getDamageLabel() {
        return $this->damageLabel;
    }

    /**
     * @param string $damageLabel
     */
    public function setDamageLabel($damageLabel) {
        $this->damageLabel = $damageLabel;
    }

    /**
     * @return string
     */
    public function getChanceLabel() {
        return $this->chanceLabel;
    }

    /**
     * @param string $chanceLabel
     */
    public function setChanceLabel($chanceLabel) {
        $this->chanceLabel = $chanceLabel;
    }

    /**
     * @return string
     */
    public function getAdditionalText() {
        return $this->additionalText;
    }

    /**
     * @param string $additionalText
     */
    public function setAdditionalText($additionalText) {
        $this->additionalText = $additionalText;
    }

}

?>
