# library-raml
Generate RAML documents from annotated php source files.

[RAML](http://raml.org/) is a modeling language for describing RESTful APIs and is a supplementary document that comes 
alongside the API. To avoid a drifting apart of the implementation and it's documentation over time this library
provides the ability to generate RAML documents based on the annotated source code files implementing the API.
 
This does not solve the problem completely, because the annotations need to be kept up to date as well. In return they
are "nearer" coupled with the code and located in the same file, which hopefully makes it more likely for them to get 
updated at all.

## Usage
The process of generating RAML documents consists of two processes: First, the parsing of source code files and looking
for suitable annotations in file- and method-level docblocks. Secondly, the creation of a new RAML document based on the
data the parser found in the source code files.

### Parsing
To find relevant RAML annotations in source files, use the [Parser](src/class/Parser.php) class to have them parsed.
 
```php
$annotations = Parser::process(
    '/path/to/class.php'
);
```

The *process* method returns a [FileAnnotations](src/class/FileAnnotations.php) object, which returns the annotations
in docblocks on file-, class-, member-, method- and property-level.

Supported annotations on file-level are:

- Title
  
    The title of the REST API. The title annotation is also used to merge related source files, which is necessary if
     the code which implements the API is organized in multiple files.

- Version

    The version of the REST API.
    
- BaseUri

    The base URI, where all resource request are based on. May contain variable parts like they are documented in the
    RAML specification, e. g. "https://api.example.com/{version}".
    
- MediaType

    The media type, the response is encoded, e. g. "application/json".
    
- Protocol

    The protocol that is used to access the API, e. g "HTTPS".
    
- SecurityScheme

    name="basic", type="Basic Authentication"
    
An example of a file-level docblock containing RAML specific annotations:

```php
/**
 * @\raml\annotations\Title(title="Karmap Core API")
 * @\raml\annotations\Version(version="v1")
 * @\raml\annotations\BaseUri(baseUri="https://api.core.karmap.com/{version}")
 * @\raml\annotations\MediaType(mediaType="application/json")
 * @\raml\annotations\Protocol(protocol="HTTPS")
 * @\raml\annotations\SecurityScheme(name="basic", type="Basic Authentication")
 */
```

### Generating
To generate a RAML document, use the [Generator](src/class/Generator.php) class.