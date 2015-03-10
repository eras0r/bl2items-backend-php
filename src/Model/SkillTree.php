<?php

namespace Bl2\Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Entity object representing a skill tree.
 * @ORM\Entity
 * @ORM\Table(name="skill_tree", uniqueConstraints={@ORM\UniqueConstraint(name="unique_skill_tree",
 * columns={"character_id", "color"})})
 **/
class SkillTree extends AbstractEntity {

    /**
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="skillTrees", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id", nullable=false)
     * @Serializer\Exclude
     * @var Character
     **/
    protected $character;

    /**
     * @ORM\Column(type="integer")
     * @var int
     **/
    protected $order;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $title;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $color;

    /**
     * @ORM\Column(type="string")
     * @Serializer\SerializedName("borderColor")
     * @var string
     **/
    protected $borderColor;

    /**
     * @ORM\OneToMany(targetEntity="SkillTier", mappedBy="skillTree")
     * @ORM\OrderBy({"order" = "ASC"})
     * @Serializer\SerializedName("skillTiers")
     **/
    protected $skillTiers;

    /**
     * Creates a new skill tree by initializing is properties by using the values given in the associative array.
     *
     * @param array $data associative array holding the properties for the skill tree.
     */
    public function __construct(array $data) {
        parent::__construct($data);
    }

    /**
     * @param int $order
     */
    public function setOrder($order) {
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * @param string $borderColor
     */
    public function setBorderColor($borderColor) {
        $this->borderColor = $borderColor;
    }

    /**
     * @return string
     */
    public function getBorderColor() {
        return $this->borderColor;
    }

    /**
     * @param \Bl2\Model\Character $character
     */
    public function setCharacter($character) {
        $this->character = $character;
    }

    /**
     * @return \Bl2\Model\Character
     */
    public function getCharacter() {
        return $this->character;
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
    public function getColor() {
        return $this->color;
    }

    /**
     * @param mixed $skillTiers
     */
    public function setSkillTiers($skillTiers) {
        $this->skillTiers = $skillTiers;
    }

    /**
     * @return mixed
     */
    public function getSkillTiers() {
        return $this->skillTiers;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    protected function doValidation() {
        parent::doValidation(); // TODO: Change the autogenerated stub
    }
}