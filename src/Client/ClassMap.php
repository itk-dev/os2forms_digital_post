<?php

declare(strict_types=1);

namespace Drupal\os2forms_digital_post\Client;

/**
 * Class which returns the class map definition
 */
class ClassMap
{
    /**
     * Returns the mapping between the WSDL Structs and generated Structs' classes
     * This array is sent to the \SoapClient when calling the WS
     * @return string[]
     */
    final public static function get(): array
    {
        return [
            'InvocationContextType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\InvocationContextType',
            'AuthorityContextType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\AuthorityContextType',
            'CallContextType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\CallContextType',
            'MeddelelsesFormatObjektType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\MeddelelsesFormatObjektType',
            'DokumentParametreType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\DokumentParametreType',
            'CountryIdentificationCodeType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\CountryIdentificationCodeType',
            'KontaktOplysningType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\KontaktOplysningType',
            'ForsendelseAfsenderType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\ForsendelseAfsenderType',
            'KanalUafhaengigeParametreIType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\KanalUafhaengigeParametreIType',
            'MeddelelseFESDmetadataType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\MeddelelseFESDmetadataType',
            'DigitalPostParametreType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\DigitalPostParametreType',
            'PostParametreType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\PostParametreType',
            'TransaktionsParametreIType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\TransaktionsParametreIType',
            'PrintParametreType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\PrintParametreType',
            'SlutbrugerIdentitetType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\SlutbrugerIdentitetType',
            'ForsendelseModtagerType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\ForsendelseModtagerType',
            'BilagType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\BilagType',
            'BilagSamlingType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\BilagSamlingType',
            'ForsendelseIType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\ForsendelseIType',
            'BrevSPBodyType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\BrevSPBodyType',
            'TilmeldingRequestType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\TilmeldingRequestType',
            'PrintAfsendBrevRequestType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\PrintAfsendBrevRequestType',
            'PrintAfsendBrevResponseType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\PrintAfsendBrevResponseType',
            'PrintSpoergTilmeldingRequestType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\PrintSpoergTilmeldingRequestType',
            'PrintSpoergTilmeldingResponseType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\PrintSpoergTilmeldingResponseType',
            'FejlType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\FejlType',
            'ServiceplatformFaultType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\ServiceplatformFaultType',
            'ErrorListType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\ErrorListType',
            'ErrorType' => '\\Drupal\\os2forms_digital_post\\Client\\StructType\\ErrorType',
        ];
    }
}
