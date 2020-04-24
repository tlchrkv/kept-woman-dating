<?php

namespace Admin\Controllers;

use Admin\Controllers\Shared\AdminController;
use Core\Controllers\IProtected;

class LogController extends AdminController implements IProtected
{
    public function getProtectedMethods()
    {
        return ['all'];
    }

    public function all()
    {
        return $this->render();
    }
}