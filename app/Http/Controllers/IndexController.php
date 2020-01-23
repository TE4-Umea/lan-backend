<?php

namespace App\Http\Controllers;

use App\Events\RegistrationChange;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        RegistrationChange::dispatch(22);
        return 'asd';
    }
}
