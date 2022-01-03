<?php

namespace ArtARTs36\Str\Docs;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;

class ExampleBuilder
{
    private $dir;

    private $suffix;

    private $namespace;

    public function __construct(string $dir, string $suffix, string $namespace)
    {
        $this->dir = $dir;
        $this->suffix = $suffix;
        $this->namespace = $namespace;
    }

    /**
     * @return array<class-string, Example[]>
     */
    public function build(): array
    {
        $files = glob($this->dir . '/*' . $this->suffix . '.php');
        $examples = [];
        $docBlockFactory = DocBlockFactory::createInstance();

        foreach ($files as $file) {
            $className = basename($file, '.php');
            $classFullName = $this->namespace . $className;
            $reflector = new \ReflectionClass($classFullName);
            $testInstance = $reflector->newInstance();

            foreach ($reflector->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->getDocComment() === false) {
                    continue;
                }

                $docBlock = $docBlockFactory->create($method->getDocComment());

                $dataMethod = $this->getDataProviderMethodName($docBlock);

                if ($dataMethod === null) {
                    continue;
                }

                [$coversClass, $coversMethod] = $this->getClassAndMethod($docBlock);

                if ($coversMethod === null) {
                    continue;
                }

                $testSet = $testInstance->$dataMethod()[0];

                $examples[] = new Example(
                    $coversClass,
                    $coversMethod,
                    array_slice($testSet, 0, -1),
                    end($testSet)
                );
            }
        }

        return $examples;
    }

    private function getDataProviderMethodName(DocBlock $block): ?string
    {
        return $block->getTagsByName('dataProvider')[0] ?? null;
    }

    /**
     * @param DocBlock $block
     * @return array<string, string>
     */
    private function getClassAndMethod(DocBlock $block): array
    {
        $tags = $block->getTagsByName('covers');

        if (! array_key_exists(0, $tags)) {
            return [null, null];
        }

        return explode('::', $tags[0]->getReference());
    }
}
