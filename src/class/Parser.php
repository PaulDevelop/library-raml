<?php

namespace com\pauldevelop\library\raml;

abstract class Parser
{
    #region methods
    /**
     * @param string $file
     *
     * @return FileAnnotations
     */
    public static function process($file = '')
    {
        return self::parseFile($file);
    }

    /**
     * @param string $file
     *
     * @return FileAnnotations
     */
    private static function parseFile($file = '')
    {
        // init
        $result = new FileAnnotations();

        // action
        $content = file_get_contents($file);
        $content = preg_replace('/\n\s*\*[^\/]/', ' ', $content);
        $content = preg_replace('/\s{2,}/', ' ', $content);

        // remove * at beginning of new line


        $classLevelDocblock = '';
        if (preg_match_all('#/\*\*((?:(?!\*/).)+)\*/\s*(?:public\s+|private\s+|protected\s+)?class#', $content,
            $matches)) { // public, private, protected, abstract
            foreach ($matches[1] as $docblock) { // TODO only one!! replace loop with direct array access
                $annotations = self::parseDocblock($docblock);
                $classLevelDocblock = $docblock;
                $result->setClassLevel($annotations);
            }
        }

        // file-level
        if (preg_match_all('/\/\*\*(.*?)\*\//', $content, $matches)) {
            // take first and check, if it's not the same as the class docblock
            $potentialFileLevelDocblock = $matches[1][0];
            if ($potentialFileLevelDocblock == $classLevelDocblock) {
                $potentialFileLevelDocblock = '';
                //echo "Sorry, no file level docblock available.".PHP_EOL;
            } else {
                $annotations = self::parseDocblock($potentialFileLevelDocblock);
                $result->setFileLevel($annotations);
            }

        }

//        // member-level
//        if (preg_match_all('/\/\*\*(.*?)\*\/\s*(?:public|private|protected)\s+\$/', $content, $matches)) {
//            $annotationArray = array();
//            foreach ($matches[1] as $docblock) {
//                $annotations = self::parseDocblock($docblock);
//                array_push($annotationArray, $annotations);
//                //$result->setMembersLevel($annotationArray);
//            }
//        }

        // method-level
        if (preg_match_all(
            '#/\*\*((?:(?!\*/).)+)\*/\s*(?:public|private|protected)\s*function\s+(?:(?!get|set).)#',
            $content,
            $matches
        )) { // public, private, protected, abstract
            $annotationArray = array();
            foreach ($matches[1] as $docblock) {
                array_push($annotationArray, self::parseDocblock($docblock));
            }
            $result->setMethodsLevel($annotationArray);
        }

//        // property-level
//        if (preg_match_all('#/\*\*((?:(?!\*/).)+)\*/\s*(?:public|private|protected)\s*function\s+(?:get|set)#',
//            $content,
//            $matches)) { // public, private, protected, abstract
//            $annotationArray = array();
//            foreach ($matches[1] as $docblock) {
//                $annotations = self::parseDocblock($docblock);
//                array_push($annotationArray, $annotations);
//                //$result->setPropertiesLevel($annotationArray);
//            }
//        }

        // return
        return $result;
    }

