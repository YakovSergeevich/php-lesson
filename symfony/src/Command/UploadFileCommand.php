<?php

namespace App\Command;

use App\Repository\ProductRepository;
use App\Service\HelloService;
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

    /**
     * @var HelloService
     */
    private HelloService $helloService;

    /**
     * UploadFileCommand constructor.
     * @param HelloService $helloService
     */
    public function __construct(HelloService $helloService)
    {

        parent::__construct();

        $this->helloService = $helloService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Read File');
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//        ;
    }

    public function clearData($data)
    {
        $string = preg_replace('/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u', ' ', $data);
        $string = preg_replace('# {2,}#', ' ', trim(strip_tags(html_entity_decode($string))));
        $string = str_replace('-', '.', $string);
        $i = ['"'];
        $k = [''];
        $string = str_replace($i, $k, trim($string));
        return $string;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $finder = new Finder();
        $files = $finder->files()->in('public/uploads')->name('catalog.txt');

        $result = '';
        foreach ($files as $key => $file) {

            $result = $file->getRealPath();
        }
        $f = file_get_contents($result);
        $f = $this->clearData($f);
        $f = preg_replace('/([0-9)]){6}/', PHP_EOL . '$0', $f);
        $f = explode(PHP_EOL, $f);
        $arrays = [];
        foreach ($f as $k => $v) {
            $arrays[$k] = $v;
        }
        $result = [];
        foreach ($arrays as $k => $v) {
            $result[$k] = explode('|', trim($v, '|'));

        }
        array_shift($result);
        $this->helloService->send($result);
        return Command::SUCCESS;
    }
}
