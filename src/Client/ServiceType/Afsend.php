<?php

declare(strict_types=1);

namespace Drupal\os2forms_digital_post\Client\ServiceType;

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
     * @param \Drupal\os2forms_digital_post\Client\StructType\PrintAfsendBrevRequestType $request
     * @return \Drupal\os2forms_digital_post\Client\StructType\PrintAfsendBrevResponseType|bool
     */
    public function afsendBrev(\Drupal\os2forms_digital_post\Client\StructType\PrintAfsendBrevRequestType $request)
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
     * @return \Drupal\os2forms_digital_post\Client\StructType\PrintAfsendBrevResponseType
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
