<?php

namespace App\Http\Controllers;

use App\Events\RegistrationUpdated;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        RegistrationUpdated::dispatch(1, 25);
        return '';
    }
}
