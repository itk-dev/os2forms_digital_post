<?php

namespace Drupal\os2forms_digital_post\Manager;

use Dompdf\Css\Stylesheet;
use Dompdf\Dompdf;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Template\TwigEnvironment;
use Twig\Loader\FilesystemLoader;

class TemplateManager implements TemplateManagerInterface {

  private $config;
  private $twigEnvironment;

  public function __construct(ConfigFactoryInterface $configFactory, TwigEnvironment $twigEnvironment, FilesystemLoader $filesystemLoader) {
    $this->config = $configFactory->get('os2forms_digital_post');
    $filesystemLoader->addPath($this->config->get('path_to_templates'));
    $this->twigEnvironment = $twigEnvironment;
  }

  /**
   * {@inheritDoc}
   */
  public function getAvailableTemplates(): array
  {
    $pathToTemplates = $this->config->get('path_to_templates');

    $listOfTemplates = [];

    $directoryIterator = new \DirectoryIterator($pathToTemplates);
    foreach ($directoryIterator as $fileInfo) {
      if (!$fileInfo->isDir() || $fileInfo->isDot()) {
        continue;
      }

      $listOfTemplates[$fileInfo->getBasename()] = $fileInfo->getBasename();
    }

    return $listOfTemplates;
  }

  public function renderHtml(string $template, array $context = []): string {

    $context['logo'] = $this->getPathToBase64EncodedLogo($template);
    $pathToTemplate = $template . '/index.html.twig';

    return $this->twigEnvironment->render($pathToTemplate, $context);
  }

  public function renderPdf(string $template, array $context = [], bool $stream = false): string {

    $html = $this->renderHtml($template, $context);

    $domPdf = new Dompdf();

    $pathToCss = $this->getPathToTemplate($template) . '/styles.css';
    $stylesheet = new Stylesheet($domPdf);
    $cssAsString = file_get_contents($pathToCss);
    $stylesheet->load_css($cssAsString);
    $domPdf->setCss($stylesheet);

    $domPdf->loadHtml($html);
    $domPdf->render();

    if (true === $stream) {
      $domPdf->stream(); // Streams PDF to browser
    }

    return $domPdf->output(); //Returns PDF as string
  }

  private function getPathToBase64EncodedLogo($template): string {
    $pathToLogo = $this->getPathToTemplate($template) . '/logo.png';

    if (!file_exists($pathToLogo)) {
      return 'Logo not found!';
    }

    $extension = pathinfo($pathToLogo, PATHINFO_EXTENSION);
    $data = file_get_contents($pathToLogo);
    $logoBase64 = base64_encode($data);

    return 'data:image/' . $extension . ';base64,' . $logoBase64;
  }

  private function getPathToTemplate(string $template): string {
    return $this->config->get('path_to_templates') . '/' . $template;
  }
}
