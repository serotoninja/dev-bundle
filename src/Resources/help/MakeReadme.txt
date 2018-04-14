The <info>%command.name%</info> command helps you to generate a <info>README.md</info> file easily.

<info>php %command.full_name%</info>

Provide optional <info>folder</info> argument for automatic generation.
Adding <info>force</info> option overwrites existing files:

<info>php %command.full_name% src/Acme/FooBundle --force</info>

If the argument is missing, the command will ask for it interactively.
