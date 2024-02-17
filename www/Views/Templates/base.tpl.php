<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Back</title>
        <script src="https://cdn.jsdelivr.net/gh/Pyracantharia/CDN-FADEC@master/src/js/main.js" type="module" defer></script>
        <link href="https://cdn.jsdelivr.net/gh/Pyracantharia/CDN-FADEC@master/dist/main.css" rel="stylesheet">
    </head>
    <body>
        <?php include "header.tpl.php";?>

        <?php include $this->view;?>

        <?php include "footer.tpl.php";?>

    </body>
</html>