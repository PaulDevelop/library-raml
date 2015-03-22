<?php

namespace com\pauldevelop\library\raml;

use Com\PaulDevelop\Library\Common\GenericCollection;

class AnnotationCollection extends GenericCollection
{
    public function __construct($initialValues = array(), $keyFieldName = '')
    {
        parent::__construct('com\pauldevelop\library\raml\Annotation', $initialValues, $keyFieldName);
    }
}
