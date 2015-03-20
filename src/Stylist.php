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

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO stylists (stylist_name) VALUES ('{$this->getStylistName()}'
        ) RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $all_stylists = array();
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            foreach($returned_stylists as $returned_stylist){
                $stylist_name = $returned_stylist['stylist_name'];
                $id = $returned_stylist['id'];
                $new_stylist = new Stylist($stylist_name, $id);
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
