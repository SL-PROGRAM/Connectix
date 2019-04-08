<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class FinancialVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['CAN_FINANCIAL', 'POST_VIEW']);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        foreach ($token->getRoles() as $role) {
            if (in_array($role->getRole(), [
                'FINANCIAL_DIRECTOR',
                'FINANCIAL_MARKETING_DIRECTOR',
                'GENERAL_FINANCIAL_DIRECTOR',
                'PRESIDENT'])) {
                return true;
            }
            return false;
        }
    }
}
