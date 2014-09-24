<?php

use AdrecordApiWrapper\Denormalizer;

class DenormalizerTest extends PHPUnit_Framework_TestCase
{
    public function testDenormalizeChannel()
    {
        $channelData = (object) [
            'channelID' => 4,
            'channelName' => 'Hittajulklappar',
            'channelUrl' => 'http://www.hittajulklappar.se',
            'programs' => [
                [
                    'programName' => 'Roliga Prylar',
                    'programID' => 193,
                ],
            ],
        ];

        $channel = (new Denormalizer())->denormalizeChannel($channelData);

        $this->assertInstanceOf('\AdrecordApiWrapper\Channel', $channel);
        $this->assertEquals(4, $channel->getId());
        $this->assertEquals('Hittajulklappar', $channel->getName());
        $this->assertEquals('http://www.hittajulklappar.se', $channel->getUrl());
    }

    public function testDenormalizeChannels()
    {
        $channelData = [(object)[
            'channelID' => 4,
            'channelName' => 'Hittajulklappar',
            'channelUrl' => 'http://www.hittajulklappar.se',
        ]];

        $channels = (new Denormalizer())->denormalizeChannels($channelData);

        $this->assertInstanceOf('\AdrecordApiWrapper\Channel', $channels[0]);
        $this->assertEquals(4, $channels[0]->getId());
        $this->assertEquals('Hittajulklappar', $channels[0]->getName());
        $this->assertEquals('http://www.hittajulklappar.se', $channels[0]->getUrl());
    }

    public function testDenormalizeProgram()
    {

        $json = '
        {
            "status": "OK",
            "result": {
                "id": 43,
                "name": "Blogvertiser",
                "url": "http:\/\/www.blogvertiser.com\/sv\/",
                "description": "Blogvertiser kopplar samman annons\u00f6rer och bloggare i syfte att skapa och sprida information och \u00e5sikter via riktade bloggar och d\u00e4rmed n\u00e5 ut till exakt r\u00e4tt m\u00e5lgrupp. Bloggare, f\u00e5 betalt f\u00f6r att blogga! V\u00e4lkomna att ans\u00f6ka!\n\nDu f\u00e5r betalt f\u00f6r att v\u00e4rva nya bloggare eller kunder till Blogvertiser. Det \u00e4r gratis f\u00f6r nya bloggare att registrera sig.\n\nSale\n1-10 = 20 kr\n>10 = 25 kr\n\nEn lead inneb\u00e4r att en bloggare registrerat sig. En sale intr\u00e4ffar n\u00e4r den blogg registrerar sig (via din l\u00e4nk\/banner) och uppfyller nedan angivna krav och d\u00e5 blivit godk\u00e4nd.\n\nKrav f\u00f6r att bloggarna ska bli godk\u00e4nda\nBloggen ska vara p\u00e5 svenska\nBloggen ska ha existerat i minst 3 m\u00e5nader\nBloggen ska ha minst 20 inl\u00e4gg\/artiklar\nBloggaren minst 13 \u00e5r gammal\nBloggens inneh\u00e5ll f\u00e5r inte bryta mot lagar som ex hets mot folkgrupp och liknande\nBloggen ska vara \u201daktiv\u201d, dvs att bloggen uppdateras med en viss regelbundenhet (ex 1 ggr\/veckan eller liknande)\n\nNy kund\nOm en kund registrerar sig till Blogvertiser f\u00e5r du som affiliate 5 kr i provision f\u00f6r registreringen. Vid den f\u00f6rsta kundbest\u00e4llningen f\u00e5r du 10% av orderv\u00e4rdet.\n\nRegler f\u00f6r annonsering\n\nInte till\u00e5tet\nInte till\u00e5tet att marknadsf\u00f6ra Blogvertiser p\u00e5 s.k. rewardsajter (dvs sajter d\u00e4r man kan samla po\u00e4ng genom att prenumerera, intresseanm\u00e4la etc.).\n\nDet inte heller till\u00e5tet att anv\u00e4nda affiliatel\u00e4nkarna i twitter eller liknande medier.\n\nDetta till\u00e5ts\nMaterial som f\u00e5r anv\u00e4ndas \u00e4r endast de annonser och textl\u00e4nkar som finns i programmet. Det \u00e4r accepterat att skapa egna textl\u00e4nkar om man vill kunna kommunicera mer kring erbjudandet \u00e4n de annonser och textl\u00e4nkar som finns i programmet.\n\n\u00d6nskas fler format eller erbjudanden eller att ni vill anv\u00e4nda er av egna skapade banners s\u00e5 h\u00f6r av er till affiliate@blogvertiser.com. \n\nNi f\u00e5r ocks\u00e5 g\u00e4rna h\u00f6ra av er om ni har f\u00f6rslag p\u00e5 affiliateuppl\u00e4gg som \u00e4r annat \u00e4n det traditionella med hemsidor, bloggar eller e-post marknadsf\u00f6ring.\n",
                "allowReward": false,
                "allowMail": true,
                "allowPublisher": false,
                "allowCoupon": true,
                "keywordPolicy": "closed",
                "cookieLifetime": "45 days",
                "category": "Blogging och social media",
                "commissions": [
                    {
                        "type": "sale",
                        "name": "Godk\u00e4nd bloggare",
                        "commission": "20 SEK",
                        "segments": [
                            {
                                "step": "11",
                                "name": "Godk\u00e4nd bloggare",
                                "commission": "25 SEK"
                            }
                        ]
                    },
                    {
                        "type": "lead",
                        "name": "Ny kund",
                        "commission": "5 SEK",
                        "segments": [
                            {
                                "step": "11",
                                "name": "Godk\u00e4nd bloggare",
                                "commission": "25 SEK"
                            }
                        ]
                    },
                    {
                        "type": "sale",
                        "name": "Ny kundbest\u00e4llning",
                        "commission": "10%",
                        "segments": [
                            {
                                "step": "11",
                                "name": "Godk\u00e4nd bloggare",
                                "commission": "25 SEK"
                            }
                        ]
                    }
                ]
            }
        }';

        $programData = json_decode($json)->result;
        $program = (new Denormalizer())->denormalizeProgram($programData);

        $this->assertInstanceOf('\AdrecordApiWrapper\Program', $program);
        $this->assertEquals(43, $program->getId());
        $this->assertEquals('Blogvertiser', $program->getName());
        $this->assertEquals('http://www.blogvertiser.com/sv/', $program->getUrl());
    }

