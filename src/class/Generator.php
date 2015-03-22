<?php

namespace com\pauldevelop\library\raml;

class Generator
{
    #region methods
    /**
     * @param string $directoryToScan
     * @param bool   $recursion
     *
     * @return array
     */
    public function process($directoryToScan = '', $recursion = true)
    {
        $groups = array(); // array of FileAnnotationsCollections

        $fileList = self::getFiles($directoryToScan, $recursion);
        foreach ($fileList as $file) {
            $fileAnnotations = Parser::process($file);

            // check file level annotations and build groups
//            if (count($groups) == 0) { // if no grop exists yet
//                // create file annotation collection and add file annotation
//                array_push(
//                    $groups,
//                    new FileAnnotationsCollection(
//                        array(
//                            $fileAnnotations
//                        )
//                    )
//                );
//            } else {
//            $found = false;
//            if (count($groups) == 0) {
//                array_push(
//                    $groups,
//                    new FileAnnotationsCollection(
//                        array(
//                            $fileAnnotations
//                        ))
//                );
//            } else {
            $found = false;
            /** @var FileAnnotationsCollection $group */
            foreach ($groups as $group) {
                /** @var FileAnnotations $firstFileAnnotations */
                //$firstFileAnnotations = $group->getIterator()->getArrayCopy()[0]->getFileLevel();
                $firstTitle = self::findAnnotation($group->getIterator()->getArrayCopy()[0]->getFileLevel(),
                    'title')->getParameter()['title']->getValue();
                //$title = $firstTitle->getParameter()['title']->getValue();

                $title = self::findAnnotation($fileAnnotations->getFileLevel(),
                    'title')->getParameter()['title']->getValue();

                if ($firstTitle == $title) {
                    $group->add($fileAnnotations);
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                array_push(
                    $groups,
                    new FileAnnotationsCollection(
                        array(
                            $fileAnnotations
                        ))
                );
            }

//            }
        }


////
////
////                // hack! take first in group and get title
//                /** @var FileAnnotations $firstFileAnnotations */
//                $firstFileAnnotations = $group->getIterator()->getArrayCopy()[0];
//
//
//                $annotationCollectionSimilar = true;
//
//                /** @var Annotation $annotationA */
//                foreach ($firstFileAnnotations->getFileLevel() as $annotationA) {
//
//                    echo $annotationA->getShortName().PHP_EOL;
//
//                    $annotations = self::findAnnotations($fileAnnotations->getFileLevel(), $annotationA->getShortName());
//                    // is there a least one annotation with parameters like annotationA
//                    // => must not necessarily contain every parameter like annotationA, but if a parameter
//                    //    also exists in annotationB, it mustn't have different values
//                    $annotationSimilar = true;
//                    /** @var Annotation $annotationB */
//                    foreach ($annotations as $annotationB) {
//
//
//                        $parameterSimilar = true;
//
//                        /** @var AnnotationParameter $parameterA */
//                        foreach ($annotationA->getParameter() as $parameterA) {
//                            echo '  A: '.$parameterA->getKey().' ['.$parameterA->getValue().']'.PHP_EOL;
//
//                            /** @var AnnotationParameter $parameterB */
//                            if (($parameterB = $annotationB->getParameter()[$parameterA->getKey()]) != null) {
//                                echo '  B: '.$parameterB->getKey().' ['.$parameterB->getValue().']'.PHP_EOL;
//
//                                if ($parameterA->getValue() != $parameterB->getValue()) {
//                                    $parameterSimilar = false;
//                                }
//
//                            }
//
////                            die;
//                        }
//
//                        if (!$parameterSimilar) {
//                            $annotationSimilar = false;
//                        }
//
//                    }
//
//                    if (!$annotationSimilar) {
//                        $annotationCollectionSimilar = false;
//                    }
//                }
//
//                if ( $annotationCollectionSimilar ) {
//                    //$group->add($fileAnnotations);
//                    $found = true;
////                    break;
//                }
////                /** @var Annotation $titleAnnotation */
////                $titleAnnotation = self::findAnnotation($firstFileAnnotations, 'title');
////                //$titleAnnotation->
////
////                // => check, if current file annotations has same file level title annotation
////                //    if yes, put in that group
////                //    if no, check other groups
//
////                /** @var FileAnnotations $fileAnnotationsFromGroup */
////                foreach ($group as $fileAnnotationsFromGroup) {
////                    // check, if file level annotations are identical
////
////
////
//////                    /** @var Annotation $annotationA */
//////                    foreach ($fileAnnotations->getFileLevel() as $annotationA) {
//////                        //echo $annotationA->getName().PHP_EOL;
//////
//////                        /** @var Annotation $annotationB */
//////                        foreach ( $fileAnnotationsFromGroup->getFileLevel() as $annotationB) {
//////
//////                        }
//////                    }
////
////
////                    // this is a hack! as a start, just check the title
////                    $titleAnnotationFromGroup = self::findAnnotation($fileAnnotationsFromGroup->getFileLevel(), 'title');
////                    $titleAnnotation = self::findAnnotation($fileAnnotations->getFileLevel(), 'title');
////                    if ( $titleAnnotationFromGroup == $titleAnnotation ) {
////
////                    }
////
//////                    $tmp = array_diff(
//////                        $fileAnnotations->getFileLevel()->getIterator()->getArrayCopy(),
//////                        $fileAnnotationsFromGroup->getFileLevel()->getIterator()->getArrayCopy()
//////                    );
//////                    var_dump($tmp);
////
////                    die;
////
////                    // if yes, add current fileAnnotations object to this group
////
////                    // if no, search other groups
////                }
//            }
//
//            // if no group was found, add a new group and add the current file annotation object
//            if (!$found) {
//                array_push(
//                    $groups,
//                    new FileAnnotationsCollection(
//                        array(
//                            $fileAnnotations
//                        )
//                    )
//                );
//            }
////            }

        $ramlDocuments = array();

        foreach ($groups as $group) {
            $fileLevelAnnotations = $group->getIterator()->getArrayCopy()[0]->getFileLevel();
            /** @var FileAnnotations $fileAnnotations */
            //$fileAnnotations = $group->getIterator()->getArrayCopy()[0];

            //foreach ($fileList as $file) {
            //    $fileAnnotations = Parser::process($file);

            $ramlDocument = '#%RAML 0.8'.PHP_EOL;

            // title
//            if (($annotation = $this->findAnnotation($fileAnnotations->getFileLevel(), 'title')) !== null) {
            if (($annotation = $this->findAnnotation($fileLevelAnnotations, 'title')) !== null) {
                $ramlDocument .= self::stringifySimpleAnnotation($annotation);
                //var_dump($annotation->getParameter()['title']);die;
//                $ramlDocument .= $annotation->getShortName().'='.$annotation->getParameter()['title']->getValue().PHP_EOL;
            }

            // version
//            if (($annotation = $this->findAnnotation($fileAnnotations->getFileLevel(), 'version')) !== null) {
            if (($annotation = $this->findAnnotation($fileLevelAnnotations, 'version')) !== null) {
                $ramlDocument .= self::stringifySimpleAnnotation($annotation);
            }

            // base uri
//            if (($annotation = $this->findAnnotation($fileAnnotations->getFileLevel(), 'baseUri')) !== null) {
            if (($annotation = $this->findAnnotation($fileLevelAnnotations, 'baseUri')) !== null) {
                $ramlDocument .= self::stringifySimpleAnnotation($annotation);
            }

            // protocols
//            if (count($annotations = $this->findAnnotations($fileAnnotations->getFileLevel(), 'protocol')) > 0) {
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
//            if (count($annotations = $this->findAnnotations($fileAnnotations->getFileLevel(), 'securityScheme')) > 0) {
            if (count($annotations = $this->findAnnotations($fileLevelAnnotations, 'securityScheme')) > 0) {
                $ramlDocument .= 'securitySchemes:'.PHP_EOL;

                /** @var Annotation $annotation */
                foreach ($annotations as $annotation) {
                    $ramlDocument .= '  - '.$annotation->getParameter()['name']->getValue().PHP_EOL;
                    $ramlDocument .= '      type: '.$annotation->getParameter()['type']->getValue().PHP_EOL;
                }
            }


            foreach ($group as $fileAnnotations) {
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


            array_push($ramlDocuments, $ramlDocument);
        }

        // return
        return $ramlDocuments;
    }

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
                $result->add($annotation); //, $annotation->getName());
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
