<?php
use App\Parser;

require __DIR__ . '/vendor/autoload.php';


$parser = new Parser('https://www.google.ru/');
$parser->run();
echo "Parse https://www.google.ru/'" . "\n";
print_r($parser->getTags());


$parser = new Parser('http://laravelstudy.lilit-web.ru/');
$parser->run();
echo "Parse http://laravelstudy.lilit-web.ru/" . "\n";
print_r($parser->getTags());

