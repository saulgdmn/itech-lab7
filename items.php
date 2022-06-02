<?php
    include('bd.php');
    
    function build_table($array){
        $html = '<table>';
        $html .= '<tr>';
        foreach($array[0] as $key=>$value){
                $html .= '<th>' . htmlspecialchars($key) . '</th>';
            }
        $html .= '</tr>';
    
        foreach( $array as $key=>$value){
            $html .= '<tr>';
            foreach($value as $key2=>$value2){
                $html .= '<td>' . htmlspecialchars($value2) . '</td>';
            }
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        return $html;
    }

    function array_to_xml( $data, &$xml_data ) {
        foreach( $data as $key => $value ) {
            if( is_array($value) ) {
                if( is_numeric($key) ){
                    $key = 'item'.$key; //dealing with <0/>..<n/> issues
                }
                $subnode = $xml_data->addChild($key);
                array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
         }
    }
    
    switch ($_GET['type']) {
        case "vendor":
            echo build_table(gen_vendors());
            break;
        case "out_of_stock":
            header('Content-Type: text/xml');
            header('Cache-Control: no-cache, must-revalidate');
            
            $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            array_to_xml(gen_out_of_stock(),$xml_data);
            echo $xml_data->asXML();
            break;
        case "price":
            $price_low = intval($_GET['price_low']);
            $price_high = intval($_GET['price_high']);
            echo json_encode(find_price_range($price_low, $price_high));
            break;
    }
?>