<?php

use PhpUnit\Framework\TestCase;

class GetUniqueFirstLettersTest extends TestCase
{

    protected function setUp(): void
    {

    }

    /**
     * @dataProvider firstTestDataProvider
     */
    public function testFirst($airports, $expected)
    {
        $this->assertEquals($expected, implode(' ', getUniqueFirstLetters($airports)));
    }

    public function firstTestDataProvider(): array
    {
        return [
            [
                [
                    [
                        "name" => "Albuquerque Sunport International Airport",
                        "code" => "ABQ",
                        "city" => "Albuquerque",
                        "state" => "New Mexico",
                        "address" => "2200 Sunport Blvd, Albuquerque, NM 87106, USA",
                        "timezone" => "America/Los_Angeles",
                    ],
                    [
                        "name" => "Atlanta Hartsfield International Airport",
                        "code" => "ATL",
                        "city" => "Atlanta",
                        "state" => "Georgia",
                        "address" => "6000 N Terminal Pkwy, Atlanta, GA 30320, USA",
                        "timezone" => "America/New_York",
                    ],
                    [
                        "name" => "Austin Bergstrom International Airport",
                        "code" => "AUS",
                        "city" => "Austin",
                        "state" => "Texas",
                        "address" => "3600 Presidential Blvd, Austin, TX 78719, USA",
                        "timezone" => "America/Los_Angeles",
                    ],
                    [
                        "name" => "Nashville Metropolitan Airport 1",
                        "code" => "BNA",
                        "city" => "Nashville",
                        "state" => "Tennessee",
                        "address" => "1 Terminal Dr, Nashville, TN 37214, USA",
                        "timezone" => "America/Chicago",
                    ],
                    [
                        "name" => "Boise Airport",
                        "code" => "BOI",
                        "city" => "Boise",
                        "state" => "Idaho",
                        "address" => "3201 W Airport Way #1000, Boise, ID 83705, USA",
                        "timezone" => "America/Denver",
                    ]
                ], 'A B N'
            ],
            [ require 'src/web/airports.php', 'A B C D E F G H I J K L M N O P Q R S T U V W Y']
        ];
    }

}
