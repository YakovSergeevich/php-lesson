<?php


namespace App\Service;


class ProductImporter
{
    /**
     * @var ProductBuilder
     */
    private ProductBuilder $productBuilder;

    /**
     * ProductImporter constructor.
     * @param ProductBuilder $productBuilder
     */
    public function __construct(ProductBuilder $productBuilder)
    {
        $this->productBuilder = $productBuilder;
    }

    public function import(string $path)
    {
        $handle = fopen($path, 'rb');
        if (!$handle) {
            throw new \Exception(sprintf('File %s not found', $path));
        }

        while (($line = fgets($handle)) !== false) {
            $productDetails = explode('|', trim($this->sanitize($line), '|'));
            if (count($productDetails) > 4) {
                yield $this->productBuilder->build($productDetails);
            }

        }
        fclose($handle);


//        $f = file_get_contents($path);
//        $f = $this->clearData($f);
//        $f = preg_replace('/([0-9)]){6}/', PHP_EOL . '$0', $f);
//        $f = explode(PHP_EOL, $f);
//        $arrays = [];
//        foreach ($f as $k => $v) {
//            $arrays[$k] = $v;
//        }
//        $result = [];
//        foreach ($arrays as $k => $v) {
//            $result[$k] = explode('|', trim($v, '|'));
//
//        }
//        array_shift($result);

    }

    private function sanitize(string $productLine)
    {
        $string = preg_replace('/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u', ' ', $productLine);
        $string = preg_replace('# {2,}#', ' ', trim(strip_tags(html_entity_decode($string))));
        $string = str_replace('-', '.', $string);
        return $string;
    }

}