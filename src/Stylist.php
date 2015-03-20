<?php

    class Stylist
    {
        private $stylist_name;
        private $id;

        function __construct($stylist_name, $id = null)
        {
            $this->stylist_name = $stylist_name;
            $this->id = $id;
        }

        function getStylistName()
        {
            return $this->stylist_name;
        }

        function setStylist($new_stylist_name)
        {
            $this->stylist_name = (string) $new_stylist_name;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stylists (stylist_name) VALUES ('{$this->getStylistName()}'
        );");
        }

        static function getAll()
        {
            $all_stylists = array();
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            foreach($returned_stylists as $returned_stylist){
                $stylist_name = $returned_stylist['stylist_name'];
                $new_stylist = new Stylist($stylist_name);
                array_push($all_stylists, $new_stylist);
            }
            return $all_stylists;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists *;");
        }
    }

?>
