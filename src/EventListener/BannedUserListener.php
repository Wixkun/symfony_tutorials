<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BannedUserListener implements EventSubscriberInterface
{
    private Security $security;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $user = $this->security->getUser();

        $request = $event->getRequest();

        if ($request->getPathInfo() === '/banned') {
            return;
        }
        if ($user && in_array('ROLE_BANNED', $user->getRoles(), true)) {
            $response = new RedirectResponse($this->urlGenerator->generate('app_banned'));
            $event->setResponse($response);
        }
    }
}
