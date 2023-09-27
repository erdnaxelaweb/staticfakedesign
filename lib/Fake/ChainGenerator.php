<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Fake;


class ChainGenerator
{
    /**
     * @var array<GeneratorInterface>
     */
    protected array $generators = [];

    /**
     * @param iterable<GeneratorInterface> $generators
     */
    public function __construct(
        protected FakerGenerator $fakerGenerator,
        iterable                 $generators = []
    )
    {
        foreach ( $generators as $type => $generator )
        {
            $this->registerGenerator( $type, $generator );
        }
    }

    public function registerGenerator( string $type, GeneratorInterface $generator ): void
    {
        $this->generators[$type] = $generator;
    }


    public function generateFake( string $type, array $parameters = [])
    {
        $generator = $this->generators[$type] ?? [$this->fakerGenerator, $type];

        return call_user_func_array($generator, $parameters);
    }

    public function generateFakeArray( ?int $count, string $type, array $parameters = [] ): array
    {
        $count = $count ?? rand( 1, 10 );
        $values = [];
        for ( $i = 0; $i < $count; ++$i )
        {
            $values[] = $this->generateFake( $type, $parameters );
        }
        return $values;
    }
}
