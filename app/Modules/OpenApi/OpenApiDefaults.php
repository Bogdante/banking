<?php

namespace App\Modules\OpenApi;

trait OpenApiDefaults
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      x={
     *          "logo": {
     *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
     *          }
     *      },
     *      title="Bank API",
     *      description="Bank OpenApi description",
     *      @OA\Contact(
     *          email="bogdantegiero@gmail.com"
     *      ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     */

    public static function index() {}
}
