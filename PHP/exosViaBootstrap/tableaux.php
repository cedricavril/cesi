<?php 
// exercice reprenant les include, traitement de fichiers, et sessions.
// après soumission du formulaire, si l'utilisateur a saisi un nick, son nick et son message sont enregistrés dans le fichier tchatLog.txt et affichés.

    $tablalChiensChats = [
        "chiens" => [
            "nom" => "Chien Nom 1",
            "age" => 1
        ],
        "chats" => [
            "nom" => "Chat Nom 1",
            "age" => 1
        ],
[
            "nom" => "Chat Nom 2",
            "age" => 2
        ],
[
            "nom" => "Chat Nom 3",
            "age" => 3
        ],
    ];


    include 'inc/header.php';


$col1 = $tablalChiensChats['chiens'];
$col2 = $tablalChiensChats['chats'];

?>




    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <h1 class="jumbotron">chiens et chats</h1>
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2" class="small">Chiens</th>
                            <th colspan="2" class="small">Chats</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
foreach ($tablalChiensChats as $key1 => $value1) { 
    foreach ($tablalChiensChats as $key2 => $value2) {
 ?>
                        <tr class="odd">
                                <td class="center"><?php echo $key ?></td><td class="center"><?php echo $value ?></td>
                                <td class="center"><?php echo $key ?></td><td class="center"><?php echo $value ?></td>
                        </tr>
                            <?php 
} } ?>
                            <?php foreach ($tablalChiensChats['chats'] as $key => $value) { ?>
                        <tr class="odd">
                                <td class="center"><?php echo $key ?></td><td class="center"><?php echo $value ?></td>
                        </tr>
                            <?php } ?>
                    </tbody>
                </table>
            <hr>
        </div>
        <!-- Formulaire -->
        <div class="well">
        </div>
    </div>
<?php 
    include 'inc/footer.php';
?>
