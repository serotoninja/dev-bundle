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
use Symfony\Component\Finder\Finder;

/**
 * Class MakeLicense
 *
 * @package Serotoninja\DevBundle\Maker
 *
 * @author serotoninja <serotoninja@gmail.com>
 * @since 2018-04-14
 */
final class MakeLicense extends AbstractMaker implements MakerInterface
{
    /** @var string */
    private const OUTPUT_FILE = 'LICENSE';

    /** @var array */
    private const KEYS = ['folder'];

    /** @var string */
    private $folder;

    /** @var array */
    private $licenses;

    /** @var string */
    private $templateFolder;

    /**
     * MakeLicense constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        foreach (self::KEYS as $key) {
            if (!array_key_exists($key, $config)) {
                throw new \RuntimeException(sprintf('Missing "%s" parameter.', $key));
            }
            $this->$key = $config[$key];
        }
        $finder = new Finder();
        $this->templateFolder = __DIR__. '/../Resources/skeleton/license';
        foreach ($finder->in($this->templateFolder)->name('*.tpl.php') as $file) {
            $this->licenses[] = explode('.', $file->getFilename())[0];
        }
    }

    /**
     * @return string
     */
    public static function getCommandName(): string
    {
        return 'make:license';
    }

    /**
     * @param Command $command
     * @param InputConfiguration $inputConf
     */
    public function configureCommand(Command $command, InputConfiguration $inputConf)
    {
        $command
            ->setDescription('Creates a new LICENSE file')
            ->addArgument('license', InputArgument::OPTIONAL, sprintf('Choose a license (e.g. <fg=yellow>%s</>)', explode('.', $this->licenses[0])[0]))
            ->addArgument('project', InputArgument::OPTIONAL, 'Provide the project name (e.g. <fg=yellow>FooBar</>)')
            ->addArgument('company', InputArgument::OPTIONAL, 'Provide the company name (e.g. <fg=yellow>Acme</>)')
            ->addArgument('folder', InputArgument::OPTIONAL, sprintf('Choose the working directory (e.g. <fg=yellow>%s</>)', $this->folder))
            ->addOption('force', 'f',InputOption::VALUE_NONE, 'Force generation (overwrites target file)')
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeLicense.txt'))
        ;
    }

    /**
     * @param InputInterface $input
     * @param ConsoleStyle $io
     * @param Generator $generator
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $license = trim($input->getArgument('license'));
        if (!in_array($license, $this->licenses)) {
            throw new \RuntimeException(sprintf('License "%s" not available.', $license));
        }

        $project = trim($input->getArgument('project'));
        $company = trim($input->getArgument('company'));
        $folder = trim($input->getArgument('folder'));
        $force = trim($input->getOption('force'));

        $targetPath = $folder . DIRECTORY_SEPARATOR . self::OUTPUT_FILE;

        if ($force && is_file($targetPath)) {
            unlink($targetPath);
        }

        $templatePath = $this->templateFolder . DIRECTORY_SEPARATOR . $license . '.tpl.php';

        $parameters = [
            'project' => $project,
            'year' => date('Y'),
            'company' => $company
        ];

        $generator->generateFile(
            $targetPath,
            $templatePath,
            $parameters
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);
        $io->text([
            'Next: open your new LICENSE file and check it!',
            'Find the documentation at <fg=yellow>https://en.wikipedia.org/wiki/Software_license</>',
        ]);
    }

    /**
     * @param DependencyBuilder $dependencies
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
    }
}
