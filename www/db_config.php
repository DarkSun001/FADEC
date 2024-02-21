<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $POSTGRES_DB = $_POST["POSTGRES_DB"];
    $POSTGRES_USER = $_POST["POSTGRES_USER"];
    $POSTGRES_PASSWORD = $_POST["POSTGRES_PASSWORD"];

    // Read the existing .env file
    $envContents = file_get_contents('.env');

    // Use a regular expression to replace existing PostgreSQL variables
    $envContents = preg_replace(
        [
            '/^POSTGRES_DB=.*/m',
            '/^POSTGRES_USER=.*/m',
            '/^POSTGRES_PASSWORD=.*/m'
        ],
        [
            "POSTGRES_DB=$POSTGRES_DB",
            "POSTGRES_USER=$POSTGRES_USER",
            "POSTGRES_PASSWORD=$POSTGRES_PASSWORD"
        ],
        $envContents
    );

    // Write the updated .env file
    file_put_contents('.env', $envContents);
    
    // Inform the user that the configuration has been updated
    echo "PostgreSQL configuration updated successfully!";
}
?>
