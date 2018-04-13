The Serotoninja DevBundle
=========================

Some smart development tools for Symfony.

Installation
------------

Run this command to install and enable this bundle in your application:

.. code-block:: terminal

    $ composer require serotoninja/dev-bundle --dev

Usage
-----

This bundle provides several commands under the ``make:`` namespace. List them
all executing this command:

.. code-block:: terminal

    $ php bin/console list make

     [...]

     make:readme             Creates a new README.md file

     [...]

The names of the commands are self-explanatory, but some of them include
optional arguments and options. Check them out with the ``--help`` option:

.. code-block:: terminal

    $ php bin/console make:readme --help
