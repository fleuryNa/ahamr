<?php
namespace Modules\Infrastructure\Controllers;

use App\Controllers\BaseController;

class Infrastructure extends BaseController
{
    public function index()
    {
        //
        return view('Modules\Infrastructure\Views\InfrastructureView');
    }
}
