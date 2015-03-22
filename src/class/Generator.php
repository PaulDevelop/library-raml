<?php

namespace com\pauldevelop\library\raml;

class Generator
{
    #region methods
    /**
     * @param string $apiTitle
     * @param string $directoryToScan
     * @param bool   $recursion
     *
     * @return array
     * @throws \Com\PaulDevelop\Library\Common\ArgumentException
     * @throws \Com\PaulDevelop\Library\Common\TypeCheckException
     */
    public function process($apiTitle = '', $directoryToScan = '', $recursion = true)
    {
        // action
        $ramlDocument = '#%RAML 0.8'.PHP_EOL;

        $isFirst = true;
        $fileList = self::getFiles($directoryToScan, $recursion);
        foreach ($fileList as $file) {
            $fileAnnotations = Parser::process($file);
            if (($titleAnnotation = self::findAnnotation($fileAnnotations->getFileLevel(), 'title')) !== null
                && $titleAnnotation->getParameter()['title']->getValue() != $apiTitle
            ) {
                continue;
            }

            if ($isFirst) {
                $isFirst = false;

                $fileLevelAnnotations = $fileAnnotations->getFileLevel();

                // title
                if (($annotation = $this->findAnnotation($fileLevelAnnotations, 'title')) !== null) {
                    $ramlDocument .= self::stringifySimpleAnnotation($annotation);
                }

                // version
                if (($annotation = $this->findAnnotation($fileLevelAnnotations, 'version')) !== null) {
                    $ramlDocument .= self::stringifySimpleAnnotation($annotation);
                }

                // base uri
                if (($annotation = $this->findAnnotation($fileLevelAnnotations, 'baseUri')) !== null) {
                    $ramlDocument .= self::stringifySimpleAnnotation($annotation);
                }

                // protocols
                if (count($annotations = $this->findAnnotations($fileLevelAnnotations, 'protocol')) > 0) {
                    $ramlDocument .= 'protocols: [';
                    $protocolString = '';
                    /** @var Annotation $annotation */
                    foreach ($annotations as $annotation) {
                        $protocolString .= ($protocolString != '' ? ', ' : '').$annotation->getParameter()['protocol']->getValue();
                    }
                    $ramlDocument .= $protocolString.']'.PHP_EOL;
                }

                // security schemes
                if (count($annotations = $this->findAnnotations($fileLevelAnnotations, 'securityScheme')) > 0) {
                    $ramlDocument .= 'securitySchemes:'.PHP_EOL;

                    /** @var Annotation $annotation */
                    foreach ($annotations as $annotation) {
                        $ramlDocument .= '  - '.$annotation->getParameter()['name']->getValue().PHP_EOL;
                        $ramlDocument .= '      type: '.$annotation->getParameter()['type']->getValue().PHP_EOL;
                    }
                }
            }

            /** @var AnnotationCollection $annotations */
            foreach ($fileAnnotations->getMethodsLevel() as $methodAnnotations) {
                $ramlDocument .= PHP_EOL;

                // resource
                if (($annotation = $this->findAnnotation($methodAnnotations, 'resource')) !== null) {
                    $ramlDocument .= $annotation->getParameter()['resource']->getValue().':'.PHP_EOL;
                }

                // http verb
                $httpVerb = 'GET';
                if (($annotation = $this->findAnnotation($methodAnnotations, 'httpVerb')) !== null) {
                    $httpVerb = $annotation->getParameter()['verb']->getValue();
                    $ramlDocument .= '  '.strtolower($annotation->getParameter()['verb']->getValue()).':'.PHP_EOL;
                }

                // description
                if (($annotation = $this->findAnnotation($methodAnnotations, 'description')) !== null) {
                    $ramlDocument .= '    description: '.$annotation->getParameter()['description']->getValue().PHP_EOL;
                }

                // secured by
                if (count($annotations = $this->findAnnotations($methodAnnotations, 'securedBy')) > 0) {
                    $ramlDocument .= '    securedBy: [';
                    $securedByString = '';
                    /** @var Annotation $annotation */
                    foreach ($annotations as $annotation) {
                        $securedByString .= ($securedByString != '' ? ', ' : '').$annotation->getParameter()['scheme']->getValue();
                    }
                    $ramlDocument .= $securedByString.']'.PHP_EOL;
                }

                if ($httpVerb == 'GET') {
                    // foreach parameter
                    if (count($annotations = $this->findAnnotations($methodAnnotations, 'parameter')) > 0) {
                        $ramlDocument .= '    queryParameters:'.PHP_EOL;
                        /** @var Annotation $annotation */
                        foreach ($annotations as $annotation) {
                            $ramlDocument .= '      '.$annotation->getParameter()['name']->getValue().':'.PHP_EOL;
                            $ramlDocument .= '        displayName: '.$annotation->getParameter()['displayName']->getValue().PHP_EOL;
                            $ramlDocument .= '        description: '.$annotation->getParameter()['description']->getValue().PHP_EOL;
                            $ramlDocument .= '        type: '.$annotation->getParameter()['type']->getValue().PHP_EOL;
                            $ramlDocument .= '        pattern: '.$annotation->getParameter()['pattern']->getValue().PHP_EOL;
                            $ramlDocument .= '        required: '.$annotation->getParameter()['required']->getValue().PHP_EOL;
                            $ramlDocument .= '        example: '.$annotation->getParameter()['example']->getValue().PHP_EOL;

                            // display name
                            if (($parameter = $annotation->getParameter()['displayName']) != null) {
                                /** @var AnnotationParameter $parameter */
                                $ramlDocument .= '        displayName: '.$parameter->getValue().PHP_EOL;
                            }

                            // description
                            if (($parameter = $annotation->getParameter()['description']) != null) {
                                /** @var AnnotationParameter $parameter */
                                $ramlDocument .= '        description: '.$parameter->getValue().PHP_EOL;
                            }

                            // type
                            if (($parameter = $annotation->getParameter()['type']) != null) {
                                /** @var AnnotationParameter $parameter */
                                $ramlDocument .= '        type: '.$parameter->getValue().PHP_EOL;
                            }

                            // pattern
                            if (($parameter = $annotation->getParameter()['pattern']) != null) {
                                /** @var AnnotationParameter $parameter */
                                $ramlDocument .= '        pattern: '.$parameter->getValue().PHP_EOL;
                            }

                            // required
                            if (($parameter = $annotation->getParameter()['required']) != null) {
                                /** @var AnnotationParameter $parameter */
                                $ramlDocument .= '        required: '.$parameter->getValue().PHP_EOL;
                            }

                            // example
                            if (($parameter = $annotation->getParameter()['example']) != null) {
                                /** @var AnnotationParameter $parameter */
                                $ramlDocument .= '        example: '.$parameter->getValue().PHP_EOL;
                            }
                        }
                    }
                } else {
                    if ($httpVerb == 'POST') {
                        $ramlDocument .= '    body:'.PHP_EOL;
                        $ramlDocument .= '      application/x-www-form-urlencoded:'.PHP_EOL;
                        $ramlDocument .= '        formParameter:'.PHP_EOL;

                        // foreach parameter
                        if (count($annotations = $this->findAnnotations($methodAnnotations, 'parameter')) > 0) {
                            /** @var Annotation $annotation */
                            foreach ($annotations as $annotation) {
                                $ramlDocument .= '          '.$annotation->getParameter()['name']->getValue().':'.PHP_EOL;

                                // display name
                                if (($parameter = $annotation->getParameter()['displayName']) != null) {
                                    /** @var AnnotationParameter $parameter */
                                    $ramlDocument .= '            displayName: '.$parameter->getValue().PHP_EOL;
                                }

                                // description
                                if (($parameter = $annotation->getParameter()['description']) != null) {
                                    /** @var AnnotationParameter $parameter */
                                    $ramlDocument .= '            description: '.$parameter->getValue().PHP_EOL;
                                }

                                // type
                                if (($parameter = $annotation->getParameter()['type']) != null) {
                                    /** @var AnnotationParameter $parameter */
                                    $ramlDocument .= '            type: '.$parameter->getValue().PHP_EOL;
                                }

                                // pattern
                                if (($parameter = $annotation->getParameter()['pattern']) != null) {
                                    /** @var AnnotationParameter $parameter */
                                    $ramlDocument .= '            pattern: '.$parameter->getValue().PHP_EOL;
                                }

                                // required
                                if (($parameter = $annotation->getParameter()['required']) != null) {
                                    /** @var AnnotationParameter $parameter */
                                    $ramlDocument .= '            required: '.$parameter->getValue().PHP_EOL;
                                }

                                // example
                                if (($parameter = $annotation->getParameter()['example']) != null) {
                                    /** @var AnnotationParameter $parameter */
                                    $ramlDocument .= '            example: '.$parameter->getValue().PHP_EOL;
                                }
                            }
                        }
                    }
                }
            }
        }

        // return
        return $ramlDocument;
    }

