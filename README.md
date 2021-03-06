<p align="center"><a href="https://github.com/serotoninja/dev-bundle" target="_blank"><img src="https://img.shields.io/badge/serotoninja/dev--bundle-0.0.5-322d2d.svg?&style=for-the-badge" alt="SerotoninjaDevBundle"></a></p><h3 align="center">SerotoninjaDevBundle</h3><p align="center">Some smart development tools for Symfony.<br/><br/><a href="doc/" target="_blank"><strong>Documentation »</strong></a><br/><br/></p><hr>

## Table of contents

- [Status](#status)
- [Quickstart](#quickstart)
- [MakeReadme](#makereadme)
- [MakeLicense](#makelicense)
- [Authors](#authors)

## Status

[![PHP](https://img.shields.io/badge/PHP-7.1.3-8892BF.svg?style=flat-square)](https://php.net/)
[![Composer](https://img.shields.io/badge/Composer-1.6.3-4444ff.svg?style=flat-square)](https://getcompser.com/)
[![Symfony](https://img.shields.io/badge/Symfony-3.4-222222.svg?style=flat-square)](https://www.symfony.com/)
[![License](https://img.shields.io/badge/License-MIT-1284bf.svg?style=flat-square)](LICENSE)

## Quickstart

Depends on [The Symfony MakerBudle](https://github.com/symfony/maker-bundle).

### Install via composer

```bash
$ composer require serotoninja/dev-bundle --dev
```
### Register bundle

Register as dev bundle in app/AppKernel.php:

```php
// app/AppKernel.php

public function registerBundles()
{
    // ...
    if (in_array($this->getEnvironment(), ['dev', 'test'])) {
        // ...
        $bundles[] = new Serotoninja\DevBundle\SerotoninjaDevBundle();
    }
    return $bundles;
}
// ...
```
### Configuration

Configuration is optional, the needed values are requested by the script.

Change the proposed values in `config_dev.yml`:


```yaml
serotoninja_dev:
    make_readme:
        folder: 'src/Acme/FooBundle'
    make_license:
        folder: 'src/Acme/FooBundle'
```

## MakeReadme

### Input file

Copy the template and customize your own README.yml input file:

```bash
$ cp vendor/serotoninja/dev-bundle/examples/make-readme/README.yml src/Acme/FooBundle
```
### Usage

Generate a `README.md` file easily:

```bash
$ php bin/console make:readme
```

## MakeLicense

### Usage

Generate a `LICENSE` file easily:

```bash
$ php bin/console make:license
```

## Authors

**serotoninja** - Lead Developer
- <https://github.com/serotoninja>

