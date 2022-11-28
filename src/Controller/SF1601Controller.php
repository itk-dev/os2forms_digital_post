<?php

namespace Drupal\os2forms_digital_post\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

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
   * {@inheritdoc}
   */
  public function __construct(RequestStack $requestStack) {
    $this->requestStack = $requestStack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack')
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

    return new JsonResponse([
      'name' => 'sf1601',
      'status' => 'ok',
    ]);
  }

}
