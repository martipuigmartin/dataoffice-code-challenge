<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private string $environment
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $exception instanceof \Exception && $code = $exception->getCode() ?: 500;
        $exception instanceof HttpException && $code = $exception->getStatusCode();

        $content = [
            'code' => $code ?? 500,
            'message' => $exception->getMessage(),
            'trace' => in_array($this->environment, ['dev', 'test'], true)
                ? $exception->getTrace()
                : [],
        ];

        $event->setResponse(
            new JsonResponse($content, $content['code'])
        );
    }
}
