<p align="center"><a href="https://github.com/serotoninja/dev-bundle" target="_blank"><img src="https://avatars1.githubusercontent.com/u/38302310?s=460&v=4" alt="SerotoninjaDevBundle"></a></p><h3 align="center">SerotoninjaDevBundle</h3><p align="center">Some smart development tools for Symfony.<br/><br/><a href="doc/" target="_blank"><strong>Documentation »</strong></a><br/><br/></p><hr>

## Installation

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

## Authors

**serotoninja** - Lead Developer
- <https://github.com/serotoninja>

## License

[![license](https://img.shields.io/badge/license-MIT-red.svg?style=flat-square)](LICENSE)

