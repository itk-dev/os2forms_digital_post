<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService\ServiceType;

use SoapFault;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Spoerg ServiceType
 * @subpackage Services
 */
class Spoerg extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named spoergTilmelding
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintSpoergTilmeldingRequestType $request
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintSpoergTilmeldingResponseType|bool
     */
    public function spoergTilmelding(\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintSpoergTilmeldingRequestType $request)
    {
        try {
            $this->setResult($resultSpoergTilmelding = $this->getSoapClient()->__soapCall('spoergTilmelding', [
                $request,
            ], [], [], $this->outputHeaders));
        
            return $resultSpoergTilmelding;
        } catch (SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
        
            return false;
        }
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintSpoergTilmeldingResponseType
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
