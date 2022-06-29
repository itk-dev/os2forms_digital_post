<?php

declare(strict_types=1);

namespace Drupal\os2forms_digital_post\Client\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ServiceplatformFaultType StructType
 * @subpackage Structs
 */
class ServiceplatformFaultType extends AbstractStructBase
{
    /**
     * The ErrorList
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var \Drupal\os2forms_digital_post\Client\StructType\ErrorListType|null
     */
    protected ?\Drupal\os2forms_digital_post\Client\StructType\ErrorListType $ErrorList = null;
    /**
     * Constructor method for ServiceplatformFaultType
     * @uses ServiceplatformFaultType::setErrorList()
     * @param \Drupal\os2forms_digital_post\Client\StructType\ErrorListType $errorList
     */
    public function __construct(?\Drupal\os2forms_digital_post\Client\StructType\ErrorListType $errorList = null)
    {
        $this
            ->setErrorList($errorList);
    }
    /**
     * Get ErrorList value
     * @return \Drupal\os2forms_digital_post\Client\StructType\ErrorListType|null
     */
    public function getErrorList(): ?\Drupal\os2forms_digital_post\Client\StructType\ErrorListType
    {
        return $this->ErrorList;
    }
    /**
     * Set ErrorList value
     * @param \Drupal\os2forms_digital_post\Client\StructType\ErrorListType $errorList
     * @return \Drupal\os2forms_digital_post\Client\StructType\ServiceplatformFaultType
     */
    public function setErrorList(?\Drupal\os2forms_digital_post\Client\StructType\ErrorListType $errorList = null): self
    {
        $this->ErrorList = $errorList;
        
        return $this;
    }
}
