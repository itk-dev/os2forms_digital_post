<?php

namespace Drupal\os2forms_digital_post\Helper;

use Drupal\os2forms_digital_post\Plugin\WebformHandler\WebformHandlerSF1601;
use Drupal\os2web_datalookup\LookupResult\CompanyLookupResult;
use Drupal\os2web_datalookup\LookupResult\CprLookupResult;
use Drupal\webform\WebformSubmissionInterface;
use ItkDev\Serviceplatformen\Service\SF1601\Serializer;
use Oio\Dkal\AfsendelseModtager;
use Oio\Ebxml\CountryIdentificationCode;
use Oio\Fjernprint\DokumentParametre;
use Oio\Fjernprint\ForsendelseI;
use Oio\Fjernprint\ForsendelseModtager;
use Oio\Fjernprint\ModtagerAdresse;
use Oio\Fjernprint\PostParametre;

/**
 * Forsendelse helper.
 */
class ForsendelseHelper extends AbstractMessageHelper {
  public const FORSENDELSES_TYPE_IDENTIFIKATOR = 'forsendelses_type_identifikator';

  // PostKategoriKode.
  public const POST_KATEGORI_KODE_PRIORITAIRE = 'Prioritaire';

  /**
   * Build forsendelse.
   *
   * @phpstan-param array<string, mixed> $options
   * @phpstan-param array<string, mixed> $handlerSettings
   */
  public function buildForsendelse(WebformSubmissionInterface $submission, array $options, array $handlerSettings, CprLookupResult|CompanyLookupResult|null $recipientData = NULL): ForsendelseI {
    $forsendelse = new ForsendelseI();

    $label = $this->replaceTokens($options[WebformHandlerSF1601::MESSAGE_HEADER_LABEL], $submission);
    $forsendelse
      ->setPostParametre((new PostParametre())
        ->setPostKategoriKode(self::POST_KATEGORI_KODE_PRIORITAIRE))
      ->setForsendelseModtager($this->createModtager($recipientData))
      ->setForsendelseTypeIdentifikator($options[self::FORSENDELSES_TYPE_IDENTIFIKATOR])
      ->setAfsendelseIdentifikator(Serializer::createUuid())
      ->setTransaktionsParametreI()
      ->setDokumentParametre((new DokumentParametre())
        ->setTitelTekst($label));

    $document = $this->getMainDocument($submission, $handlerSettings);
    if (!$this->isPdf($document)) {
      // This should never happen.
      // @todo We cannot to handle non-PDF content.
    }

    $forsendelse
      ->setFilformatNavn('PDF')
      ->setMeddelelseIndholdData($document[self::DOCUMENT_CONTENT]);

    return $forsendelse;
  }

  /**
   * Remove document content.
   */
  public function removeDocumentContent(ForsendelseI $forsendelse): ForsendelseI {
    $forsendelse->setMeddelelseIndholdData('');
    $forsendelse->setBilagSamling([]);

    return $forsendelse;
  }

  /**
   * Create modtager.
   */
  private function createModtager(CprLookupResult|CompanyLookupResult|null $recipient): ForsendelseModtager {
    $afsendelseModtager = new AfsendelseModtager();
    $modtagerAdresse = (new ModtagerAdresse());

    if ($recipient instanceof CprLookupResult) {
      // @see https://digitaliseringskataloget.srvitkhulk.itkdev.dk/digitaliseringskataloget.dk/sf1601/SF1601%20Bilag%2020211025/SF1601%20Postkomponent%20-%20KombiPostAfsend%20-%20Feltbeskrivelse.pdf#page=7
      $afsendelseModtager->setCPRnummerIdentifikator('0000000000');

      $modtagerAdresse
        ->setPersonName($recipient->getName())
        ->setStreetName($recipient->getStreet())
        ->setStreetBuildingIdentifier($recipient->getHouseNr())
        ->setPostCodeIdentifier($recipient->getPostalCode())
        ->setCountryIdentificationCode((new CountryIdentificationCode('DK'))
          ->setScheme('iso3166-alpha2')
        );

      if ($floor = trim($recipient->getFloor())) {
        $modtagerAdresse->setFloorIdentifier($floor);
      }
      if ($suite = trim($recipient->getApartmentNr())) {
        $modtagerAdresse->setSuiteIdentifier($suite);
      }
    }
    elseif ($recipient instanceof CompanyLookupResult) {
      $afsendelseModtager->setCVRnummerIdentifikator($recipient->getCvr());

      $modtagerAdresse
        ->setPersonName($recipient->getName())
        ->setStreetName($recipient->getStreet())
        ->setStreetBuildingIdentifier($recipient->getHouseNr())
        ->setPostCodeIdentifier($recipient->getPostalCode())
        ->setCountryIdentificationCode((new CountryIdentificationCode('DK'))
          ->setScheme('iso3166-alpha2')
        );

      if ($floor = trim($recipient->getFloor())) {
        $modtagerAdresse->setFloorIdentifier($floor);
      }
      if ($suite = trim($recipient->getApartmentNr())) {
        $modtagerAdresse->setSuiteIdentifier($suite);
      }
    }

    return (new ForsendelseModtager())
      ->setAfsendelseModtager($afsendelseModtager)
      ->setModtagerAdresse($modtagerAdresse);
  }

}
