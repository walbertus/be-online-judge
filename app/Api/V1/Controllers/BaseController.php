<?php

namespace App\Api\V1\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use ValidatesRequests, Helpers;
}
