<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;
//use OpenApi\Annotations as OA;
/**
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth",
 * )
 */


/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="My Laravel API Documentation",
 *     description="Detailed description of my API endpoints",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     )
 * )
 */


#[OA\Info(title: "My Laravel API Documentation", version: "1.0.0")]
abstract class Controller
{
    //
    /**
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )
     */
}
