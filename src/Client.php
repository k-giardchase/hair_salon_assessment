<?php

    class Client
    {
        private $client_name;
        private $id;

        function __construct($client_name, $id = null)
        {
            $this->client_name = $client_name;
            $this->id = $id;
        }

        function getClientName()
        {
            return $this->client_name;
        }

        function setClientName($new_client_name)
        {
            $this->client_name = (string) $new_client_name;
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
            $statement = $GLOBALS['DB']->query("INSERT INTO clients (client_name) VALUES ('{$this->getClientName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET client_name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setClientName($new_name);
        }

        static function find($search_id)
        {
            $found_client = null;
            $clients = Client::getAll();
            foreach($clients as $client){
                $client_id = $client->getId();
                if($client_id == $search_id) {
                    $found_client = $client;
                }
            }
            return $found_client;
        }


        static function getAll()
        {
            $all_clients = array();
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            foreach($returned_clients as $client){
                $client_name = $client['client_name'];
                $id = $client['id'];
                $new_client = new Client($client_name, $id);
                array_push($all_clients, $new_client);
            }
            return $all_clients;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->query("DELETE FROM clients *;");
        }

    }


?>
