<?php

namespace Com\PaulDevelop\Library\Auth;

use com\pauldevelop\library\raml\Annotation;
use com\pauldevelop\library\raml\AnnotationCollection;
use com\pauldevelop\library\raml\AnnotationParameter;
use com\pauldevelop\library\raml\AnnotationParameterCollection;
use com\pauldevelop\library\raml\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testSimpleAnnotatedClass()
    {
        $fileAnnotations = Parser::process(
            realpath(
                dirname(__FILE__)
                .DIRECTORY_SEPARATOR.'assets'
                .DIRECTORY_SEPARATOR.'testSimpleAnnotatedClass'
                .DIRECTORY_SEPARATOR.'AClass.php'
            )
        );

        $fileLevelAnnotations = new AnnotationCollection(
            array(
                new Annotation(
                    '\raml\annotations\Title',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'title',
                                'FILE LEVEL'
                            )
                        ),
                        'key'
                    )
                )
            )//,
            //'name'
        );

//        $fileLevelAnnotations->add(
//            new Annotation(
//                '\raml\annotations\Title',
//                new AnnotationParameterCollection(
//                    array(
//                        new AnnotationParameter(
//                            'title',
//                            'FILE LEVEL'
//                        )
//                    ),
//                    'key'
//                )
//            ),
//            '\raml\annotations\Title'
//        );

        $classLevelAnnotations = new AnnotationCollection(
            array(
                new Annotation(
                    '\raml\annotations\Title',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'title',
                                'CLASS LEVEL'
                            )
                        ),
                        'key'
                    )
                )
            )//,
            //'name'
        );

        $methodsLevelAnnotations = array(
            new AnnotationCollection(
                array(
                    new Annotation(
                        '\raml\annotations\Title',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'title',
                                    'METHOD LEVEL 1'
                                )
                            ),
                            'key'
                        )
                    )
                )//,
                //'name'
            ),
            new AnnotationCollection(
                array(
                    new Annotation(
                        '\raml\annotations\Title',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'title',
                                    'METHOD LEVEL 2'
                                )
                            ),
                            'key'
                        )
                    )
                )//,
                //'name'
            )
        );

        $this->assertEquals($fileLevelAnnotations, $fileAnnotations->getFileLevel());
        $this->assertEquals($classLevelAnnotations, $fileAnnotations->getClassLevel());
        $this->assertEquals($methodsLevelAnnotations, $fileAnnotations->getMethodsLevel());
    }

    /**
     * @test
     */
    public function testRamlAnnotatedClass()
    {
        $fileAnnotations = Parser::process(
            realpath(
                dirname(__FILE__)
                .DIRECTORY_SEPARATOR.'assets'
                .DIRECTORY_SEPARATOR.'testRamlAnnotatedClass'
                .DIRECTORY_SEPARATOR.'RamlAnnotatedClass.php'
            )
        );

        $fileLevelAnnotations = new AnnotationCollection(
            array(
                new Annotation(
                    '\raml\annotations\Title',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'title',
                                'Karmap Core API'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\Version',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'version',
                                'v1'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\BaseUri',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'baseUri',
                                'https://api.core.karmap.com/{version}'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\MediaType',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'mediaType',
                                'application/json'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\Protocol',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'protocol',
                                'HTTPS'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\SecurityScheme',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'name',
                                'basic'
                            ),
                            new AnnotationParameter(
                                'type',
                                'Basic Authentication'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\ResponseScheme',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'name',
                                'interpretation-result'
                            ),
                            new AnnotationParameter(
                                'url',
                                'https://api.karmap.com/patterns/v1/schema-interpretation-result.json'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\ResponseScheme',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'name',
                                'interpretation-result-example'
                            ),
                            new AnnotationParameter(
                                'url',
                                'https://api.karmap.com/patterns/v1/schema-interpretation-result-example.json'
                            )
                        ),
                        'key'
                    )
                )
            )//,
            //'name'
        );

        $methodsLevelAnnotations = array(
            new AnnotationCollection(
                array(
                    new Annotation(
                        '\raml\annotations\HttpVerb',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'verb',
                                    'POST'
                                )
                            ),
                            'key'
                        )
                    ),
                    new Annotation(
                        '\raml\annotations\Resource',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'resource',
                                    '/anonymousInterpretations'
                                )
                            ),
                            'key'
                        )
                    ),
                    new Annotation(
                        '\raml\annotations\Description',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'description',
                                    'Create anonymous interpretation'
                                )
                            ),
                            'key'
                        )
                    ),
                    new Annotation(
                        '\raml\annotations\SecuredBy',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'scheme',
                                    'basic'
                                )
                            ),
                            'key'
                        )
                    ),
                    new Annotation(
                        '\raml\annotations\Parameter',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'parameterType',
                                    'form'
                                ),
                                new AnnotationParameter(
                                    'name',
                                    'clientCode'
                                ),
                                new AnnotationParameter(
                                    'displayName',
                                    'Client code'
                                ),
                                new AnnotationParameter(
                                    'description',
                                    'Code identifying the client'
                                ),
                                new AnnotationParameter(
                                    'type',
                                    'string'
                                ),
                                new AnnotationParameter(
                                    'pattern',
                                    '^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$'
                                ),
                                new AnnotationParameter(
                                    'required',
                                    'true'
                                ),
                                new AnnotationParameter(
                                    'example',
                                    '7e2c20d3-6500-497c-83f1-76c64de3bb02'
                                )
                            ),
                            'key'
                        )
                    ),

                    new Annotation(
                        '\raml\annotations\Parameter',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'parameterType',
                                    'form'
                                ),
                                new AnnotationParameter(
                                    'name',
                                    'personBirthdate'
                                ),
                                new AnnotationParameter(
                                    'displayName',
                                    'Person birthday'
                                ),
                                new AnnotationParameter(
                                    'description',
                                    'A person\'s birthdate in the form "YYYY-MM-DD HH:mm:ss".'
                                ),
                                new AnnotationParameter(
                                    'type',
                                    'string'
                                ),
                                new AnnotationParameter(
                                    'pattern',
                                    '^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}-[0-9]{2}-[0-9]{2}$'
                                ),
                                new AnnotationParameter(
                                    'required',
                                    'true'
                                ),
                                new AnnotationParameter(
                                    'example',
                                    '1979-06-19 11:17:00'
                                )
                            ),
                            'key'
                        )
                    )
                )//,
                //'name'
            )
        );

        $this->assertEquals($fileLevelAnnotations, $fileAnnotations->getFileLevel());
        $this->assertEquals($methodsLevelAnnotations, $fileAnnotations->getMethodsLevel());
    }

    /**
     * @test
     */
    public function testRamlAnnotatedClassWithResponse()
    {
        $fileAnnotations = Parser::process(
            realpath(
                dirname(__FILE__)
                .DIRECTORY_SEPARATOR.'assets'
                .DIRECTORY_SEPARATOR.'testRamlAnnotatedClass'
                .DIRECTORY_SEPARATOR.'RamlAnnotatedClassWithResponse.php'
            )
        );

        $fileLevelAnnotations = new AnnotationCollection(
            array(
                new Annotation(
                    '\raml\annotations\Title',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'title',
                                'Karmap Core API'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\Version',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'version',
                                'v1'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\BaseUri',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'baseUri',
                                'https://api.core.karmap.com/{version}'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\MediaType',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'mediaType',
                                'application/json'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\Protocol',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'protocol',
                                'HTTPS'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\SecurityScheme',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'name',
                                'basic'
                            ),
                            new AnnotationParameter(
                                'type',
                                'Basic Authentication'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\ResponseScheme',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'name',
                                'interpretation-result'
                            ),
                            new AnnotationParameter(
                                'url',
                                'https://api.karmap.com/patterns/v1/schema-interpretation-result.json'
                            )
                        ),
                        'key'
                    )
                ),
                new Annotation(
                    '\raml\annotations\ResponseScheme',
                    new AnnotationParameterCollection(
                        array(
                            new AnnotationParameter(
                                'name',
                                'interpretation-result-example'
                            ),
                            new AnnotationParameter(
                                'url',
                                'https://api.karmap.com/patterns/v1/schema-interpretation-result-example.json'
                            )
                        ),
                        'key'
                    )
                )
            )//,
            //'name'
        );

        $methodsLevelAnnotations = array(
            new AnnotationCollection(
                array(
                    new Annotation(
                        '\raml\annotations\HttpVerb',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'verb',
                                    'POST'
                                )
                            ),
                            'key'
                        )
                    ),
                    new Annotation(
                        '\raml\annotations\Resource',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'resource',
                                    '/anonymousInterpretationsWithResponse'
                                )
                            ),
                            'key'
                        )
                    ),
                    new Annotation(
                        '\raml\annotations\Description',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'description',
                                    'Create anonymous interpretation'
                                )
                            ),
                            'key'
                        )
                    ),
                    new Annotation(
                        '\raml\annotations\SecuredBy',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'scheme',
                                    'basic'
                                )
                            ),
                            'key'
                        )
                    ),
                    new Annotation(
                        '\raml\annotations\Parameter',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'parameterType',
                                    'form'
                                ),
                                new AnnotationParameter(
                                    'name',
                                    'clientCode'
                                ),
                                new AnnotationParameter(
                                    'displayName',
                                    'Client code'
                                ),
                                new AnnotationParameter(
                                    'description',
                                    'Code identifying the client'
                                ),
                                new AnnotationParameter(
                                    'type',
                                    'string'
                                ),
                                new AnnotationParameter(
                                    'pattern',
                                    '^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$'
                                ),
                                new AnnotationParameter(
                                    'required',
                                    'true'
                                ),
                                new AnnotationParameter(
                                    'example',
                                    '7e2c20d3-6500-497c-83f1-76c64de3bb02'
                                )
                            ),
                            'key'
                        )
                    ),

                    new Annotation(
                        '\raml\annotations\Parameter',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'parameterType',
                                    'form'
                                ),
                                new AnnotationParameter(
                                    'name',
                                    'personBirthdate'
                                ),
                                new AnnotationParameter(
                                    'displayName',
                                    'Person birthday'
                                ),
                                new AnnotationParameter(
                                    'description',
                                    'A person\'s birthdate in the form "YYYY-MM-DD HH:mm:ss".'
                                ),
                                new AnnotationParameter(
                                    'type',
                                    'string'
                                ),
                                new AnnotationParameter(
                                    'pattern',
                                    '^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}-[0-9]{2}-[0-9]{2}$'
                                ),
                                new AnnotationParameter(
                                    'required',
                                    'true'
                                ),
                                new AnnotationParameter(
                                    'example',
                                    '1979-06-19 11:17:00'
                                )
                            ),
                            'key'
                        )
                    ),

                    new Annotation(
                        '\raml\annotations\Response',
                        new AnnotationParameterCollection(
                            array(
                                new AnnotationParameter(
                                    'statusCode',
                                    '200'
                                ),
                                new AnnotationParameter(
                                    'description',
                                    'successfully calculated interpretation'
                                ),
                                new AnnotationParameter(
                                    'contentType',
                                    'application/json'
                                ),
                                new AnnotationParameter(
                                    'schema',
                                    'interpretation-result'
                                ),
                                new AnnotationParameter(
                                    'example',
                                    'interpretation-result-example'
                                )
                            ),
                            'key'
                        )
                    )
                )//,
                //'name'
            )
        );

        $this->assertEquals($fileLevelAnnotations, $fileAnnotations->getFileLevel());
        $this->assertEquals($methodsLevelAnnotations, $fileAnnotations->getMethodsLevel());
    }

}
