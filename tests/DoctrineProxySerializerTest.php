<?php

namespace App\Tests;

use App\Document\Role;
use App\Document\User;
use PHPUnit\Framework\TestCase;
use ProxyManager\Factory\LazyLoadingGhostFactory;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class DoctrineProxySerializerTest extends TestCase
{
    public function testItSerializesDoctrineProxyObject(): void
    {
        $initializer = \Closure::fromCallable(function (&$wrappedObject, $proxy, $method, $parameters, &$initializer) : bool {
            $wrappedObject = new Role();
            $initializer = null;

            return true;
        });

        $proxyObject = (new LazyLoadingGhostFactory())->createProxy(Role::class, $initializer);

        $user = new User();
        $user->roles[] = $proxyObject;

        $serializer = new Serializer([new ObjectNormalizer(), new PropertyNormalizer(), new GetSetMethodNormalizer()]);

        self::assertIsArray($serializer->normalize($user));
    }
}
