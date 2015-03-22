<?php

/**
 * @\raml\annotations\Title(title="Karmap Core API")
 * @\raml\annotations\Version(version="v1")
 * @\raml\annotations\BaseUri(baseUri="https://api.core.karmap.com/{version}")
 * @\raml\annotations\MediaType(mediaType="application/json")
 * @\raml\annotations\Protocol(protocol="HTTPS")
 * @\raml\annotations\SecurityScheme(name="basic", type="Basic Authentication")
 */

/**
 * Class RamlAnnotatedClass
 */
class RamlAnnotatedClass
{
    /**
     * Process request.
     *
     * @\raml\annotations\HttpVerb(verb="POST")
     * @\raml\annotations\Resource(resource="/anonymousInterpretations")
     * @\raml\annotations\Description(description="Create anonymous interpretation")
     * @\raml\annotations\SecuredBy(scheme="basic")
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="clientCode",
     *   displayName="Client code",
     *   description="Code identifying the client",
     *   type="string",
     *   pattern="^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$",
     *   required="true",
     *   example="7e2c20d3-6500-497c-83f1-76c64de3bb02"
     * )
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="personBirthdate",
     *   displayName="Person birthday",
     *   description="A person's birthdate in the form ""YYYY-MM-DD HH:mm:ss"".",
     *   type="string",
     *   pattern="^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}-[0-9]{2}-[0-9]{2}$",
     *   required="true",
     *   example="1979-06-19 11:17:00"
     * )
     */
    public function process()
    {

    }
}