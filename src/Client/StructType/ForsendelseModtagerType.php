<?php

declare(strict_types=1);

namespace Drupal\os2forms_digital_post\Client\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ForsendelseModtagerType StructType
 * @subpackage Structs
 */
class ForsendelseModtagerType extends AbstractStructBase
{
    /**
     * The AfsendelseModtager
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: dkal:AfsendelseModtager
     * @var \Drupal\os2forms_digital_post\Client\StructType\SlutbrugerIdentitetType|null
     */
    protected ?\Drupal\os2forms_digital_post\Client\StructType\SlutbrugerIdentitetType $AfsendelseModtager = null;
    /**
     * The ModtagerAdresse
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: fjernprint:ModtagerAdresse
     * @var \Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType|null
     */
    protected ?\Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType $ModtagerAdresse = null;
    /**
     * Constructor method for ForsendelseModtagerType
     * @uses ForsendelseModtagerType::setAfsendelseModtager()
     * @uses ForsendelseModtagerType::setModtagerAdresse()
     * @param \Drupal\os2forms_digital_post\Client\StructType\SlutbrugerIdentitetType $afsendelseModtager
     * @param \Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType $modtagerAdresse
     */
    public function __construct(?\Drupal\os2forms_digital_post\Client\StructType\SlutbrugerIdentitetType $afsendelseModtager = null, ?\Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType $modtagerAdresse = null)
    {
        $this
            ->setAfsendelseModtager($afsendelseModtager)
            ->setModtagerAdresse($modtagerAdresse);
    }
    /**
     * Get AfsendelseModtager value
     * @return \Drupal\os2forms_digital_post\Client\StructType\SlutbrugerIdentitetType|null
     */
    public function getAfsendelseModtager(): ?\Drupal\os2forms_digital_post\Client\StructType\SlutbrugerIdentitetType
    {
        return $this->AfsendelseModtager;
    }
    /**
     * Set AfsendelseModtager value
     * @param \Drupal\os2forms_digital_post\Client\StructType\SlutbrugerIdentitetType $afsendelseModtager
     * @return \Drupal\os2forms_digital_post\Client\StructType\ForsendelseModtagerType
     */
    public function setAfsendelseModtager(?\Drupal\os2forms_digital_post\Client\StructType\SlutbrugerIdentitetType $afsendelseModtager = null): self
    {
        $this->AfsendelseModtager = $afsendelseModtager;
        
        return $this;
    }
    /**
     * Get ModtagerAdresse value
     * @return \Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType|null
     */
    public function getModtagerAdresse(): ?\Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType
    {
        return $this->ModtagerAdresse;
    }
    /**
     * Set ModtagerAdresse value
     * @param \Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType $modtagerAdresse
     * @return \Drupal\os2forms_digital_post\Client\StructType\ForsendelseModtagerType
     */
    public function setModtagerAdresse(?\Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType $modtagerAdresse = null): self
    {
        $this->ModtagerAdresse = $modtagerAdresse;
        
        return $this;
    }
}
