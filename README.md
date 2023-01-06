# OS2Forms Digital Post

Send Digital Post to danish citizens from a webform.
This module use the [SF1600](https://digitaliseringskataloget.dk/integration/sf1600) service from Serviceplatformen. Information and documentation can be obtained by following that link.

## Beskedfordeler endpoint

This module provides an endpoint,
`/os2forms_digital_post/PostStatusBeskedModtag`, for
“[PostStatusBeskedModtag](https://digitaliseringskataloget.dk/integration/sf1601)”
to get information on how or why not a digital post has been delivered. See
“PostStatusBeskedHent” on
<https://digitaliseringskataloget.dk/integration/sf1601> for some details.

A certificate is required for the endpoint:

```sh
# Generate a key
openssl genrsa -aes256 -out $(hostname).os2forms_digital_post.key.pem
# Generate a certificate from the key
openssl req -new -x509 -key $(hostname).os2forms_digital_post.key.pem -out $(hostname).os2forms_digital_post.cert.pem -days 1095
```

You can pass subjects values on the command line, e.g.:

```sh
openssl req -new -x509 -key $(hostname).os2forms_digital_post.key.pem -out $(hostname).os2forms_digital_post.cert.pem -days 1095 -subj "/C=DK/L=Aarhus/O=os2forms_digital_post/CN=$(hostname).os2forms_digital_post/emailAddress=os2forms_digital_post@example.com"
```

## Installation

Require it with composer:

```shell
composer require "itk-dev/os2forms_digital_post"
```

Enable it with drush:

```shell
drush pm:enable os2forms_digital_post
```

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

## Coding standards

Check coding standards (run `composer install` to install the required tools):

```shell
composer coding-standards-check
```

Apply coding standards:

```shell
composer coding-standards-apply
```

## Drush command

A drush command is available for testing purposes. It creates a PDF from a template and a given submission.

Read more:
```shell
drush os2forms_digital_post:create_pdf --help
```
