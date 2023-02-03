<?php

namespace Drupal\os2forms_digital_post\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\os2forms_digital_post\Helper\SF1461Helper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for SF1601 callbacks.
 */
class SF1601Controller extends ControllerBase {
  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  private RequestStack $requestStack;

  /**
   * The SF1461 helper.
   *
   * @var \Drupal\os2forms_digital_post\Helper\SF1461Helper
   */
  private SF1461Helper $sf1461;

  /**
   * {@inheritdoc}
   */
  public function __construct(RequestStack $requestStack, SF1461Helper $sf1461) {
    $this->requestStack = $requestStack;
    $this->sf1461 = $sf1461;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
      $container->get(SF1461Helper::class),
    );
  }

  /**
   * Handle PostStatusBeskedModtag.
   *
   * @see https://digitaliseringskataloget.dk/integration/sf1601
   */
  public function postStatusBeskedModtag() {
    // Write the payload to a local file.
    $request = $this->requestStack->getCurrentRequest();
    $payload = [
      'now' => (new \DateTimeImmutable())->format(\DateTimeImmutable::ATOM),
      'method' => $request->getMethod(),
      'headers' => $request->headers->all(),
      'query' => $request->query->all(),
      'content' => $request->getContent(),
    ];
    file_put_contents(__FILE__ . '.log', var_export($payload, TRUE), FILE_APPEND);

    $statusCode = 20;
    $errorMessage = NULL;

    $document = $this->sf1461->buildResponseDocument($statusCode, $errorMessage);

    return new Response($document->saveXML(), Response::HTTP_OK, ['content-type' => 'application/xml']);
  }

}
