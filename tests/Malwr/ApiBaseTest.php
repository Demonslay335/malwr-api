<?php
/**
 * ApiBase test
 * @category testing
 * @package Test_Malwr
 * @author Michael Gillespie (demonslay335@gmail.com)
 */
namespace Tests\Malwr;

use \Guzzle\Http\Client as GuzzleClient;

class ApiBaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * See if a native GuzzleClient instance
     * returns an instance of \VirusTotal\ApiBase
     */
    public function testCtor() {
        $apiBaseStub = new \Malwr\ApiBase(apiKey, new GuzzleClient());
        $this->assertInstanceOf('\Malwr\ApiBase', $apiBaseStub);
    }

}