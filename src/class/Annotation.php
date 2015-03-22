<?php

namespace com\pauldevelop\library\raml;

use Com\PaulDevelop\Library\Common\Base;

class Annotation extends Base
{
    #region member
    /**
     * @var string
     */
    private $name;
    /**
     * @var AnnotationCollection|AnnotationParameterCollection
     */
    private $parameter;
    #endregion

    #region constructor
    /**
     * @param string                        $name
     * @param AnnotationParameterCollection $parameter
     */
    public function __construct($name = '', AnnotationParameterCollection $parameter = null)
    {
        $this->name = $name;
        $this->parameter = $parameter == null ? new AnnotationCollection() : $parameter;
    }
    #endregion

    #region properties
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        $chunks = preg_split('/\\\\/', $this->name);
        return lcfirst(array_pop($chunks));
    }

    /**
     * @return AnnotationCollection|AnnotationParameterCollection
     */
    public function getParameter()
    {
        return $this->parameter;
    }
    #endregion
}
