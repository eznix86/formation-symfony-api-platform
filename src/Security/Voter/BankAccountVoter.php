<?php

namespace App\Security\Voter;

use App\Entity\BankAccount;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BankAccountVoter extends Voter
{
    private const UPDATE = 'UPDATE';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::UPDATE])
            && $subject instanceof BankAccount;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var BankAccount $subject */
        return $subject->getReadonly() === false;
    }
}
