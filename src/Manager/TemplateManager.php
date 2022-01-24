<?php

namespace Drupal\os2forms_digital_post\Manager;

use Drupal\Core\Config\ImmutableConfig;
use Dompdf\Css\Stylesheet;
use Dompdf\Dompdf;
use Dompdf\Options;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Template\TwigEnvironment;
use Twig\Loader\FilesystemLoader;

/**
 * Template manager.
 */
class TemplateManager implements TemplateManagerInterface {
  /**
   * The config.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  private ImmutableConfig $config;

  /**
   * The Twig environment.
   *
   * @var \Drupal\Core\Template\TwigEnvironment
   */
  private TwigEnvironment $twigEnvironment;

  /**
   * Constructor.
   */
  public function __construct(ConfigFactoryInterface $configFactory, TwigEnvironment $twigEnvironment, FilesystemLoader $filesystemLoader) {
    $this->config = $configFactory->get('os2forms_digital_post');
    $filesystemLoader->addPath($this->config->get('path_to_templates'));
    $this->twigEnvironment = $twigEnvironment;
  }

  /**
   * {@inheritDoc}
   */
  public function getAvailableTemplates(): array {
    $pathToTemplates = $this->config->get('path_to_templates');

    $listOfTemplates = [];

    // This list of directory names will not be showed as available templates
    // in the handlers settings page.
    $ignoredDirectories = ['.git'];

    $directoryIterator = new \DirectoryIterator($pathToTemplates);
    foreach ($directoryIterator as $fileInfo) {
      if (!$fileInfo->isDir() || $fileInfo->isDot() || in_array($fileInfo->getBasename(), $ignoredDirectories)) {
        continue;
      }

      $listOfTemplates[$fileInfo->getBasename()] = $fileInfo->getBasename();
    }

    return $listOfTemplates;
  }

  /**
   * {@inheritDoc}
   */
  public function renderHtml(string $template, array $context = []): string {

    $context['logo'] = $this->getPathToBase64EncodedLogo($template);
    $pathToTemplate = $template . '/index.html.twig';

    return $this->twigEnvironment->render($pathToTemplate, $context);
  }

  /**
   * {@inheritDoc}
   */
  public function renderPdf(string $template, array $context = [], bool $stream = FALSE): string {

    $html = $this->renderHtml($template, $context);

    $options = new Options();
    $options->setIsHtml5ParserEnabled(TRUE);
    $domPdf = new Dompdf();
    $domPdf->setPaper('A4', 'portrait');

    $pathToCss = $this->getPathToTemplate($template) . '/styles.css';
    $cssAsString = file_get_contents($pathToCss);

    $stylesheet = new Stylesheet($domPdf);
    $stylesheet->load_css($cssAsString);
    $domPdf->setCss($stylesheet);

    $domPdf->loadHtml($html);
    $domPdf->render();

    if (TRUE === $stream) {
      // Streams PDF to browser.
      $domPdf->stream();
      return '';
    }

    // Returns PDF as string.
    return $domPdf->output();
  }

  /**
   * Get path to base64encoded logo.
   */
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

  /**
   * Get path to template.
   */
  private function getPathToTemplate(string $template): string {
    return $this->config->get('path_to_templates') . '/' . $template;
  }

}
