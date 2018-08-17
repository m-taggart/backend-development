<!DOCTYPE html>
<!--
Acme Template
-->
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title> ACME Template</title>
        <link href="/acme/css/acme.css" type="text/css" rel="stylesheet" media="screen">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <div class='logofile'>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            </div>
            <nav>
                <!--?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/nav.php'; ?-->
                <?php echo $navList; ?>
            </nav>
        </header>
        <main>
            <h1> Content Title Here </h1>
        </main>
        <footer> 
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            <p><?php echo "Last modified: " . date("F d, Y", filemtime("acme.php")); ?> </p>
        </footer>
    </body>
</html>

