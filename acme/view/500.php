<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title> ACME Error</title>
        <link href="/acme/css/acme.css" type="text/css" rel="stylesheet" media="screen">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <div class='logofile'>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            </div>
            <nav>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/nav.php'; ?>
            </nav>
        </header>
        <main>
            <h1>Server Error</h1>
            <h2>Sorry, the server experienced a problem.</h2>
        </main>
        <footer> 
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            <p><?php echo "Last modified:" . " " . date("F d, Y", filemtime("../view/500.php")); ?> </p>
        </footer>
    </body>
</html>

