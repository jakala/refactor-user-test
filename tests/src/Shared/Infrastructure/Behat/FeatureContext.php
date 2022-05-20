<?php

namespace TechnicalTest\Tests\src\Shared\Infrastructure\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use GuzzleHttp\Client;
use mysqli;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Class FeatureContext
 * @package TechnicalTest\Tests\src\Shared\Infrastructure\Behat
 */
class FeatureContext implements Context
{
    private ResponseInterface $body;
    private string $baseUrl;
    private string $dbHost;
    private int $dbPort;
    private string $dbUser;
    private string $dbPass;
    private string $dbName;

    /**
     * FeatureContext constructor.
     * @param string $baseUrl
     * @param string $dbHost
     * @param int $dbPort
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbName
     */
    public function __construct(
        string $baseUrl, string $dbHost, int $dbPort, string $dbUser, string $dbPass, string $dbName)
    {
        $this->baseUrl = $baseUrl;
        $this->dbHost = $dbHost;
        $this->dbPort = $dbPort;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
    }

    /**
     * @Given I send a :method request to :url with body:
     */
    public function iSendARequestToWithBody($method, $url, PyStringNode $body): void
    {
        $client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 2.0,
        ]);
        $this->body = $client->request($method, $url, ['body' => $body, 'http_errors' => false]);
    }

    /**
     * @Then the response should be empty
     */
    public function theResponseShouldBeEmpty(): void
    {
        Assert::assertEmpty(
            (string)$this->body->getBody(),
            'The response is not empty'
        );
    }

    /**
     * @Then the response status code should be :expectedResponseCode
     */
    public function theResponseStatusCodeShouldBe(string $expectedResponseCode): void
    {
        Assert::assertSame((int)$expectedResponseCode, $this->body->getStatusCode());
    }

    /**
     * @Given A valid user with id :id name :name and phone :phone
     */
    public function aValidUserWithIdNameAndPhone(string $id, string $name, string $phone): void
    {
        $conn = $this->connectionDb();
        $sql = "INSERT INTO user (id, name, phone) VALUES ('$id', '$name', '$phone')";
        if (!$conn->query($sql)) {
            throw new RuntimeException(sprintf('User %s not saved', $id));
        }
        $conn->close();
    }

    /**
     * @return mysqli
     */
    private function connectionDb(): mysqli
    {
        return new mysqli(
            $this->dbHost,
            $this->dbUser,
            $this->dbPass,
            $this->dbName,
            $this->dbPort
        );
    }

    /**
     * @Given I send a :method request to :url
     */
    public function iSendARequestTo(string $method, string $url): void
    {
        $client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 2.0,
        ]);
        $this->body = $client->request($method, $url, ['http_errors' => false]);
    }

    /**
     * @Then the response content should be:
     */
    public function theResponseContentShouldBe(PyStringNode $string): void
    {
        Assert::assertEquals(
            json_decode($string, true, 512, JSON_THROW_ON_ERROR),
            json_decode((string)$this->body->getBody(), true, 512, JSON_THROW_ON_ERROR),
            'The response is not equals'
        );
    }

    /**
     * @BeforeScenario
     */
    public function cleanDatabase(): void
    {
        $conn = $this->connectionDb();
        $sql = 'DELETE FROM user';
        if (!$conn->query($sql)) {
            throw new RuntimeException('Error to clear data bases');
        }
        $conn->close();
    }

}
