<?php
echo "<link rel='stylesheet' type='text/css' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' />";
$user = 'root';
$pass='password';
$data = fetchData($user, $pass);

$htmlResult = buildHtml($data['colums'], $data['category']);
echo "<div class='container'>";
echo "<div class='jumbotron'>";
echo $htmlResult;
echo "</div></div>";

function buildHtml($column = [], $res = []) {
	$columns = array_unique($column);
    $headerCount = count($columns);
    // $html.= "<pre>"; var_dump($columns); $html.= "</pre>";die;
    $html = '';
    $html.="<table class='table table-hover'>";
    $html.= "<thead>";
    $html.= "<tr>";
          foreach($columns as $thead) { 
          	  $html.= "<th>" . $thead . "</th>";
          }
    $html.= "</tr>";
    $html.= "</thead><tbody>";

    $counter = 0;
 
    foreach ($res as $ky => $item){

    	if ($counter == 0) {
    		$html.= "<tr>";
    	}
    	if ($counter == 0) {
    		$html.= "<td><a href='#'>". $item . "</a></td>";
    	}else {
        	$html.= "<td>". $item . "</td>";
    	}
        if ($counter++ == ($headerCount-1)) {
        	$html.= "</tr>";
        	$counter = 0;
        }        
    }
    $html.= "</tbody></table>";
    return $html;
}


function fetchData($user, $pass) {
	try {
	$categories = [];
	$column = [];

    $dbh = new PDO('mysql:host=localhost;dbname=my_test', $user, $pass);
    foreach($dbh->query('SELECT table_1.title, table_2.title as category FROM table_1 LEFT JOIN table_2 on table_1.id = table_2.category_id') as $row) { 
        // $d[$row['title']][$i] = $row['category'];
        $column[] = $row['title'];
        $categories[] = $row['category'];

    }
    
    return ['colums' => $column, 'category' => $categories];
    
    $dbh = null;
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}
}
