<?php
// Set up the REDIRECT_URI -- which is just the URL for this file.
// define("REDIRECT_URI", 'http://localhost/podio-php/examples/server-auth.php');
define("REDIRECT_URI", 'http://learning-toolbox.glyn.in/php/podio-add-a-suggestion.php');

    // Include the config file and the Podio library
    require_once '../podio/config.php';
    require_once '../podio/PodioAPI.php';

    // Setup the API client reference. Client ID and Client Secrets are defined
    // as constants in config.php
    Podio::setup( CLIENT_ID, CLIENT_SECRET );
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="refresh" content="2;url=podio-list-my-suggestions.php"> 
        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>new_file</title>
        <meta name="description" content="">
        <meta name="author" content="Gilbert">

        <meta name="viewport" content="width=device-width; initial-scale=1.0">

        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    </head>

    <body>
        <div>
            <header>
                <h1>Processing...</h1>
            </header>

        </div>
    </body>
</html>

<?php
    // echo "trying-podio-add-suggestion<br>";

    if ($_POST['formSubmit'] == "submit") {
        // echo "I'm in the 'if'<br><br>";
        $subject = $_POST['formSubject'];
        $nature = $_POST['formNature'];
        $desc = $_POST['formDesc'];
        $status = $_POST['formStatus'];
    }
    
    if ($_FILES['formFile']['size'] > 0) {
        
        // echo "A file is uploaded";
        $tmpName = $_FILES['formFile']['tmp_name'];
        $newPath = "../uploads/".$_FILES['formFile']['name'];
      
        // print("Temporary file: ".$tmpName."<br>");
        // print("New file: ".$newPath."<br>");
        // print "<br><br>";
    
        move_uploaded_file ($_FILES['formFile']['tmp_name'], "../uploads/{$_FILES['formFile']['name']}");
        
        $file = PodioFile::upload($newPath, $_FILES['formFile']['name']);
        // print_r($file->file_id);
        // print "<br><br>";
    
        PodioItem::create(7881683, array('fields' => array(
            "subject" => $subject,
            "nature-of-ticket" => $nature,
            "description" => $desc,
            "state-of-ticket" => $status), 'file_ids' => array($file->file_id)));
    }
    else {

        // echo "No file was uploaded<br><br>";
                
        PodioItem::create(7881683, array('fields' => array(
            "subject" => $subject,
            "nature-of-ticket" => $nature,
            "description" => $desc,
            "state-of-ticket" => $status)));

        // $newItem = PodioItem::get($newItemId);
        // $newItem = PodioItem::get(148281459);
        // $newItem = PodioItem::get(148171020);
        
        // print $newItem->field('subject')->humanized_value()."<br>";
        // print $newItem->field('nature-of-ticket')->humanized_value()."<br>";
        // print $newItem->field('description')->humanized_value()."<br>";
        // print $newItem->field('state-of-ticket')->humanized_value()."<br>";
                
    }
    
?>