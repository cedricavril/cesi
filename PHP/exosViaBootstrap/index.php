<?php
// exercice reprenant les include, traitement de fichiers, et sessions.
// après soumission du formulaire, si l'utilisateur a saisi un nick, son nick et son message sont enregistrés dans le fichier tchatLog.txt et affichés.

    include 'inc/header.php';

    $nick = $_POST['nick'];
    
    // variable nick à afficher prend celle de la variable de session si elle existe
    $nick = isset($_SESSION['nick']) ? $_SESSION['nick'] : $_POST['nick'];

    // initialisation de la variable session nick à celle de post si non vide
    $_SESSION['nick'] = ($_POST['nick'] != "") ? $_POST['nick'] : null;

    if(isset($_SESSION['nick'])) {
        $message = $_POST['message'];
        // ajouter le dernier message posté avec le nick dans le fichier tchatLog.txt
        $tchatFile = fopen("tchatLog.txt", "a");
        fwrite($tchatFile, "$nick : $message<br/>");
        fclose($tchatFile);
        $disabling = "readonly";
    }
?>

<!-- à faire : focus à mettre selon les post -->


    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <h1 class="jumbotron">Tchat</h1>
            <hr>
        </div>
        <!-- Formulaire -->
        <form method="post" class="navbar-form navbar-right inline-form">
                <div class="form-group">
                    <div class="input-group col-xs-1">
                        <input name="nick" id="nick" type="text" class="input-sm form-control" <?php echo $disabling; ?> placeholder="Nick" value="<?php 


                        // on remplit le champ de pseudo de la variable le contenant éventuellement
                        echo $nick;



                        ?>">
                        <input name="message" id="message" type="text" class="input-sm form-control" placeholder="Message">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary btn-sm text-capitalize"><span class="glyphicon glyphicon-pencil"></span> écrire</button>
                        </span>
                    </div>
                </div>
        </form>
        <div class="well">
        <?php 
            // affichage de l'intégralité du fichier
            echo file_get_contents("tchatLog.txt");
        ?>
        </div>
    </div>
<?php 
    include 'inc/footer.php';
?>
