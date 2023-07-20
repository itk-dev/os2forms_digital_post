# OS2Forms Digital Post

Send Digital Post to danish citizens from a webform.

This module uses the
[SF1601](https://digitaliseringskataloget.dk/integration/sf1601) service from
Serviceplatformen. Information and documentation can be obtained by following
that link.

## Usage

This module provides functionality for sending digital post to danish citizens.
A WebformHandler is provided that you can add to your webform, and if configured
it will send the submitted data as digital post.

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

### Example forms

See [OS2Forms Digital Post
examples](modules/os2forms_digital_post_examples/README.md).

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
docker run --rm --interactive --tty --volume ${PWD}:/app itkdev/php8.1-fpm:latest composer install
docker run --rm --interactive --tty --volume ${PWD}:/app itkdev/php8.1-fpm:latest composer coding-standards-check

docker run --rm --interactive --tty --volume ${PWD}:/app node:18 yarn --cwd /app install
docker run --rm --interactive --tty --volume ${PWD}:/app node:18 yarn --cwd /app coding-standards-check
```

Apply coding standards:

```shell
docker run --rm --interactive --tty --volume ${PWD}:/app itkdev/php8.1-fpm:latest composer coding-standards-apply

docker run --rm --interactive --tty --volume ${PWD}:/app node:18 yarn --cwd /app coding-standards-apply
```
