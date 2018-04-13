<?php

namespace Serotoninja\DevBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\MakerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class MakeReadme
 *
 * @package Serotoninja\DevBundle\Maker
 *
 * @author serotoninja <serotoninja@gmail.com>
 * @since 2018-04-13
 */
final class MakeReadme extends AbstractMaker implements MakerInterface
{
    private const FILE = 'README.md';

    private const KEYS = ['input_yaml', 'target_dir', 'overwrite'];

    /** @var string */
    private $input_yaml;

    /** @var string */
    private $target_dir;

    /** @var boolean */
    private $overwrite;

    /**
     * MakeReadme constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        foreach (self::KEYS as $key) {
            if (!array_key_exists($key, $config)) {
                throw new \RuntimeException(sprintf('Missing "%s" parameter.', $key));
            }
            $this->$key = $config[$key];
        }
    }

    /**
     * @return string
     */
    public static function getCommandName(): string
    {
        return 'make:readme';
    }

    /**
     * @param Command $command
     * @param InputConfiguration $inputConf
     */
    public function configureCommand(Command $command, InputConfiguration $inputConf)
    {
        $command
            ->setDescription('Creates a new README.md file')
            ->addArgument('dir', InputArgument::OPTIONAL, sprintf('Choose a target directory (e.g. <fg=yellow>%s</>)', $this->target_dir))
            ->addArgument('input', InputArgument::OPTIONAL, sprintf('Choose a yaml input file (e.g. <fg=yellow>%s</>)', $this->input_yaml))
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeReadme.txt'))
        ;
    }

    /**
     * @param InputInterface $input
     * @param ConsoleStyle $io
     * @param Generator $generator
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $dir = trim($input->getArgument('dir'));
        $input = trim($input->getArgument('input'));

        $targetPath = $dir . '/' . self::FILE;

        if ($this->overwrite && is_file($targetPath)) {
            unlink($targetPath);
        }

        $parameters = Yaml::parse(file_get_contents($input))['readme'];

        $template = __DIR__. '/../Resources/skeleton/readme/README.md.tpl.php';

        $generator->generateFile(
            $targetPath,
            $template,
            $parameters
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);
        $io->text([
            'Next: open your new README.md file and customize it!',
            'Find the documentation at <fg=yellow>https://en.wikipedia.org/wiki/README</>',
        ]);
    }

    /**
     * @param DependencyBuilder $dependencies
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
        $dependencies->addClassDependency(
            Command::class,
            'console'
        );
    }
}
