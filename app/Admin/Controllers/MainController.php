<?php

namespace Admin\Controllers;

use Admin\Controllers\Shared\AdminController;
use Core\Http\Request;
use Core\ServiceContainer;
use Repositories\UserRepository\UserRepository;

class MainController extends AdminController
{
    public function main(Request $request)
    {
        if (!$this->isAuthorized()) {
            $request->redirect('/login');
        }

        /** @var UserRepository $userRepository */
        $userRepository = ServiceContainer::getInstance()->get('user_repository');

        return $this->render([
            'usersCount' => $userRepository->count()
        ]);
    }
}
