<!DOCTYPE html>
<!--
Category View - shows a lists of products by category
-->
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $type; ?> Products | Acme, Inc.</title>
        <link href="/acme/css/acme.css" type="text/css" rel="stylesheet" media="screen">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <div class='logofile'>
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            </div>
            <nav>
                <?php echo $navList; ?>
            </nav>
        </header>
        <main>
            <h1><?php echo $type; ?> Products</h1>
            <?php if(isset($message)){ echo $message; } ?>
            <?php if(isset($prodDisplay)){ echo $prodDisplay; } ?>
        </main>
        <footer> 
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/category.php")); ?> </p>
        </footer>
    </body>
</html>

