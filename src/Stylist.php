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

        function setStylistName($new_stylist_name)
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

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stylists SET stylist_name = '{$new_name}' WHERE id ='{$this->getId()}';");
            $this->setStylistName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getId()};");

        }

        function getClients()
        {
            $all_clients = array();
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            foreach($returned_clients as $client){
                $client_name = $client['client_name'];
                $stylist_id = $client['stylist_id'];
                $id = $client['id'];
                $new_client = new Client($client_name, $stylist_id, $id);
                array_push($all_clients, $new_client);
            }
            return $all_clients;
        }

        static function find($search_id)
        {
            $found_stylist = null;
            $stylists = Stylist::getAll();
            foreach($stylists as $stylist){
                $stylist_id = $stylist->getId();
                if($stylist_id == $search_id) {
                    $found_stylist = $stylist;
                }
            }
            return $found_stylist;
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
