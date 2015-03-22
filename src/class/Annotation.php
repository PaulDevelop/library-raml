<?php

namespace com\pauldevelop\library\raml;

use Com\PaulDevelop\Library\Common\Base;

class Annotation extends Base
{
    #region member
    private $name;
    private $parameter; // collection
    #endregion

    #region constructor
    public function __construct($name = '', $parameter = array())
    {
        $this->name = $name;
        $this->parameter = $parameter;
    }
    #endregion

    #region properties
    public function getName()
    {
        return $this->name;
    }

    public function getShortName()
    {
        $chunks = preg_split('/\\\\/', $this->name);
        return lcfirst(array_pop($chunks));
    }

    public function getParameter()
    {
        return $this->parameter;
    }
    #endregion
}