<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

$PHPWord = new PHPWord();
 
// Every element you want to append to the word document is placed in a section. So you need a section:
$section = $PHPWord->createSection();
 
// After creating a section, you can append elements:
$section->addText('Putas');
 
// At least write the document to webspace:
$objWriter = IOFactory::createWriter($PHPWord, 'Word2007');

$temp_file_uri = tempnam('', 'xyz');
$objWriter->save($temp_file_uri);
//download code
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=helloWorld.docx');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Content-Length: ' . filesize($temp_file_uri));
readfile($temp_file_uri);
unlink($temp_file_uri); // deletes the temporary file