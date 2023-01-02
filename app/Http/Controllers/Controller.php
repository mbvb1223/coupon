<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\OpenApi(
 *  @OA\Info(
 *      title="API documents",
 *      version="1.0.0",
 *      description="API documentation for Khien-Test-App",
 *      @OA\Contact(
 *          email="phamkhien@hotmail.com"
 *      )
 *  ),
 *  @OA\Server(
 *      description="Server",
 *      url="http://localhost:8000/api"
 *  ),
 *  @OA\PathItem(
 *      path="/api"
 *  )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
