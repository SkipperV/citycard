<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="APIs For Citycard",
 *    version="1.0.0",
 * ),
 *   @OA\SecurityScheme(
 *       securityScheme="sanctum",
 *       type="http",
 *       scheme="bearer",
 *    ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
