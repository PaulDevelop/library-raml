<?php

namespace com\pauldevelop\library\raml;

use Com\PaulDevelop\Library\Common\Base;

class FileAnnotations extends Base
{
    #region member
    /**
     * @var AnnotationCollection
     */
    private $fileLevel;

    /**
     * @var AnnotationCollection
     */
    private $classLevel;

    // member

    /**
     * @var array
     */
    private $methodsLevel; // collection of AnnotationCollection

    // properties
    #endregion

    #region constructor
    /**
     * @param AnnotationCollection $fileLevel
     * @param AnnotationCollection $classLevel
     * @param array $methodsLevel
     */
    public function __construct(
        AnnotationCollection $fileLevel = null,
        AnnotationCollection $classLevel = null,
        $methodsLevel = array()
    ) {
        $this->fileLevel = $fileLevel != null ? $fileLevel : new AnnotationCollection();
        $this->classLevel = $classLevel != null ? $classLevel : new AnnotationCollection();
        $this->methodsLevel = $methodsLevel;
    }
    #endregion

    #region properties
    /**
     * @return AnnotationCollection
     */
    public function getFileLevel()
    {
        return $this->fileLevel;
    }

    /**
     * @param AnnotationCollection $value
     */
    public function setFileLevel(AnnotationCollection $value = null)
    {
        $this->fileLevel = $value;
    }

    /**
     * @return AnnotationCollection
     */
    public function getClassLevel()
    {
        return $this->classLevel;
    }

    /**
     * @param AnnotationCollection $value
     */
    public function setClassLevel(AnnotationCollection $value = null)
    {
        $this->classLevel = $value;
    }

    /**
     * @return array
     */
    public function getMethodsLevel()
    {
        return $this->methodsLevel;
    }

    /**
     * @param array $value
     */
    public function setMethodsLevel($value = array())
    {
        $this->methodsLevel = $value;
    }
    #endregion
}
