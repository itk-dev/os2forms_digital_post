<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService;

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
            'InvocationContextType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\InvocationContextType',
            'AuthorityContextType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\AuthorityContextType',
            'CallContextType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\CallContextType',
            'MeddelelsesFormatObjektType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\MeddelelsesFormatObjektType',
            'DokumentParametreType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\DokumentParametreType',
            'CountryIdentificationCodeType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\CountryIdentificationCodeType',
            'KontaktOplysningType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\KontaktOplysningType',
            'ForsendelseAfsenderType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\ForsendelseAfsenderType',
            'KanalUafhaengigeParametreIType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\KanalUafhaengigeParametreIType',
            'MeddelelseFESDmetadataType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\MeddelelseFESDmetadataType',
            'DigitalPostParametreType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\DigitalPostParametreType',
            'PostParametreType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\PostParametreType',
            'TransaktionsParametreIType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\TransaktionsParametreIType',
            'PrintParametreType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\PrintParametreType',
            'SlutbrugerIdentitetType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\SlutbrugerIdentitetType',
            'ForsendelseModtagerType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\ForsendelseModtagerType',
            'BilagType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\BilagType',
            'BilagSamlingType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\BilagSamlingType',
            'ForsendelseIType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\ForsendelseIType',
            'BrevSPBodyType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\BrevSPBodyType',
            'TilmeldingRequestType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\TilmeldingRequestType',
            'PrintAfsendBrevRequestType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\PrintAfsendBrevRequestType',
            'PrintAfsendBrevResponseType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\PrintAfsendBrevResponseType',
            'PrintSpoergTilmeldingRequestType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\PrintSpoergTilmeldingRequestType',
            'PrintSpoergTilmeldingResponseType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\PrintSpoergTilmeldingResponseType',
            'FejlType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\FejlType',
            'ServiceplatformFaultType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\ServiceplatformFaultType',
            'ErrorListType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\ErrorListType',
            'ErrorType' => '\\ItkDev\\OS2Forms_Digital_Post\\PrintService\\StructType\\ErrorType',
        ];
    }
}
