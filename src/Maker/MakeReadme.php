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
use Symfony\Component\Console\Input\InputOption;
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
    private const OUTPUT_FILE = 'README.md';

    private const INPUT_FILE = 'README.yml';

    private const TEMPLATE_FILE = 'README.md.tpl.php';

    private const KEYS = ['folder'];

    /** @var string */
    private $folder;

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
            ->addArgument('folder', InputArgument::OPTIONAL, sprintf('Choose the working directory (e.g. <fg=yellow>%s</>)', $this->folder))
            ->addOption('force', 'f',InputOption::VALUE_NONE, 'Force generation (overwrites target file)')
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
        $folder = trim($input->getArgument('folder'));
        $force = trim($input->getOption('force'));

        $templatePath = __DIR__. '/../Resources/skeleton/readme/' . self::TEMPLATE_FILE;
        $sourcePath = $folder . DIRECTORY_SEPARATOR . self::INPUT_FILE;
        $targetPath = $folder . DIRECTORY_SEPARATOR . self::OUTPUT_FILE;

        if ($force && is_file($targetPath)) {
            unlink($targetPath);
        }

        $parameters = Yaml::parse(file_get_contents($sourcePath))['readme'];

        $generator->generateFile(
            $targetPath,
            $templatePath,
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
    }
}
