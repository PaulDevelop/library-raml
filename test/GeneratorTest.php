<?php

namespace Com\PaulDevelop\Library\Auth;

use com\pauldevelop\library\raml\Generator;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testRamlAnnotatedClasses()
    {
//        $directoryToScan = realpath(
//            dirname(__FILE__)
//            .DIRECTORY_SEPARATOR.'assets'
//            .DIRECTORY_SEPARATOR.'testRamlAnnotatedClasses'
//            .DIRECTORY_SEPARATOR.'simple'
//        );
        $directoryToScan = realpath(
            dirname(__FILE__)
            .DIRECTORY_SEPARATOR.'assets'
            .DIRECTORY_SEPARATOR.'testRamlAnnotatedClass'
//            .DIRECTORY_SEPARATOR.'simple'
        );

        $generator = new Generator();
        $ramlDocuments = $generator->process('Karmap Core API', $directoryToScan, true);
        echo $ramlDocuments;

//            if (!$handle = fopen($ramlGenFile, "w")) {
//                echo 'Can\' open file "'.$ramlGenFile.'"'."\n";
//                exit;
//            }
//            fwrite($handle, '#%RAML 0.8'.PHP_EOL);
//            fclose($handle);
    }
}
