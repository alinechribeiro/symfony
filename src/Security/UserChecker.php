<?php
namespace App\Security;

use DateTime;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;

class UserChecker implements UserCheckerInterface 
{
    /**
     * Checks the user account before authentication.
     *
     * @param User $user
     * @throws AccountStatusException
     */
    public function checkPreAuth(UserInterface $user){
        if (null === $user->getBannedUntil()) {
            return;
        }

        $now = new DateTime();

        if ($now < $user->getBannedUntil()) {
            throw new AccessDeniedHttpException('The user is banned');
        }
    }

    /**
     * Checks the user account after authentication.
     *
     * @param User $user
     * @throws AccountStatusException
     */
    public function checkPostAuth(UserInterface $user){}
}