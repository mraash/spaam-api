<?php

namespace App\Http\Controller;

use App\Domain\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;

class AbstractController extends SymfonyController
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