    /**
     * @param string $docblock
     *
     * @return AnnotationCollection
     */
    private static function parseDocblock($docblock = '')
    {
        //echo $docblock.PHP_EOL;
        // init
        $result = new AnnotationCollection();

        $debug = false;

        // config
        $ramlNamespace = '\raml\annotations';

        // action
        $annotationIsOpen = false;
        $annotationNameIsOpen = false;
        $annotationParameterIsOpen = false;
        $currentAnnotationName = '';
        $parameterKeyIsOpen = false;
        $parameterValueIsOpen = false;
        $parameterValueStringIsOpen = false;
        $currentParameterKey = '';
        $currentParameterValue = '';

        $parameter = new AnnotationParameterCollection();

        for ($i = 0; $i < strlen($docblock); $i++) {
            $currentChar = $docblock[$i];

            $previousChar = $i - 1 >= 0 ? $docblock[$i - 1] : '';
            $nextChar = $i + 1 < strlen($docblock) ? $docblock[$i + 1] : '';

            if (!$annotationIsOpen && $currentChar == '@') {
                // check, if @ is followed by raml namespace
                if ($i + strlen($ramlNamespace) < strlen($docblock) && substr($docblock, $i + 1,
                        strlen($ramlNamespace)) == $ramlNamespace
                ) {
                    echo $debug ? 'start reading annotation'.PHP_EOL : '';
                    $annotationIsOpen = true;
                    echo $debug ? '  start reading annotation name'.PHP_EOL : '';
                    $annotationNameIsOpen = true;
                    continue;
                }
            } else {

                if ($annotationNameIsOpen) {
                    if ($currentChar == '(') {
                        echo $debug ? '  stop reading annotation name: '.$currentAnnotationName.PHP_EOL : '';
                        $annotationNameIsOpen = false;
                        echo $debug ? '  start reading annotation parameter'.PHP_EOL : '';
                        $annotationParameterIsOpen = true;
                        echo $debug ? '    start reading annotation parameter key'.PHP_EOL : '';
                        $parameterKeyIsOpen = true;
                        continue;
                    } else {
                        $currentAnnotationName .= $currentChar;
                    }
                }

                if ($annotationParameterIsOpen) {
                    if ($parameterKeyIsOpen) {
                        if ($currentChar == '=') {
                            $currentParameterKey = trim($currentParameterKey); // TODO if parameter section is open, wait until !\s comes to first start key, then value
                            echo $debug ? '    stop reading annotation parameter key: '.$currentParameterKey.PHP_EOL : '';
                            $parameterKeyIsOpen = false;
                            echo $debug ? '    start reading annotation parameter value'.PHP_EOL : '';
                            $parameterValueIsOpen = true;
                            continue;
                        } else {
                            $currentParameterKey .= $currentChar;
                        }
                    }

                    if ($parameterValueIsOpen) {
                        if ($currentChar == '"') {

                            // masked quotation mark
                            if ( $nextChar == '"' ) {
                                $currentParameterValue .= '"';
                                $i+=1; // step 2 positions forward
                                continue;
                            }

                            $parameterValueStringIsOpen = !$parameterValueStringIsOpen;

                            if (!$parameterValueStringIsOpen) {
                                echo $debug ? '    stop reading annotation parameter value (string): '.$currentParameterValue.PHP_EOL : '';
                                // parameter is finished
                                $parameterValueStringIsOpen = false;
                                $parameterValueIsOpen = false;
                                $parameter->add(
                                    new AnnotationParameter($currentParameterKey, $currentParameterValue),
                                    $currentParameterKey
                                );

                                // clear
                                $currentParameterKey = '';
                                $currentParameterValue = '';
                                continue;
                            } else {
                                echo $debug ? '    start reading annotation parameter value (string)'.PHP_EOL : '';
                                $parameterValueStringIsOpen = true;
                                continue;
                            }

                        }

                        if (!$parameterValueStringIsOpen) {
                            if ($currentChar == ' ' || $currentChar == ')') {
                                echo $debug ? '    stop reading annotation parameter value: '.$currentParameterValue.PHP_EOL : '';
                                $parameterValueIsOpen = false;
                                $parameter->add(
                                    new AnnotationParameter($currentParameterKey, $currentParameterValue),
                                    $currentParameterKey
                                );

                                // clear
                                $currentParameterKey = '';
                                $currentParameterValue = '';

                                if ($currentChar == ')') {
                                    // complete attribute seems to be finished
                                    echo $debug ? '    stop reading annotation parameter'.PHP_EOL : '';
                                    $annotationParameterIsOpen = false;
                                    echo $debug ? 'stop reading annotation: '.$currentAnnotationName.PHP_EOL : '';
                                    $annotationIsOpen = false;
                                    $result->add(
                                        new Annotation($currentAnnotationName, $parameter)
                                    //$currentAnnotationName
                                    );
                                    $currentAnnotationName = '';
                                    $parameter = new AnnotationParameterCollection();
                                }
                            }
                        }

                        $currentParameterValue .= $currentChar;
                    } else {
                        if (!$parameterKeyIsOpen && $currentChar != ' ') {
                            echo $debug ? '    start reading annotation parameter key'.PHP_EOL : '';
                            $parameterKeyIsOpen = true;
                        }

                        if ($currentChar == ')') {
                            echo $debug ? '    stop reading annotation parameter'.PHP_EOL : '';
                            $annotationParameterIsOpen = false;
                            echo $debug ? 'stop reading annotation: '.$currentAnnotationName.PHP_EOL : '';
                            $annotationIsOpen = false;

                            // complete attribute seems to be finished
                            $result->add(
                                new Annotation($currentAnnotationName, $parameter)
                            //$currentAnnotationName
                            );
                            $currentAnnotationName = '';
                            $parameter = new AnnotationParameterCollection();
                        }
                    }
                }
            }
        }

        // return
        return $result;
    }
    #endregion
}
