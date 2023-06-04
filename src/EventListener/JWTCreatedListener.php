<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTCreatedListener
{
    private ?UserInterface $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();

        if ($this->user instanceof UserInterface && $this->user->getId()) {
            $payload['id'] = $this->user->getId();
            $payload['username'] = $this->user->getUserName();
        } else {
            throw new \LogicException('The security context did not return a UserInterface object.');
        }

        $event->setData($payload);
    }
}
