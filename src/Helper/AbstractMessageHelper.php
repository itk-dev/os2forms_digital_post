<?php

namespace Drupal\os2forms_digital_post\Helper;

use Drupal\Core\Render\ElementInfoManagerInterface;
use Drupal\os2forms_digital_post\Exception\InvalidAttachmentElementException;
use Drupal\os2forms_digital_post\Plugin\WebformHandler\WebformHandlerSF1601;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\WebformTokenManagerInterface;
use Drupal\webform_attachment\Element\WebformAttachmentBase;
use ItkDev\Serviceplatformen\Service\SF1601\Serializer;
use Oio\Fjernprint\ForsendelseI;

/**
 * Abstract message helper.
 */
abstract class AbstractMessageHelper {
  public const DOCUMENT_CONTENT = 'content';
  public const DOCUMENT_SIZE = 'size';
  public const DOCUMENT_MIME_TYPE = 'mime-type';
  public const DOCUMENT_FILENAME = 'filename';
  public const DOCUMENT_LANGUAGE = 'language';
  public const DOCUMENT_LANGUAGE_DEFAULT = 'da';

  protected const MIME_TYPE_PDF = 'application/pdf';

  /**
   * Constructor.
   */
  public function __construct(
    readonly protected ElementInfoManagerInterface $elementInfoManager,
    readonly protected WebformTokenManagerInterface $webformTokenManager
  ) {
  }

  /**
   * Get main document.
   *
   * @see WebformAttachmentController::download()
   */
  protected function getMainDocument(WebformSubmissionInterface $submission, array $handlerSettings): array {
    // Lifted from Drupal\webform_attachment\Controller\WebformAttachmentController::download.
    $element = $handlerSettings[WebformHandlerSF1601::MEMO_MESSAGE][WebformHandlerSF1601::ATTACHMENT_ELEMENT];
    $element = $submission->getWebform()->getElement($element) ?: [];
    [$type] = explode(':', $element['#type']);
    $instance = $this->elementInfoManager->createInstance($type);
    if (!$instance instanceof WebformAttachmentBase) {
      throw new InvalidAttachmentElementException(sprintf('Attachment element must be an instance of %s. Found %s.', WebformAttachmentBase::class, get_class($instance)));
    }

    $fileName = $instance::getFileName($element, $submission);
    $mimeType = $instance::getFileMimeType($element, $submission);
    $content = $instance::getFileContent($element, $submission);

    return [
      self::DOCUMENT_CONTENT => $content,
      self::DOCUMENT_SIZE => strlen($content),
      self::DOCUMENT_MIME_TYPE => $mimeType,
      self::DOCUMENT_FILENAME => $fileName,
      self::DOCUMENT_LANGUAGE => self::DOCUMENT_LANGUAGE_DEFAULT,
    ];
  }

  /**
   * Replace tokens.
   */
  protected function replaceTokens(string $text, WebformSubmissionInterface $submission): string {
    return $this->webformTokenManager->replace($text, $submission);
  }

  /**
   * Check if a document is a PDF document.
   */
  protected function isPdf(array $document): bool {
    return self::MIME_TYPE_PDF === $document[self::DOCUMENT_MIME_TYPE];
  }

  /**
   * Convert MeMo message to DOM document.
   */
  public function message2dom(Message|ForsendelseI $message): \DOMDocument {
    $document = new \DOMDocument();
    $document->loadXML((new Serializer())->serialize($message));

    return $document;
  }

}
