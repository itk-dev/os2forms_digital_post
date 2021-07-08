<?php

declare(strict_types=1);

namespace Drupal\os2forms_digital_post\Client\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ForsendelseAfsenderType StructType
 * @subpackage Structs
 */
class ForsendelseAfsenderType extends AbstractStructBase
{
    /**
     * The AfsenderAdresse
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: fjernprint:AfsenderAdresse
     * @var \Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType|null
     */
    protected ?\Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType $AfsenderAdresse = null;
    /**
     * Constructor method for ForsendelseAfsenderType
     * @uses ForsendelseAfsenderType::setAfsenderAdresse()
     * @param \Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType $afsenderAdresse
     */
    public function __construct(?\Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType $afsenderAdresse = null)
    {
        $this
            ->setAfsenderAdresse($afsenderAdresse);
    }
    /**
     * Get AfsenderAdresse value
     * @return \Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType|null
     */
    public function getAfsenderAdresse(): ?\Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType
    {
        return $this->AfsenderAdresse;
    }
    /**
     * Set AfsenderAdresse value
     * @param \Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType $afsenderAdresse
     * @return \Drupal\os2forms_digital_post\Client\StructType\ForsendelseAfsenderType
     */
    public function setAfsenderAdresse(?\Drupal\os2forms_digital_post\Client\StructType\KontaktOplysningType $afsenderAdresse = null): self
    {
        $this->AfsenderAdresse = $afsenderAdresse;
        
        return $this;
    }
}
