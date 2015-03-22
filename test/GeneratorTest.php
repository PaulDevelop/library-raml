<?php

namespace Com\PaulDevelop\Library\Auth;

use com\pauldevelop\library\raml\Annotation;
use com\pauldevelop\library\raml\AnnotationCollection;
use com\pauldevelop\library\raml\AnnotationParameter;
use com\pauldevelop\library\raml\AnnotationParameterCollection;
use com\pauldevelop\library\raml\Generator;
use com\pauldevelop\library\raml\Parser;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testRamlAnnotatedClasses()
    {
//        $directoryToScan = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets/test/ramlAnnotatedClasses');
        $directoryToScan = realpath(
            dirname(__FILE__)
            .DIRECTORY_SEPARATOR.'assets'
            .DIRECTORY_SEPARATOR.'testRamlAnnotatedClasses'
            .DIRECTORY_SEPARATOR.'simple'
        );

        $generator = new Generator();
        $ramlDocuments = $generator->process($directoryToScan, true);
        echo $ramlDocuments[0];


//            if (!$handle = fopen($ramlGenFile, "w")) {
//                echo 'Can\' open file "'.$ramlGenFile.'"'."\n";
//                exit;
//            }
//
//            fwrite($handle, '#%RAML 0.8'.PHP_EOL);
//
//            fclose($handle);

    }

}
