<?php
$uploaddir = './images/'; 
$file = $uploaddir .  rand(0, 9999)."_".basename($_FILES['upload']['name']); 
$file_name= "webinfopedia_".$_FILES['upload']['name']; 
 
if (move_uploaded_file($_FILES['upload']['tmp_name'], $file)) { 
    echo $file; 
} else {
    echo "error";
}
?>
