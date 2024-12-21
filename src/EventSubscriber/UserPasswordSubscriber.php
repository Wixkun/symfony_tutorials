<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordSubscriber implements EventSubscriber
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->hashPassword($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->hashPassword($args);
    }

    private function hashPassword(LifecycleEventArgs $args): void
{
    $entity = $args->getObject();

    if (!$entity instanceof User) {
        return;
    }

    $plainPassword = $entity->getPlainPassword();
    if ($plainPassword) {
        file_put_contents('var/log/password_subscriber.log', "Hashing password for user: " . $entity->getEmail() . "\n", FILE_APPEND);
        $hashedPassword = $this->passwordHasher->hashPassword($entity, $plainPassword);
        $entity->setPassword($hashedPassword);
        $entity->eraseCredentials();
    }
}


}
