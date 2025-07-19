<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class UserVoter extends Voter
{
    const VIEW = 'view';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if(!in_array($attribute, [self::VIEW])) {
            return false;
        }

        if(!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $currentUser = $token->getUser();

        if (!$currentUser instanceof User) {
            return false;
        }

        $requestedUser = $subject;

        return match($attribute) {
            self::VIEW => $this->canView($requestedUser, $currentUser),           
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canView(User $requestedUser, User $currentUser): bool
    {
        // Users can view their own profile
        // You could add additional logic here (e.g., admin can view all profiles)
        return $currentUser->getId() === $requestedUser->getId();
    }
}
