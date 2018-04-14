<p align="center"><a href="https://github.com/serotoninja/dev-bundle" target="_blank"><img src="https://img.shields.io/badge/serotoninja/dev--bundle-0.0.2-322d2d.svg?&style=for-the-badge" alt="SerotoninjaDevBundle"></a></p><h3 align="center">SerotoninjaDevBundle</h3><p align="center">Some smart development tools for Symfony.<br/><br/><a href="doc/" target="_blank"><strong>Documentation »</strong></a><br/><br/></p><hr>

## Status

[![PHP](https://img.shields.io/badge/PHP-7.1.3-8892BF.svg?style=flat-square)](https://php.net/)
[![Composer](https://img.shields.io/badge/Composer-1.6.3-4444ff.svg?style=flat-square)](https://getcompser.com/)
[![Symfony](https://img.shields.io/badge/Symfony-3.4-222222.svg?style=flat-square)](https://www.symfony.com/)
[![License](https://img.shields.io/badge/License-MIT-1284bf.svg?style=flat-square)](LICENSE)

## Quickstart

### Install via composer

```$ composer require serotoninja/dev-bundle --dev```
### Register bundle

Register as dev bundle in app/AppKernel.php:

```
public function registerBundles()
{
    // ...
    if (in_array($this->getEnvironment(), ['dev', 'test'])) {
        // ...
        $bundles[] = new Serotoninja\DevBundle\SerotoninjaDevBundle();
    }
    return $bundles;
}
```
### Configuration

Configure the bundle in app/config/config_dev.yml:

```
serotoninja_dev:
    make_readme:
        input_yaml: 'src/Acme/FooBundle/README.yml'
        target_dir: 'src/Acme/FooBundle'
        overwrite: false
```

## MakeReadme

### Input file

Copy the template and customize your own README.yml input file:

```$ cp vendor/serotoninja/dev-bundle/src/Resources/templates/readme.yml src/Acme/FooBundle/README.yml```
### Usage

Generate a new README.md file:

```$ php bin/console make:readme```

## Authors

**serotoninja** - Lead Developer
- <https://github.com/serotoninja>

