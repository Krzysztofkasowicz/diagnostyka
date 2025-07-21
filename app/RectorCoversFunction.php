<?php

namespace App;

use PhpParser\Node;
use PhpParser\Node\Attribute;
use PhpParser\Node\AttributeGroup;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class RectorCoversFunction extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Convert #[CoversFunction] attribute to #[CoversMethod] with ListCategoriesHandler class',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
#[CoversFunction('handle')]
class SomeTest
{
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
#[CoversMethod(ListCategoriesHandler::class, 'handle')]
class SomeTest
{
}
CODE_SAMPLE
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [AttributeGroup::class];
    }

    /**
     * @param AttributeGroup $node
     */
    public function refactor(Node $node): ?Node
    {
        foreach ($node->attrs as $key => $attribute) {

            if ($attribute->name->name === 'PHPUnit\Framework\Attributes\CoversFunction') {
                $args = $attribute->args;
                if (empty($args) || !$args[0]->value instanceof String_) {
                    continue;
                }

                $methodName = $args[0]->value->value;
                $path = $this->file->getFilePath();
                $fileNameWithExtension = basename($path);
                $className = str_replace('.php', '', $fileNameWithExtension);
                $classConstFetch = new ClassConstFetch(
                    new Name($className),
                    new Identifier('class')
                );

                $newAttribute =  new Attribute(
                    new Name('CoversMethod'),
                    [
                        new Node\Arg($classConstFetch),
                        new Node\Arg(new String_($methodName)),
                    ]
                );
                $node->attrs[$key] = $newAttribute;
            }
        }

        return null;
    }

//    private function isCoversFunctionAttribute(Attribute $attribute): bool
//    {
//        return $this->isName($attribute->name, 'CoversFunction');
//    }
//
//    private function getMethodNameFromAttribute(Attribute $attribute): ?string
//    {
//        if (empty($attribute->args)) {
//            return null;
//        }
//
//        $firstArg = $attribute->args[0];
//        if (!$firstArg->value instanceof String_) {
//            return null;
//        }
//
//        return $firstArg->value->value;
//    }
//
//    private function createCoversMethodAttribute(string $methodName): Attribute
//    {
//        // Create ListCategoriesHandler::class expression
//        $classConstFetch = new ClassConstFetch(
//            new Name('ListCategoriesHandler'),
//            new Identifier('class')
//        );
//
//        // Create method name string
//        $methodNameString = new String_($methodName);
//
//        // Create new CoversMethod attribute
//        return new Attribute(
//            new Name('CoversMethod'),
//            [
//                new Node\Arg($classConstFetch),
//                new Node\Arg($methodNameString),
//            ]
//        );
//    }
}
