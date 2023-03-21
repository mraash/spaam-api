<?php

namespace App\Http\Controller;

use App\Domain\Entity\User;
use SymfonyExtension\Http\Controller\AbstractController as BaseController;

class AbstractController extends BaseController
{
    public function getUser(): User
    {
        /** @var User */
        return parent::getUser();
    }

    public function hasUser(): bool
    {
        return parent::getUser() !== null;
    }
}
