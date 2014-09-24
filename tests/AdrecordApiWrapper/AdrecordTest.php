<?php

use AdrecordApiWrapper\Adrecord;

class AdrecordTest extends PHPUnit_Framework_TestCase
{
    public function testReturnsAListOfChannels()
    {
        $json = <<<JSON
{
    "status": "OK",
    "result": [
        {
            "channelID": "4",
            "channelName": "Hittajulklappar",
            "channelUrl": "http:\/\/www.hittajulklappar.se"
        }
    ]
}
JSON;

        $adrecord = new Adrecord('foo', $this->getClientMock(200, $json));

        $this->assertInternalType('array', $adrecord->getChannels());
        $this->assertEquals(4, $adrecord->getChannels()[0]->getId());
    }

    public function testReturnAChannel()
    {
        $json = <<<JSON
{
    "status": "OK",
    "result": {
        "channelID": "4",
        "channelName": "Hittajulklappar",
        "channelUrl": "http:\/\/www.hittajulklappar.se",
        "programs": [
            {
                "programName": "Roliga Prylar",
                "programID": "193"
            }
        ]
    }
}
JSON;

        $adrecord = new Adrecord('foo', $this->getClientMock(200, $json));

        $this->assertInstanceOf('AdrecordApiWrapper\Channel', $adrecord->getChannel(4));
        $this->assertEquals(4, $adrecord->getChannel(4)->getId());
    }

    public function testReturnsAListOfPrograms()
    {
        $json = <<<JSON
{
    "status": "OK",
    "result": [
        {
            "id": "43",
            "name": "Blogvertiser",
            "url": "http:\/\/www.blogvertiser.com\/sv\/",
            "category": "Blogging och social media"
        }
    ]
}
JSON;

        $adrecord = new Adrecord('foo', $this->getClientMock(200, $json));

        $this->assertInternalType('array', $adrecord->getPrograms());
        $this->assertEquals(43, $adrecord->getPrograms()[0]->getId());
    }

    public function testReturnAProgram()
    {
        $json = <<<JSON
{
    "status": "OK",
    "result": {
        "id": 43,
        "name": "Blogvertiser",
        "url": "http:\/\/www.blogvertiser.com\/sv\/",
        "description": "Blogvertiser...",
        "category": "Blogging och social media"
    }
}
JSON;

        $adrecord = new Adrecord('foo', $this->getClientMock(200, $json));

        $this->assertInstanceOf('AdrecordApiWrapper\Program', $adrecord->getProgram(43));
        $this->assertEquals(43, $adrecord->getProgram(43)->getId());
    }

    /**
     * @expectedException AdrecordApiWrapper\Exception\CommunicationException
     */
    public function testThowsCommunicationExceptionsIfAdrecordIsDown()
    {
        (new Adrecord('foo', $this->getClientMock(500, '{}')))->getChannels();
    }

    /**
     * @expectedException AdrecordApiWrapper\Exception\AuthenticationException
     */
    public function testThowsAuthenticationExceptionIfNotAuthenticated()
    {
        (new Adrecord('foo', $this->getClientMock(200, '{"status":"error","message":"authentication failed"}')))
            ->getChannels();
    }

    /**
     * @param int    $statusCode
     * @param string $json
     *
     * @return Guzzle\Http\ClientInterface
     */
    protected function getClientMock($statusCode, $json)
    {
        $clientMock = $this->getMock('Guzzle\\Http\\ClientInterface');
        $clientMock->expects($this->any())->method('get')
            ->will($this->returnValue($this->getRequestMock($statusCode, $json)));

        return $clientMock;
    }

    /**
     * @param int    $statusCode
     * @param string $json
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRequestMock($statusCode, $json)
    {
        $requestMock = $this->getMock('Guzzle\\Http\\Message\\RequestInterface');
        $requestMock->expects($this->any())->method('send')->will(
            $this->returnValue($this->getResponseMock($statusCode, $json))
        );

        return $requestMock;
    }

    /**
     * @param int    $statusCode
     * @param string $json
     *
     * @return Guzzle\Http\Message\Response
     */
    protected function getResponseMock($statusCode, $json)
    {
        $responseMock = $this->getMockBuilder('Guzzle\\Http\\Message\\Response')
            ->disableOriginalConstructor()->getMock();
        $responseMock->expects($this->any())->method('getStatusCode')->will($this->returnValue($statusCode));
        $responseMock->expects($this->any())->method('getBody')->will($this->returnValue($json));

        return $responseMock;
    }
}
