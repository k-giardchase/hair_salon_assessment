<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__.'/../src/Client.php';

    $DB = new PDO('pgsql:host=localhost;dbname=hair_salon_test');

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Client::deleteAll();
        }

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

        function testSetClientName()
        {
            //Arrange
            $client_name = "Jane";
            $id = 1;
            $test_client= new Client($client_name, $id);

            //Act
            $test_client->setClientName('Jackie');

            //Assert
            $result = $test_client->getClientName();
            $this->assertEquals("Jackie", $result);
        }


        function testGetId()
        {
            //Arrange
            $client_name = "Bob";
            $id = 1;
            $test_client = new Client($client_name, $id);

            //Act
            $result = $test_client->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function testSetId()
        {
            //Arrange
            $client_name = "Gillian";
            $id = 1;
            $test_client = new Client($client_name, $id);

            //Act
            $test_client->setId(2);

            //Assert
            $result = $test_client->getId();
            $this->assertEquals(2, $result);
        }

        function testSave()
        {
            //Arrange
            $client_name = "Peter";
            $id = 1;
            $test_client =  new Client($client_name, $id);

            //Act
            $test_client->save();

            //Assert
            $result = Client::getAll();
            $this->assertEquals($test_client, $result[0]);
        }

        function testFind()
        {
            //Arrange
            $client_name =  "Maggie";
            $id = 1;
            $new_client = new Client($client_name, $id);
            $new_client->save();
            $client_name2 = "Piper";
            $id2 = 2;
            $new_client2 = new Client($client_name2, $id2);
            $new_client2->save();

            //Act
            $result = Client::find($new_client->getId());

            //Assert
            $this->assertEquals($new_client, $result);
        }
        
        function testGetAll()
        {
            //Arrange
            $client_name = "Jane";
            $client_name2 = "Peter";
            $id = 1;
            $id2= 2;
            $test_client = new Client($client_name, $id);
            $test_client2 = new Client($client_name2, $id2);
            $test_client->save();
            $test_client2->save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $client_name = "Jane";
            $client_name2 = "Peter";
            $id = 1;
            $id2 = 2;
            $test_client = new Client($client_name, $id);
            $test_client2 = new Client($client_name2, $id2);
            $test_client->save();
            $test_client2->save();

            //Act
            Client::deleteAll();


            //Assert
            $result = Client::getAll();
            $this->assertEquals([], $result);
        }


    }

?>
