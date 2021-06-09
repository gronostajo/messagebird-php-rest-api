<?php

namespace Tests\Integration;

use MessageBird\Client;
use MessageBird\Common\HttpClient;
use MessageBird\Resources\Balance;
use MessageBird\Resources\Chat\Channel;
use MessageBird\Resources\Chat\Contact;
use MessageBird\Resources\Chat\Message;
use MessageBird\Resources\Chat\Platform;
use MessageBird\Resources\Contacts;
use MessageBird\Resources\Groups;
use MessageBird\Resources\Hlr;
use MessageBird\Resources\Messages;
use MessageBird\Resources\Verify;
use MessageBird\Resources\VoiceMessage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    /** @var Client */
    protected $client;

    /** @var MockObject */
    protected $mockClient;

    public function testClientConstructor()
    {
        $messageBird = new Client('YOUR_ACCESS_KEY');
        self::assertInstanceOf(Balance::class, $messageBird->balance);
        self::assertInstanceOf(Hlr::class, $messageBird->hlr);
        self::assertInstanceOf(Messages::class, $messageBird->messages);
        self::assertInstanceOf(Contacts::class, $messageBird->contacts);
        self::assertInstanceOf(Groups::class, $messageBird->groups);
        self::assertInstanceOf(VoiceMessage::class, $messageBird->voicemessages);
        self::assertInstanceOf(Verify::class, $messageBird->verify);
        self::assertInstanceOf(Message::class, $messageBird->chatMessages);
        self::assertInstanceOf(Platform::class, $messageBird->chatPlatforms);
        self::assertInstanceOf(Channel::class, $messageBird->chatChannels);
        self::assertInstanceOf(Contact::class, $messageBird->chatContacts);
    }

    public function testHttpClientMock()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('addUserAgentString');
        new Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockClient = $this->getMockBuilder(HttpClient::class)->setConstructorArgs(["fake.messagebird.dev"])->getMock();
        $this->client = new Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    /**
     * Prevents a test that performs no assertions from being considered risky.
     * The doesNotPerformAssertions annotation is not available in earlier PHPUnit
     * versions, and hence can not be used.
     */
    protected function doAssertionToNotBeConsideredRiskyTest()
    {
        static::assertTrue(true);
    }
}
