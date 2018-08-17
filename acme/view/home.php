<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title> ACME </title>
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
            <h1> Welcome to Acme! </h1>
            <div class="ad">
                <img class="backimage" src="/acme/images/site/rocketfeature.jpg" alt="Cartoon bunny lighting a rocket.">
                <!--Hero description text-->
                <div class="redtext">
                    <ul class="top">
                        <li><h2>Acme Rocket</h2></li>
                        <li>Quick lighting fuse</li>
                        <li>NHTSA approved seat belts</li>
                        <li>Mobile launch stand included</li>
                        <li><a href="#/acme/cart/"><img id="actionbtn" alt="Add to cart button" src="/acme/images/site/iwantit.gif"></a></li>
                    </ul>
                </div>
            </div>
            <!--Hero Product Review text-->
            <div class="rocketrecipesandreviews">
                <div class="rocketreviews">
                    <h2>Acme Rocket Reviews</h2>
                    <ul class="reviews">
                        <li>"I don't know how I ever caught roadrunners before this." (4/5)</li>
                        <li>"That thing was fast!" (4/5)</li>
                        <li>"Talk about fast delivery." (5/5)</li>
                        <li>"I didn't even have to pull the meat apart." (4.5/5)</li>
                        <li>"I'm on my thirtieth one. I love these things!" (5/5)</li>
                    </ul>
                </div>

                <!--Recipe Text-->
                <div class="rocketrecipes">
                    <h2 class="">Featured Recipes</h2>
                    <div class="allrecipes">
                        <div class="recipes">
                            <a href="#/pulledbbq">
                                <img class="bbq" src="/acme/images/recipes/bbqsand.jpg" alt="Pulled BBQ Sandwich">
                                Pulled Roadrunner BBQ</a>
                            <a href="#/roadrunnerpotpie">
                                <img class="potpie" src="/acme/images/recipes/potpie.jpg" alt="Pot Pie">                       
                                Roadrunner Pot Pie</a>
                        </div>
                        <div class="recipes2">
                            <a href="#/roadrunnersoup">                     
                                <img class="soup" src="/acme/images/recipes/soup.jpg" alt="Roadrunner Soup">
                                Roadrunner Soup</a>
                            <a href="#/roadrunnertacos">
                                <img class="tacos" src="/acme/images/recipes/taco.jpg" alt="Roadrunner Tacos">     
                                Roadrunner Tacos</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer> 
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            <p><?php echo "Last modified:" . " " . date("F d, Y", filemtime('index.php')); ?> </p>
        </footer>
    </body>
</html>