    /**
     * @param Annotation $annotation
     *
     * @return string
     */
    private static function stringifySimpleAnnotation(Annotation $annotation = null)
    {
        return $annotation->getShortName().': '.$annotation->getParameter()[$annotation->getShortName()]->getValue().PHP_EOL;
    }

    /**
     * @param AnnotationCollection $annotations
     * @param string               $shortName
     *
     * @return Annotation
     */
    private static function findAnnotation(AnnotationCollection $annotations = null, $shortName = '')
    {
        // init
        $result = null;

        // action
        /** @var Annotation $annotation */
        foreach ($annotations as $annotation) {
            if ($annotation->getShortName() == $shortName) {
                $result = $annotation;
                break;
            }
        }

        // return
        return $result;
    }

    /**
     * @param AnnotationCollection $annotations
     * @param string               $shortName
     *
     * @return AnnotationCollection
     */
    private static function findAnnotations(AnnotationCollection $annotations = null, $shortName = '')
    {
        // init
        $result = new AnnotationCollection();

        // action
        /** @var Annotation $annotation */
        foreach ($annotations as $annotation) {
            if ($annotation->getShortName() == $shortName) {
                $result->add($annotation);
            }
        }

        // return
        return $result;
    }

    /**
     * @param string $directorySource
     * @param bool   $recursive
     *
     * @return array
     */
    private
    static function getFiles(
        $directorySource = '',
        $recursive = true
    ) {
        // init
        $result = array();

        // action
        if ($handle = opendir($directorySource)) {
            while (false !== ($file = readdir($handle))) {
                if (preg_match('/^(.*?)\.php$/', $file, $matches)) {
                    array_push($result, $directorySource.DIRECTORY_SEPARATOR.$file);
                } elseif ($recursive && substr($file, 0,
                        1) != '.' && is_dir($directorySource.DIRECTORY_SEPARATOR.$file)
                ) {
                    $result = array_merge(
                        $result,
                        self::getFiles($directorySource.DIRECTORY_SEPARATOR.$file, $recursive)
                    );
                }
            }
        }

        closedir($handle);

        // return
        return $result;
    }
    #endregion
}
