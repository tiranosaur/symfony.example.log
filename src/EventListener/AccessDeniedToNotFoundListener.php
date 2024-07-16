<?php declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccessDeniedToNotFoundListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AccessDeniedHttpException) {
            $notFoundException = new NotFoundHttpException('(AccessDeniedHttpException) - Page not found', $exception);
            $event->setThrowable($notFoundException);
        }
    }
}
