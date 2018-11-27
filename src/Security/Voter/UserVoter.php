<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserVoter
 * @package App\Security\Voter
 */
class UserVoter extends Voter
{
    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['ROLE_EDITOR_USER', 'ROLE_MANAGER_USER']) && $subject instanceof User;
    }

    /**
     * @param $attribute
     * @param $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'ROLE_EDITOR_USER':
                return $this->canEdit($subject, $token);
            case 'ROLE_MANAGER_USER':
                return $this->canManage($subject, $token);
        }

        return false;
    }

    /**
     * @param $subject
     * @param TokenInterface $token
     * @return bool|null
     */
    protected function canEdit($subject, TokenInterface $token): ?bool
    {
        /** @var User $subject */
        return $subject->getId() === $token->getUser()->getId();
    }

    /**
     * @param $subject
     * @param TokenInterface $token
     * @return bool|null
     */
    protected function canManage($subject, TokenInterface $token): ?bool
    {
        /** @var User $subject */
        return $subject->getId() === $token->getUser()->getId();
    }
}
