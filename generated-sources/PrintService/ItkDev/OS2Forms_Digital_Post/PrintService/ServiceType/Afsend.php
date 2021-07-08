<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService\ServiceType;

use SoapFault;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Afsend ServiceType
 * @subpackage Services
 */
class Afsend extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named afsendBrev
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintAfsendBrevRequestType $request
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintAfsendBrevResponseType|bool
     */
    public function afsendBrev(\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintAfsendBrevRequestType $request)
    {
        try {
            $this->setResult($resultAfsendBrev = $this->getSoapClient()->__soapCall('afsendBrev', [
                $request,
            ], [], [], $this->outputHeaders));
        
            return $resultAfsendBrev;
        } catch (SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
        
            return false;
        }
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintAfsendBrevResponseType
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
