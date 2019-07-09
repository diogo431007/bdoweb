<?php

if (isset($_POST['query'])) {

    $queryString = $_POST['query'];

    header("Content-Type: text/html; charset=ISO-8859-1", true);
    require_once 'conecta.php';
    require_once 'define.php';

    $query = mysql_query("SELECT id_cbo, nm_cbo FROM cbo WHERE nm_cbo LIKE '$queryString%'");

    if ($query) {
        $li = '';
        while ($res = mysql_fetch_object($query)) {
            
            $li .= '<li class="style3" onClick="fill(\'' . $res->id_cbo . '\', \'' . $res->nm_cbo . '\');">' . $res->nm_cbo . '</li>';
            
        }
        
        echo $li;
        
    } else {
        echo 'ERROR: There was a problem with the query.';
    }
}

//	
//	// PHP5 Implementation - uses MySQLi.
//	// mysqli('localhost', 'yourUsername', 'yourPassword', 'yourDatabase');
//	//$db = new mysqli('localhost', 'root' ,'', 'banco_de_talentos');
//	
//        
//        
//	
//	
//		// Is there a posted query string?
//		if(isset($_POST['query'])) {
//			$queryString = $_POST['query'];
//			
//                        
//                        return "teste";die;
//                        
//                        
//			// Is the string length greater than 0?
//			
//			if(strlen($queryString) >0) {
//				// Run the query: We use LIKE '$queryString%'
//				// The percentage sign is a wild-card, in my example of countries it works like this...
//				// $queryString = 'Uni';
//				// Returned data = 'United States, United Kindom';
//				
//				// YOU NEED TO ALTER THE QUERY TO MATCH YOUR DATABASE.
//				// eg: SELECT yourColumnName FROM yourTable WHERE yourColumnName LIKE '$queryString%' LIMIT 10
//				
//				
//				if($query) {
//					// While there are results loop through them - fetching an Object (i like PHP5 btw!).
//					$li = '';
//                                        while ($result = mysql_fetch_object($query)) {
//						// Format the results, im using <li> for the list, you can change it.
//						// The onClick function fills the textbox with the result.
//						
//						// YOU MUST CHANGE: $result->value to $result->your_colum
//                                                $li .= '<li class="style3" onClick="fill(\''.$res->id_cbo.'\', \''.$res->nm_cbo.'\');">'.$res->nm_cbo.'</li>';
//                                        }
//                                        return $li;
//				} else {
//					echo 'ERROR: There was a problem with the query.';
//				}
//			} else {
//				// Dont do anything.
//			} // There is a queryString.
//		} else {
//			echo 'There should be no direct access to this script!';
//		}
?>