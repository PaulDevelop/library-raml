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
 * @\raml\annotations\Title(title="B CLASS LEVEL")
 */
class AClassB {
    #region member
    /**
     * @\raml\annotations\Title(title="B MEMBER LEVEL 1")
     */
    private $aMember1;

    /**
     * @\raml\annotations\Title(title="B MEMBER LEVEL 2")
     */
    private $aMember2;
    #endregion

    #region constructor
    #endregion

    #region methods
    /**
     * @\raml\annotations\Resource(resource="/personalizedInterpretation")
     * @\raml\annotations\HttpVerb(verb="POST")
     * @\raml\annotations\Description(description="Calculate personalized interpretation")
     * @\raml\annotations\SecuredBy(scheme="basic")
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="clientCode",
     *   displayName="Client code",
     *   description="Code identifying the client",
     *   type="string",
     *   pattern="^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$",
     *   required="true",
     *   example="b4762505-b108-46a0-a4c7-f79c4b224b58"
     * )
     */
    public function aMethod1() {

    }

    /**
     * @\raml\annotations\Title(title="B METHOD LEVEL 2")
     */
    public function aMethod2() {

    }
    #endregion

    #region properties
    /**
     * @\raml\annotations\Title(title="B PROPERTY LEVEL 1 (getter)")
     */
    public function getAMember1() {
        return $this->aMember1;
    }

    /**
     * @\raml\annotations\Title(title="B PROPERTY LEVEL 1 (setter)")
     */
    public function setAMember1($value = '') {
        $this->aMember1 = $value;
    }

    /**
     * @\raml\annotations\Title(title="B PROPERTY LEVEL 2 (getter)")
     */
    public function getAMember2() {
        return $this->aMember2;
    }

    /**
     * @\raml\annotations\Title(title="B PROPERTY LEVEL 2 (setter)")
     */
    public function setAMember2($value = '') {
        $this->aMember2 = $value;
    }
    #endregion
}
