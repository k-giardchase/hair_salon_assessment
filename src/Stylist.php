<?php

    class Stylist
    {
        private $stylist;

        function __construct($stylist)
        {
            $this->stylist = $stylist;
        }

        function getStylist()
        {
            return $this->stylist;
        }

        function setStylist($new_stylist)
        {
            $this->stylist = $stylist;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stylists (stylist_name) VALUES ('{$this->getStylist()}'
        );");
        }

        function getAll()
        {
            $all_stylists = array();
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            foreach($returned_stylists as $returned_stylist){
                $stylist = $returned_stylist['stylist'];
                $new_stylist = new Stylist($stylist);
                array_push($all_stylists, $new_stylist);
            }
            return $all_stylists;
        }
    }

?>
