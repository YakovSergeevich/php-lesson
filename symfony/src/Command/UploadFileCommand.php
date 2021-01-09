<?php

namespace App\Command;

use App\Repository\ProductRepository;
use App\Service\ProductImporter;
use App\Service\ProductQueueProducer;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

class UploadFileCommand extends Command
{
    protected static $defaultName = 'app:upload-file';
    private ProductQueueProducer $productQueueProducer;
    private string $rootPath;
    private ProductImporter $productImporter;

    /**
     * UploadFileCommand constructor.
     * @param ProductQueueProducer $productQueueProducer
     * @param string $rootPath
     * @param ProductImporter $productImporter
     */
    public function __construct(ProductQueueProducer $productQueueProducer, string $rootPath, ProductImporter $productImporter)
    {
        parent::__construct();
        $this->productQueueProducer = $productQueueProducer;
        $this->rootPath = $rootPath;
        $this->productImporter = $productImporter;
    }

    protected function configure()
    {
        $this
            ->setDescription('Read File')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to file product');
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $this->rootPath . DIRECTORY_SEPARATOR . ltrim($input->getArgument('path'), DIRECTORY_SEPARATOR);
        foreach ($this->productImporter->import($path) as $productDTO) {

            $this->productQueueProducer->createProduct($productDTO);
            $output->writeln(sprintf('Product parsed: %s', json_encode($productDTO)));

        }
        $output->writeln('Success');

        return Command::SUCCESS;
    }
}
