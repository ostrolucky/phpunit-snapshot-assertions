<?php

namespace Spatie\Snapshots\Test\Unit\Drivers;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\Drivers\TextDriver;
use Spatie\Snapshots\Exceptions\CantBeSerialized;

class TextDriverTest extends TestCase
{
    /** @test */
    public function it_can_serialize_laravel_route_list()
    {
        $driver = new TextDriver();

        $expected = implode("\n", [
            '',
            '  GET|HEAD       / ..................................................... index',
            '',
            '                                                            Showing [1] routes'
        ]);

        $this->assertEquals($expected, $driver->serialize(<<<EOF

  GET|HEAD       / ..................................................... index

                                                            Showing [1] routes
EOF));
    }

    /** @test */
    public function it_can_serialize_when_given_windows_line_endings()
    {
        $driver = new TextDriver();

        $expected = <<<EOF

  GET|HEAD       / ..................................................... index

                                                            Showing [1] routes
EOF;
        // Due to using PHP_EOL this should fail (conditionally) when run on windows
        $actual = implode(PHP_EOL, [
            '',
            '  GET|HEAD       / ..................................................... index',
            '',
            '                                                            Showing [1] routes'
        ]);

        $this->assertEquals($expected, $driver->serialize($actual));
    }

}
