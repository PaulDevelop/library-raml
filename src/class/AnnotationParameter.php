<?php

namespace com\pauldevelop\library\raml;

use Com\PaulDevelop\Library\Common\Base;

class AnnotationParameter extends Base {
    #region member
    private $key;
    private $value;
    #endregion

    #region constructor
    public function __construct($key = '', $value = '')
    {
        $this->key = $key;
        $this->value = $value;
    }
    #endregion

    #region properties
    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }
    #endregion
}