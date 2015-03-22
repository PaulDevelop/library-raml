<?php

/**
 * @\raml\annotations\Title(title="Karmap Core API")
 * @\raml\annotations\Version(version="v1")
 * @\raml\annotations\BaseUri(baseUri="https://api.core.karmap.com/{version}")
 * @\raml\annotations\MediaType(mediaType="application/json")
 * @\raml\annotations\Protocol(protocol="HTTPS")
 * @\raml\annotations\SecurityScheme(name="basic", type="Basic Authentication")
 */

namespace com\karmap\core\controller\apicore\v1;

/**
 * Class RestAnonymousInterpretationsPostController
 *
 * @package com\karmap\core\controller\apicore\v1
 */
class RestAnonymousInterpretationsPostController
{
    /**
     * @\raml\annotations\Resource(resource="/anonymousInterpretations")
     * @\raml\annotations\HttpVerb(verb="POST")
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
     *   example="b4762505-b108-46a0-a4c7-f79c4b224b58"
     * )
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="partnerCode",
     *   displayName="Partner code",
     *   description="Code identifying the partner",
     *   type="string",
     *   pattern="^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$",
     *   required="true",
     *   example="3df9014e-d4cd-41bc-9087-cf68dd0719cb"
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
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="personBirthplace",
     *   displayName="Person birthplace",
     *   description="The city a person was born.",
     *   type="string",
     *   required="true",
     *   example="Köln (Cologne), Deutschland"
     * )
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="personGmtOffset",
     *   displayName="Person GMT offset",
     *   description="GMT offset of the city's timezone a person was born in the form ""+0100"".",
     *   type="string",
     *   pattern="^[+-][0-9]{4}$",
     *   required="true",
     *   example="+0100"
     * )
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="personLatitude",
     *   displayName="Person latitude",
     *   description="The latitude of the geo coordinates of the city a person was born.",
     *   type="number",
     *   required="true",
     *   example="50.933333"
     * )
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="personLongitude",
     *   displayName="Person longitude",
     *   description="The longitude of the geo coordinates of the city a person was born.",
     *   type="number",
     *   required="true",
     *   example="6.983333"
     * )
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="placeAddress",
     *   displayName="Place address",
     *   description="The address of the place which is to be interpreted.",
     *   type="string",
     *   required="true",
     *   example="Stephanstraße 19, 10559 Berlin"
     * )
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="placeLatitude",
     *   displayName="Place latitude",
     *   description="The latitude of the geo coordinates of the place which is to be interpreted.",
     *   type="number",
     *   required="true",
     *   example="52.534168"
     * )
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="placeLongitude",
     *   displayName="Place longitude",
     *   description="The longitude of the geo coordinates of the place which is to be interpreted.",
     *   type="number",
     *   required="true",
     *   example="13.34902"
     * )
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="level",
     *   displayName="Level",
     *   description="The interpretation level, which indicates the largeness of the place's surrounding area; one out of ""continent"", ""region or part of the country"", ""county or town"", ""surrounding area"", or ""exact adress, microcosm"".",
     *   type="string",
     *   required="true",
     *   example="exact adress, microcosm"
     * )
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="interpretationType",
     *   displayName="Interpretation type",
     *   description="The type of interpretation; one out of ""basic"", ""love"" or ""holiday"".",
     *   type="string",
     *   required="true",
     *   example="basic"
     * )
     * @\raml\annotations\Parameter(
     *   parameterType="form",
     *   name="language",
     *   displayName="Language",
     *   description="The language the interpretation texts appear in the results; one out of ""en"", or ""de"".",
     *   type="string",
     *   required="true",
     *   example="en"
     * )
     */
    public function process()
    {
    }
}
