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
    }


?>
