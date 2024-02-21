<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $baseUrl = $_ENV['LOCALHOST_URL'];
    $baseUrlClean = $_ENV['LOCALHOST_URL2'];
} else {
    $baseUrl = $_ENV['PROD_URL'];
    $baseUrlClean = $_ENV['PROD_URL2'];
}

$output = shell_exec('docker ps');
echo $output;


?>



<h2>Configure PostgreSQL</h2>
<form action="configure_postgres.php" method="post">
    <label for="POSTGRES_DB">Database Name:</label>
    <input type="text" name="POSTGRES_DB" value="<?= getenv('POSTGRES_DB') ?>" required><br>

    <label for="POSTGRES_USER">Username:</label>
    <input type="text" name="POSTGRES_USER" value="<?= getenv('POSTGRES_USER') ?>" required><br>

    <label for="POSTGRES_PASSWORD">Password:</label>
    <input type="password" name="POSTGRES_PASSWORD" value="<?= getenv('POSTGRES_PASSWORD') ?>" required><br>

    <input type="submit" value="Save">
</form>


<script>
    var baseUrlClean = '<?= $baseUrlClean ?>';

    var configUrl = baseUrlClean + "db_config.php";
    console.log(configUrl);

    var form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        fetch(configUrl, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
            });
    });
</script>