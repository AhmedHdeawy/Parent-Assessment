<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\JsonResponseTrait;
use App\Repositories\V1\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersController extends Controller
{
    use JsonResponseTrait;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Search for hotels in many providers
     *
     * @return JsonResource
     */
    public function index(Request $request)
    {
        // Get Request Date
        $givinData = $request->only(['provider', 'statusCode', 'balanceMin', 'balanceMax', 'currency']);

        $response = $this->userRepository->list($givinData);

        // Return Data with JSON
        return $this->jsonResponse(200, 'Data Retrned Successfully', null, $response);
    }

}
