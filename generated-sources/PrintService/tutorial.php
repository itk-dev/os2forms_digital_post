<?php
/**
 * This file aims to show you how to use this generated package.
 * In addition, the goal is to show which methods are available and the first needed parameter(s)
 * You have to use an associative array such as:
 * - the key must be a constant beginning with WSDL_ from AbstractSoapClientBase class (each generated ServiceType class extends this class)
 * - the value must be the corresponding key value (each option matches a {@link http://www.php.net/manual/en/soapclient.soapclient.php} option)
 * $options = [
 * WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_URL => '../resources/contracts/PrintService/wsdl/context/PrintService.wsdl',
 * WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_TRACE => true,
 * WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_LOGIN => 'you_secret_login',
 * WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_PASSWORD => 'you_secret_password',
 * ];
 * etc...
 * ################################################################################
 * Don't forget to add wsdltophp/packagebase:~5.0 to your main composer.json.
 * ################################################################################
 */
/**
 * Minimal options
 */
$options = [
    WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_URL => '../resources/contracts/PrintService/wsdl/context/PrintService.wsdl',
    WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_CLASSMAP => \ItkDev\OS2Forms_Digital_Post\PrintService\ClassMap::get(),
];
/**
 * Samples for Afsend ServiceType
 */
$afsend = new \ItkDev\OS2Forms_Digital_Post\PrintService\ServiceType\Afsend($options);
/**
 * Sample call for afsendBrev operation/method
 */
if ($afsend->afsendBrev(new \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintAfsendBrevRequestType()) !== false) {
    print_r($afsend->getResult());
} else {
    print_r($afsend->getLastError());
}
/**
 * Samples for Spoerg ServiceType
 */
$spoerg = new \ItkDev\OS2Forms_Digital_Post\PrintService\ServiceType\Spoerg($options);
/**
 * Sample call for spoergTilmelding operation/method
 */
if ($spoerg->spoergTilmelding(new \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintSpoergTilmeldingRequestType()) !== false) {
    print_r($spoerg->getResult());
} else {
    print_r($spoerg->getLastError());
}
