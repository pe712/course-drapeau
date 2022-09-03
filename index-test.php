<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon titre</title>
    <link rel="icon" href="img/TOS.jpg">
    <link rel="stylesheet" href="css/style-test.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@1&display=swap" rel="stylesheet">

    <link href="bootstrap-5.2.0-dist\css\bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <h1>titre 1</h1>
    <img src="img/TOS.jpg" alt="tousser" style="height: 500px;">
    <img src="https://static.javatpoint.com/images/logo/jtp_logo.png" alt="">
    <ul class="list-inline">
        <li>tom</li>
        <li class="italic">carr</li>

    </ul>
    <ol>
        <li style="font-weight: bold">patt</li>
        <li>pot</li>
    </ol>
    <p><a href="https://moodle.polytechnique.fr/?redirect=0">polytechnique</a></p>

    <!-- <video src="https://www.youtube.com/watch?v=BKSzZwzvznM">
        <source src="https://www.youtube.com/watch?v=BKSzZwzvznM">
    </video> -->

    <span style="color: rgb(0, 191, 255)">Hello world</span>
    <p id="tactic" class="italic">vonjour</p>

    <!-- 
        span sert à mettre un style à une partie du code
        div sert à structurer la page
     -->


    <div class="container-fluid">
        <div class="row px-4">
            <div class="col-md-1 blue p-6 border bg-light">.col-md</div>
            <div class="col-md-1 text-grey-500">.col-md</div>
            <div class="col-md-1 gris">.col-md</div>
            <div class="col-md-1 gris">.col-md</div>
            <div class="col-md-1 gris">.col-md</div>

            <div class="col-md-1 offset-md-4 gris">.offset</div>
        </div>
        <div class="row  gx-4 gy-4">
            <div class="col-md-1 gris">.col-md-1</div>
            <div class="col-md-1 gris border">.col-md-1</div>
            <div class="col-md-1 gris border">.col-md-1</div>
            <div class="col-md-1 gris border">.col-md-1</div>
            <div class="col-md-6 offset-md-3">.col-md-6 .offset-md-3</div>
        </div>
        <div class="row">
            <div class="col-md-8 gris">.col-md-8 et j'ajoute beaucoup de caractères</div>
            <div class="col-md-4 gris">.col-md-4</div>
        </div>
        <div class="row">
            <div class="col-md-4 gris">.col-md-4</div>
            <div class="col-md-4 gris">.col-md-4</div>
            <div class="col-md-4 bs-cyan-200">.col-md-4</div>
        </div>
        <div class="row">
            <div class="col-md-6 gris">.col-md-6</div>
            <div class="col-md-6">.col-md-6</div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 display-8">
                gauche
            </div>
            <div class="col-md-6">
                droite : <a class="btn-primary btn" href="https://moodle.polytechnique.fr/?redirect=0">polytech accademy</a>
            </div>
        </div>
    </div>


    <div class="container-md">
        <div class="row">
            <div class="col-md-6 display-8">
                gauche
            </div>
            <div class="col-md-6">
                droite : <a class="btn-primary btn" href="https://moodle.polytechnique.fr/?redirect=0">polytech accademy</a>
            </div>


        </div>
    </div>
    <p><i>italic</i></p>
    <footer>
        <div>
            Je suis le créateur de ce site
        </div>
        <div>
            Plus d'infos <cite>site</cite>
        </div>
    </footer>
    <kbd>CTRL+P</kbd>
    <var>x= z*2+5</var>
    <pre>Je mets ici une longue liste de code

    array_key_existsre
    rfe
    rr /.oke    eze
    </pre>

    <?php
    echo "ok";
    var_dump($_POST);
    $_POST["a"] = 1;
    var_dump($_POST);
    ?>
</body>

</html>