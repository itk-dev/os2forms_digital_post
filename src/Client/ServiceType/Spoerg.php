<?php

declare(strict_types=1);

namespace Drupal\os2forms_digital_post\Client\ServiceType;

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
     * @param \Drupal\os2forms_digital_post\Client\StructType\PrintSpoergTilmeldingRequestType $request
     * @return \Drupal\os2forms_digital_post\Client\StructType\PrintSpoergTilmeldingResponseType|bool
     */
    public function spoergTilmelding(\Drupal\os2forms_digital_post\Client\StructType\PrintSpoergTilmeldingRequestType $request)
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
     * @return \Drupal\os2forms_digital_post\Client\StructType\PrintSpoergTilmeldingResponseType
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
