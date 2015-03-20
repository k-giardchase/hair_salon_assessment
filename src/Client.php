<?php

    class Client
    {
        private $client_name;
        private $id;

        function __construct($client_name, $id)
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
            $GLOBALS['DB']->query("INSERT INTO clients (client_name) VALUES '{$this->getClientName()}';");
        }
    }


?>