    public function testDenormalizePrograms()
    {
        $programData = [(object)[
            'id' => 43,
            'name' => 'Blogvertiser',
            'url' => 'http://www.blogvertiser.com/sv/',
            'category' => 'Blogging och social media',
        ]];

        $programs = (new Denormalizer())->denormalizePrograms($programData);

        $this->assertInstanceOf('\AdrecordApiWrapper\Program', $programs[0]);
        $this->assertEquals(43, $programs[0]->getId());
        $this->assertEquals('Blogvertiser', $programs[0]->getName());
        $this->assertEquals('http://www.blogvertiser.com/sv/', $programs[0]->getUrl());
    }

    public function testDenormalizeTransactions()
    {
        $json = '
        {
            "status": "OK",
            "result": [
                {
                    "id": 12345,
                    "type": "sale",
                    "click": "2012-12-06 09:56:03",
                    "epi": "topbanner",
                    "program": {
                        "id": 168,
                        "name": "Bubbleroom"
                    },
                    "channel": {
                        "id": 1,
                        "url": "http:\/\/www.example.com\/"
                    },
                    "orderID": "34622",
                    "orderValue": 29500,
                    "commission": 2950,
                    "commissionName": "Order",
                    "changes": [
                        {
                            "type": "transaction registered",
                            "date": "2012-12-06 10:03:12"
                        }
                    ],
                    "platform": "mac",
                    "status": 5
                }
            ]
        }';

        $transactionData = json_decode($json)->result;
        $transactions = (new Denormalizer())->denormalizeTransactions($transactionData);

        $this->assertInstanceOf('\AdrecordApiWrapper\Transaction', $transactions[0]);
        $this->assertEquals(12345, $transactions[0]->getId());
        $this->assertEquals('sale', $transactions[0]->getType());
        $this->assertEquals(
            \DateTime::createFromFormat('Y-m-d H:i:s', '2012-12-06 09:56:03'),
            $transactions[0]->getClickedAt()
        );
        $this->assertEquals('topbanner', $transactions[0]->getEpi());
        $this->assertInstanceOf('\AdrecordApiWrapper\Program', $transactions[0]->getProgram());
        $this->assertInstanceOf('\AdrecordApiWrapper\Channel', $transactions[0]->getChannel());
        $this->assertEquals('34622', $transactions[0]->getOrderId());
        $this->assertEquals(29500, $transactions[0]->getOrderValue());
        $this->assertEquals(29500, $transactions[0]->getOrderValue());
        $this->assertEquals(2950, $transactions[0]->getCommission());
        $this->assertEquals('Order', $transactions[0]->getCommissionName());
        $this->assertInternalType('array', $transactions[0]->getChanges());
        $this->assertEquals('transaction registered', current($transactions[0]->getChanges()));
        $this->assertEquals(1354784592, key($transactions[0]->getChanges()));
        $this->assertEquals('mac', $transactions[0]->getPlatform());
        $this->assertEquals(5, $transactions[0]->getStatus());
    }
}
