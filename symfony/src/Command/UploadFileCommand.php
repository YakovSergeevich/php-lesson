<?php

namespace App\Command;

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
//       $files = $finder->files()->name('*.txt')->in(__DIR__ . '/../../public/uploads/catalog.txt');
//        dump($finder);exit;
////        $homepage = file_put_contents('file.txt', file_get_contents('https://drive.google.com/file/d/1dYlR7DIObdQLO54EqL65OZ-ywJQCPgJL/view'));
//          $files = realpath(dirname(dirname(__DIR__ )) . '/public') ;
//          dump($files . '/uploads/catalog.txt');exit;
//       $i = file_get_contents($files, true);
//          dump($i);exit;
//
        $files = $finder->files()->in('public/uploads')->name('catalog.txt');

        $result = '';
        foreach ($files as $key => $file) {

            $result = $file->getRealPath();
        }
        $f = file_get_contents($result);
        $f = $this->clearData($f);
//        $f = explode('|', $f);
//        dump($f);exit;
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
        dump($result);exit;
//        $this->productRepository->addArray($result);


//        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');
//
//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }
//
//        if ($input->getOption('option1')) {
//            // ...
//        }
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
