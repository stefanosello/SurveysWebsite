<?php
include("cambia.php");
include("Utility/PHPHelper.php");

$helper = new PHPHelper();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sondaggi - Area Amministrazione</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://ss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        #placeholder { width: 80%; height: 500px; }
    </style>
    <!-- Inclusione delle librerie flot  -->
    <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
</head>

<body>
    

    <!--<div id="wrapper">-->
        

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Area Utente</a>
            </div>
            <!-- Top Menu Items -->
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Sondaggio <small>Compila il sondaggio sottostante</small>
                        </h1>
                        
                    </div>
                </div>
                

                
                <!-- /.row -->

                <div class="row">
                    <!-- Codice qui -->
                    <?php
                        $codice = mysql_real_escape_string($_REQUEST['codice']);
                        
                        if(!isset($_GET['codice']))
                        {
                            echo ("Errore! ID Questionario non valido!");
                            exit();
                        }
                            //Genera un form per quel sondaggio
                        $idQuest = $helper->GetIDQuestionarioFromCodice($codice);
                        
                        if($idQuest==null)
                        {
                            echo ("Errore! Nessun questionario trovato oppure questionario già svolto!");
                            exit();
                        }
                        
                        $idQuestionario = mysql_fetch_array($idQuest);
                        
                        $questionario = $helper->OttieniSondaggioByID($idQuestionario['questionario']);
                        
                        $questionario_fetch = mysql_fetch_array($questionario);
                        
                        echo ' <div class="panel panel-primary" style="width:80%">
                            <div class="panel-heading">
                                <h3 class="panel-title">Compila sondaggio</h3>
                            </div>
                            
                            <div class="panel-body">
                        <form role="form" action="inserisci_risultati.php?codice='.$codice.'" method="post">';
                        
                        $domande = $helper->OttieniDomandeQuestionario($questionario_fetch['id_questionario']);
                        
                        if($domande != null)
                        {
                            foreach($domande as $domanda)
                            {
                                echo '<div class="form-group" style="width:50%">
                                <label>'.$domanda->testo_domanda.'</label><br>';
                                
                                $risposte = $helper->OttieniRispostePossibiliByID($domanda->id);
                                if($risposte != null)
                                {
                                    
                                        //Gestiamo domande S/N separatamente
                                        foreach($risposte as $risposta)
                                        {
                                            $testo = "";
                                            if($risposta->testo_risposta == "SI")
                                            {
                                                
                                            }
                                            if($domanda->risp_multipla == 1)
                                            {
                                                echo '<label class="checkbox-inline"><input type="checkbox" name="risposta_'.$risposta->id.'">'.$risposta->testo_risposta.'</label><br><br>';
                                            }else{
                                                echo '<label class="radio-inline"><input type="radio" name="radio_risposta_'.$domanda->id.'" value="risposta_'.$risposta->id.'">'.$risposta->testo_risposta.'</label><br><br>';
                                            }
                                        }
                                    
                                }
                                echo '</div>';
                            }
                        }
                        echo '<input type="submit"/>';
                        echo '</form>
                    </div>
                    </div>';
                    ?>
                </div>
                <!-- /.row -->

                
                    
                    
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>
    <script src="flot/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="flot/jquery.flot.categories.js"></script>

</body>

</html>
