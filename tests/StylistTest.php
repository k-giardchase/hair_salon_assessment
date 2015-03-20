<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__.'/../src/Stylist.php';

    $DB = new PDO('pgsql:host=localhost;dbname=hair_salon_test');

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
        }

        function testGetStylist()
        {
            //Arrange
            $stylist_name = "Jane";
            $test_stylist = new Stylist($stylist_name);

            //Act
            $result = $test_stylist->getStylistName();

            //Assert
            $this->assertEquals("Jane", $result);
        }

        function testSave()
        {
            //Arrange
            $stylist_name = "Peter";
            $test_stylist =  new Stylist($stylist_name);

            //Act
            $test_stylist->save();

            //Assert
            $result = Stylist::getAll();
            $this->assertEquals($test_stylist, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $stylist_name = "Jane";
            $stylist_name2 = "Peter";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist2 = new Stylist($stylist_name2);
            $test_stylist->save();
            $test_stylist2->save();

            //Act
            $result = Stylist::getAll();
            var_dump($result);

            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $stylist_name = "Jane";
            $stylist_name2 = "Peter";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist2 = new Stylist($stylist_name2);
            $test_stylist->save();
            $test_stylist2->save();

            //Act
            Stylist::deleteAll();


            //Assert
            $result = Stylist::getAll();
            var_dump($result);
            $this->assertEquals([], $result);
        }
    }

?>
