The Serotoninja DevBundle
=========================

Some smart development tools for Symfony.

Installation
------------

Run this command to install and enable this bundle in your application:

.. code-block:: terminal

    $ composer require serotoninja/dev-bundle --dev

Register as dev bundle in app/AppKernel.php:

.. code-block:: php

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

Usage
-----

This bundle provides several commands under the ``make:`` namespace. List them
all executing this command:

.. code-block:: terminal

    $ php bin/console list make

     [...]

     make:license            Creates a new LICENSE file
     make:readme             Creates a new README.md file

     [...]

The names of the commands are self-explanatory, but some of them include
optional arguments and options. Check them out with the ``--help`` option:

.. code-block:: terminal

    $ php bin/console make:license --help
    $ php bin/console make:readme --help

Configuration is optional, the needed values are requested by the script.
Change the proposed values in `config_dev.yml`:

.. code-block:: yaml

    serotoninja_dev:
        make_readme:
            folder: 'src/Acme/FooBundle'
        make_license:
            folder: 'src/Acme/FooBundle'