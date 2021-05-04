<?php

namespace ArtARTs36\Str\Tests;

use ArtARTs36\Str\Str;
use ArtARTs36\Str\StrCollection;
use PHPUnit\Framework\TestCase;

class StrCollectionTest extends TestCase
{
    /**
     * @covers \ArtARTs36\Str\StrCollection::isEmpty
     */
    public function testIsEmpty(): void
    {
        self::assertTrue((new StrCollection([]))->isEmpty());
        self::assertFalse((new StrCollection([Str::random()]))->isEmpty());
    }

    /**
     * @covers \ArtARTs36\Str\StrCollection::isNotEmpty
     */
    public function testIsNotEmpty(): void
    {
        self::assertFalse((new StrCollection([]))->isNotEmpty());
        self::assertTrue((new StrCollection([Str::random()]))->isNotEmpty());
    }

    /**
     * @covers \ArtARTs36\Str\StrCollection::getIterator
     */
    public function testGetIterator(): void
    {
        self::assertEquals([], (new StrCollection([]))->getIterator()->getArrayCopy());
    }

    /**
     * @covers \ArtARTs36\Str\StrCollection::count
     */
    public function testCount(): void
    {
        self::assertEquals(0, (new StrCollection([]))->count());
        self::assertCount(0, (new StrCollection([])));

        self::assertEquals(1, (new StrCollection([Str::random()]))->count());
        self::assertCount(1, (new StrCollection([Str::random()])));
    }

    /**
     * @covers \ArtARTs36\Str\StrCollection::implode
     */
    public function testImplode(): void
    {
        $strings = [Str::make('Hello'), Str::make('Dev')];

        self::assertEquals('Hello Dev', (new StrCollection($strings))->implode(' '));
    }
}
