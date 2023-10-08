<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Service;

use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\ArgumentInterface;
use Overblog\GraphQLBundle\Resolver\ResolverMap;

final class CardResolver extends ResolverMap
{
    public function __construct(
        private readonly CardQuery $queryService,
        private readonly CardCommand $commandService
    ) {
    }

    protected function map(): array
    {
        return [
            'Query' => [
                self::RESOLVE_FIELD => function (
                    mixed $value,
                    ArgumentInterface $args,
                    \ArrayObject $context,
                    ResolveInfo $info
                ) {
                    return match ($info->fieldName) {
                        'getCard' => $this->queryService->getCard((int) $args['cardId']),
                        'getCardCollection' => $this->queryService->getCardCollection(
                            empty($args['filter']) ? null : (string) $args['filter'],
                            (int) ($args['page'] ?? 1),
                            (int) ($args['limit'] ?? 10)
                        ),
                        default => null
                    };
                },
            ],
            'Mutation' => [
                self::RESOLVE_FIELD => function (
                    mixed $value,
                    ArgumentInterface $args,
                    \ArrayObject $context,
                    ResolveInfo $info
                ) {
                    return match ($info->fieldName) {
                        'putCard' => $this->commandService->putCard((int) $args['cardId'], $args['text'] ?? null),
                        default => null
                    };
                },
            ],
        ];
    }
}
