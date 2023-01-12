# OS2Forms Digital Post

Send Digital Post to danish citizens from a webform.

This module uses the
[SF1600](https://digitaliseringskataloget.dk/integration/sf1600) service from
Serviceplatformen. Information and documentation can be obtained by following
that link.

## Beskedfordeler endpoint

This module provides an endpoint,
`/os2forms_digital_post/PostStatusBeskedModtag`, for
“[PostStatusBeskedModtag](https://digitaliseringskataloget.dk/integration/sf1601)”
to get information on how or why not a digital post has been delivered. See
“PostStatusBeskedHent” on
<https://digitaliseringskataloget.dk/integration/sf1601> for details.

## Installation

Require it with composer:

```shell
composer require "itk-dev/os2forms_digital_post"
```

Enable it with drush:

```shell
drush pm:enable os2forms_digital_post
```

## Configuration

Go to `/admin/os2forms_digital_post/settings` to set up global settings for
digital post.

## Drush commands

```sh
drush --uri=$(itkdev-docker-compose url) os2forms_digital_post:digital-post:send --help

drush --uri=$(itkdev-docker-compose url) os2forms_digital_post:digital-post:memo-show --help
```

## Queue

Digital post is sent via jobs via an [Advanced
Queue](https://www.drupal.org/project/advancedqueue) called
`os2forms_digital_post`.

The queue is processed via [Drupal's cron
run](https://www.drupal.org/docs/administering-a-drupal-site/cron-automated-tasks/cron-automated-tasks-overview),
but you can manually process the queue with `drush` if you want to process it
more often than other Drupal cron jobs:

```sh
drush advancedqueue:queue:process os2forms_digital_post
```

List the queue (and all other queues) with

```sh
drush advancedqueue:queue:list
```

or go to `/admin/config/system/queues/jobs/os2forms_digital_post` for a
graphical overview of jobs in the queue.

--------------------------------------------------------------------------------

<!-- markdownlint-disable MD013 -->
<!-- markdownlint-disable MD022 -->
<!-- markdownlint-disable MD025 -->
<!-- markdownlint-disable MD031 -->
<!-- markdownlint-disable MD032 -->
# Obsolete documentation

Add the following configuration:

```php
$config['os2forms_digital_post'] = [
  'path_to_templates' => '',

  'digital_post_system_id' => '',
  'digital_post_afsender_system' => '',

  'digital_post_materiale_id' => '',

  'digital_post_forsendelses_type' => '',

  'azure_tenant_id' => '',
  'azure_application_id' => '',
  'azure_client_secret' => '',

  'azure_key_vault_name' => '',
  'azure_key_vault_secret' => '',
  'azure_key_vault_secret_version' => '',

  'service_agreement_uuid' => '',
  'user_system_uuid' => '',
  'user_uuid' => '',

  'service_uuid' => 'fd885b8b-4a3f-46cb-b367-6c9dda1c78f6',
  'service_endpoint' => 'https://prod.serviceplatformen.dk/service/Print/Print/2',
  'service_contract' => dirname(DRUPAL_ROOT) . '/web/modules/contrib/os2forms_digital_post/resources/contracts/PrintService/wsdl/context/PrintService.wsdl',
];

```

## Templating / Styling the PDF
You'll need to provide a PDF template, that will be rendered when sending letters via digital post.
The template has to be in the twig format and accessible by this module. Configure the path to your templates
in the settings mentioned above.

The following variables is present in the twig-template:
* logo - Path to the logo in your template.
* recipient - Which holds information about the recipient of the letter.
* elements - The elements submitted in the form.

### Structure of template
Your template folder structure has to be as following:
```shell
/templates-root # Set this folder as "path_to_templates" in the settings.
  /name-of-template
    index.html.twig # The actual twig template.
    logo.png # Logo
    styles.css # The styles. Be aware that this module uses DomPDF to render the PDF, and therefore are submitted to the CSS rules defined in DomPDF.
```

## Usage

This module provides functionality for sending digital post to danish citizens.
A WebformHandler is provided that you can add to your webform, and if configured
it will send the submitted data as digital post.

This module provides functionality for querying the danish CPR register and
showing the result in webforms.

<!-- markdownlint-enable MD013 -->
<!-- markdownlint-enable MD022 -->
<!-- markdownlint-enable MD025 -->
<!-- markdownlint-enable MD031 -->
<!-- markdownlint-enable MD032 -->
## Coding standards

All coding standards are checked with [GitHub
Actions](https://github.com/features/actions) when a pull request is made (cf.
<.github/workflows/pr.yaml>).

Check coding standards:

```sh
docker run --rm --interactive --tty --volume ${PWD}:/app itkdev/php7.4-fpm:latest composer install
docker run --rm --interactive --tty --volume ${PWD}:/app itkdev/php7.4-fpm:latest composer coding-standards-check

docker run --rm --interactive --tty --volume ${PWD}:/app node:18 yarn --cwd /app install
docker run --rm --interactive --tty --volume ${PWD}:/app node:18 yarn --cwd /app coding-standards-check
```

Apply coding standards:

```shell
docker run --rm --interactive --tty --volume ${PWD}:/app itkdev/php7.4-fpm:latest composer coding-standards-apply

docker run --rm --interactive --tty --volume ${PWD}:/app node:18 yarn --cwd /app coding-standards-apply
```

<!-- markdownlint-disable MD013 -->
<!-- markdownlint-disable MD022 -->
<!-- markdownlint-disable MD025 -->
<!-- markdownlint-disable MD031 -->
<!-- markdownlint-disable MD032 -->
## Drush command

A drush command is available for testing purposes. It creates a PDF from a template and a given submission.

Read more:
```shell
drush os2forms_digital_post:create_pdf --help
```
