<?php

namespace com\pauldevelop\library\raml;

use Com\PaulDevelop\Library\Common\GenericCollection;

class FileAnnotationsCollection extends GenericCollection
{
    public function __construct($initialValues = array(), $keyFieldName = '')
    {
        parent::__construct('com\pauldevelop\library\raml\FileAnnotations', $initialValues, $keyFieldName);
    }
}
