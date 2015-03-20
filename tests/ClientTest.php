<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__.'/../src/Client.php';

    $DB = new PDO('pgsql:host=localhost;dbname=hair_salon_test');

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        function testGetClientName()
        {
            //Arrange
            $client_name = "Jane";
            $id = 1;
            $test_client = new Client($client_name, $id);

            //Act
            $result = $test_client->getClientName();

            //Assert
            $this->assertEquals("Jane", $result);
        }


    }

?>
