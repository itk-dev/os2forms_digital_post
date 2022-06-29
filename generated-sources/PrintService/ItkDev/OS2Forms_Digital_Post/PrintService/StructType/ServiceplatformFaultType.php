<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService\StructType;

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
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ErrorListType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ErrorListType $ErrorList = null;
    /**
     * Constructor method for ServiceplatformFaultType
     * @uses ServiceplatformFaultType::setErrorList()
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ErrorListType $errorList
     */
    public function __construct(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ErrorListType $errorList = null)
    {
        $this
            ->setErrorList($errorList);
    }
    /**
     * Get ErrorList value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ErrorListType|null
     */
    public function getErrorList(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ErrorListType
    {
        return $this->ErrorList;
    }
    /**
     * Set ErrorList value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ErrorListType $errorList
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ServiceplatformFaultType
     */
    public function setErrorList(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ErrorListType $errorList = null): self
    {
        $this->ErrorList = $errorList;
        
        return $this;
    }
}
