<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__.'/../src/Stylist.php';

    $DB = new PDO('pgsql:host=localhost;dbname=hair_salon_test');

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        function testGetStylist()
        {
            //Arrange
            $stylist = "Jane";
            $test_stylist = new Stylist($stylist);

            //Act
            $result = $test_stylist->getStylist();

            //Assert
            $this->assertEquals("Jane", $result);
        }

        function testSave()
        {
            //Arrange
            $stylist = "Peter";
            $test_stylist =  new Stylist($stylist);

            //Act
            $test_stylist->save();

            //Assert
            $result = Stylist::getAll();
            $this->assertEquals($test_stylist, $result[0]);
        }
    }

?>
