<?php

    require_once __DIR__ . "/vendor/autoload.php";

    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->itech;
    
    function gen_price_range(){
        global $db;
        $res = $db->itech->aggregate(array( 
            array(
             "\$group" => array( 
                "_id" => null,
                "max" => array("\$max" => "\$price" ), 
                "min" => array("\$min" => "\$price" ) 
             )))
        )->toArray()[0];

        return "<input type=\"number\" value=".$res["min"]." name=\"price_low\" id=\"price_low\">".
        "<input type=\"number\" value=".$res["max"]." name=\"price_high\" id=\"price_high\">";
    }

    function gen_vendors()
    {
        global $db;
        $res = array();
        foreach($db->itech->distinct("vendor") as $row){
            array_push($res, array("vendor" => $row));
        }
        return $res;
    }

    function gen_out_of_stock()
    {
        global $db;
        return $array = json_decode(json_encode($db->itech->find(array("quantity" => 0), array('projection' => array("_id" => false)))->toArray(),true), true);
    }

    function find_price_range($min, $max)
    {
        global $db;
        return $db->itech->find(array(
            "\$and" => array(
                array("price" => array("\$gte" => $min)),
                array("price" => array("\$lte" => $max))
            )
            ), array('projection' => array("_id" => false)))->toArray();
    }

?>