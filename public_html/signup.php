<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Forum Registration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="application-name" content="Forum">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300|Saira+Condensed|Yanone+Kaffeesatz" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="lib.css">
    </head>
    <body>
        <div class="jumbotron-fluid top-decor theme center">
            <header class="ucase h-center">forum registration</header>
            <form class="form-control" method="post" action="forum/register.php">
                <input class="form-control theme" type="text" name="firstname" placeholder="Your Firstname..." spellcheck="false">
                <input class="form-control theme" type="text" name="lastname" placeholder="Your Lastname..." spellcheck="false">
                <input class="form-control theme" type="text" name="username" placeholder="Your Username..." spellcheck="false">
                <input class="form-control theme" type="email" name="email" placeholder="Your Email..." spellcheck="false">
                <div class="password-control">
                    <input class="form-control theme" type="password" name="password" placeholder="Your Password...">
                    <span class="revealer"></span>
                </div>
                <button type="submit" class="btn btn-medium h-center">sign up</button>
            </form>
        </div>
        <script src="lib.js"></script>
    </body>
</html>