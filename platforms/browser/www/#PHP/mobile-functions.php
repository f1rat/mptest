<?php

//////////////////////////////////////////////////////
/*                EDIT TO YOUR NEEDS                //
//   												//
// Use the $to_remove variable below to prevent     //
// selected fields from displaying in the app		//
// 			 										//
// Example : 										//
// $to_remove = array('2','3','4');					*/
//													//
$to_remove = array('6','78','10','17','38','52','79');
//													//
// 						Edit END		    		//
//////////////////////////////////////////////////////

header('Access-Control-Allow-Origin: *');  
$postdata = htmlspecialchars($_GET["action"]);
$language = htmlspecialchars($_GET["language"]);
//Databse string
$con = new mysqli("localhost","makinepa_db0118","zbBKlItU3w5AjUzp","makinepa_db0118");
// Check connection
if ($con->connect_error)
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
if (!mysqli_set_charset($con, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($con));
    exit();
} else {
    console.log("Current character set: %s\n", mysqli_character_set_name($con));
}

// Get slideshow
if ($postdata == 'getSlides') {
$sql = "SELECT * FROM slideshow ORDER BY id";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$repo_id = $row["repository_id"];
    }
} else {
    echo "0 results";
}
	$sql2 = "SELECT filename FROM file WHERE repository_id='$repo_id' ORDER BY id";
	$result2 = $con->query($sql2);
	if ($result2->num_rows > 0) {
    while($row2 = $result2->fetch_assoc()) {
	echo json_encode($row2[filename]);
    }
	}
	else { echo "no slides"; }
	mysqli_close($con);
} 


// Get single property data
else if ($postdata == 'getSinglePropertyData') {
$propertyID = htmlspecialchars($_GET["propertyID"]);
$language = htmlspecialchars($_GET["language"]);
$sql = "SELECT property.gps,property.lat,property.lng,property.date,property.address,property.repository_id,property.is_featured,property.image_filename,property.image_repository,property_lang.json_object FROM property LEFT JOIN property_lang ON '$propertyID' = property_lang.property_id AND property_lang.language_id = '$language' WHERE property.id='$propertyID'";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$data[] = $row;
    }
$machinetype = json_decode($data[0]["json_object"], true); 
    
foreach ($machinetype as $key => $value) {
    if (empty($value)) {
    unset($machinetype[$key]);
    } else {
    $varo[] = (int) filter_var($key, FILTER_SANITIZE_NUMBER_INT);
    }
	}
$in = sort($varo, SORT_NUMERIC);
$in = '(' . implode(',', $varo) . ')';
$data[3] = $in;
$sql2 = "SELECT `option` FROM `option_lang` WHERE `option_id` IN $in AND `language_id`=$language ORDER BY `option_id` ASC";
$result2 = $con->query($sql2);
$i = 0;
if ($result2->num_rows > 0) {
while($row2 = $result2->fetch_assoc()) {
	$data[2][] = $row2;
    } 
} else { $data[2] = "no result"; }

if (empty($machinetype)) {
$data[1] = "empty array";
}    
else {
$data[1] = $varo;
}    
    

$data[5] = array_diff($varo, $to_remove);

     
    
    echo json_encode($data);
}
else {
    echo json_encode("No property with given ID");
	}     
}      
    
    
// Get blog entries
else if ($postdata == 'getLatestNews') {
$newsid = htmlspecialchars($_GET["newsid"]);
if ($newsid == ""){
$sql = "SELECT id,image_filename FROM page WHERE type='MODULE_NEWS_POST' ORDER BY id";
} else {
$sql = "SELECT id,image_filename FROM page WHERE id='$newsid'";
}
$result = $con->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$pageid[] = $row["id"];
	$photoid[] = $row["image_filename"];
    }
$list = implode( ", ", $pageid );
$sql2 = "SELECT title,body FROM page_lang WHERE page_id IN (".implode(',', $pageid).") AND language_id='$language' ORDER BY page_id";
$result2 = $con->query($sql2);
if ($result2->num_rows > 0) {
while($row2 = $result2->fetch_assoc()) {
	$title[] = $row2["title"];
	$body[] = $row2["body"];
}
}
$blog = array_merge($pageid,$photoid,$title,$body);
echo json_encode($blog);
}
else {
    echo json_encode("no news");
	}     
} 


//Get categories list
else if ($postdata == 'getCatListing') {
$language = htmlspecialchars($_GET["language"]);
$sql = "SELECT `values` FROM `option_lang` WHERE option_id=2 AND language_id=$language";
$result = $con->query($sql);
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
	echo json_encode($row);
}
} else { echo json_encode("no-result");}
}


//Get machines under specific category
else if ($postdata == 'getCatMachines') {
$mtype = htmlspecialchars($_GET["mtype"]);
$lang = htmlspecialchars($_GET["language"]);
$data = Array();
$sql = "SELECT property_lang.property_id,property_lang.json_object,property_lang.field_36_int,property_lang.field_37_int,property_lang.field_55_int,property_lang.field_82_int, property.image_filename FROM property_lang LEFT JOIN property ON property.id = property_lang.property_id WHERE field_2='$mtype' AND language_id='$lang' AND property.is_activated='1'";
$result = $con->query($sql);
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
	$data[] = $row;
}
echo json_encode($data);
} else { echo json_encode("no-result");}
}


















    
//If the request is none of the above,
else {
echo "Wrong Request";
}
?>