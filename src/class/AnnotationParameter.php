<?php

namespace com\pauldevelop\library\raml;

use Com\PaulDevelop\Library\Common\Base;

class AnnotationParameter extends Base
{
    #region member
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $value;
    #endregion

    #region constructor
    /**
     * @param string $key
     * @param string $value
     */
    public function __construct($key = '', $value = '')
    {
        $this->key = $key;
        $this->value = $value;
    }
    #endregion

    #region properties
    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    #endregion
}