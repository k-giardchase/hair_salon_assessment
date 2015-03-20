<?php

    class Stylist
    {
        private stylist;

        function __construct($stylist)
        {
            $this->stylist = $stylist
        }

        function getStylist()
        {
            return $this->stylist;
        }

        function setStylist($new_stylist)
        {
            $this->stylist = $stylist;
        }
    }

?>
