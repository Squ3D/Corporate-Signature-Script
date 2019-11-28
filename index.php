<?php
if (!empty($_REQUEST['Sender'])):
    //Stockage des cookie pour la requête
    $sender = $_REQUEST['Sender'];

    //Déclaration du chemin d'accées du Layout (Structure de la page)
    $layout = file_get_contents('./SIG/SEE.html', FILE_USE_INCLUDE_PATH);
    $layout1 = file_get_contents('./SIG/GUIL.html', FILE_USE_INCLUDE_PATH);
    $layout2 = file_get_contents('./SIG/SAELEN.html', FILE_USE_INCLUDE_PATH);
    $layout3 = file_get_contents('./SIG/SEEPROD.html', FILE_USE_INCLUDE_PATH);

    if(isset($_POST['select']))
    {
        if($_POST['select'] == 'value2')
        {
            $layout = $layout1;

        }
        if($_POST['select'] == 'value3') {
        $layout = $layout2;
    }
    if($_POST['select'] == 'value4') {
        $layout = $layout3;
                                   } 
  
                                       }



    foreach ($sender as $key => $value) {
        $key         = strtoupper($key);
        $start_if    = strpos($layout, '[[IF-' . $key . ']]');
        $end_if      = strpos($layout, '[[ENDIF-' . $key . ']]');
        $length      = strlen('[[ENDIF-' . $key . ']]');
        if (!empty($value)) {
            // Add the value at its proper location.
            $layout = str_replace('[[IF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[ENDIF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[' . $key . ']]', $value, $layout);
        } elseif (is_numeric($start_if)) {
            // Remove the placeholder and brackets if there is an if-statement but no value.
            $layout = str_replace(substr($layout, $start_if, $end_if - $start_if + $length), '', $layout);
        } else {
            // Remove the placeholder if there is no value.
            $layout = str_replace('[[' . $key . ']]', '', $layout);
        }
    }

    // Clean up any leftover placeholders. This is useful for booleans,
    // which are not submitted if left unchecked.
    $layout = preg_replace("/\[\[IF-(.*?)\]\]([\s\S]*?)\[\[ENDIF-(.*?)\]\]/u", "", $layout);

    if (!empty($_REQUEST['download'])) {
        header('Content-Description: File Transfer');
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename=SEEsignature.html');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    }

    echo $layout;
else:

    ?>
    
    <!-- Nous utilisons le Framework BootStrap pour le CSS !-->

    <!DOCTYPE html>
    <html lang="fr">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Naïm Gallouj, Julien Guislain-Pawloski">

        <title>SEE Mail Signature</title>

        <!-- Bootstrap core CSS -->
        <link href="./style.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <style type="text/css">
            /* Sticky footer styles
            -------------------------------------------------- */

            html,
            body {
                height: 100%;
                font-family: Arial;
                /* The html and body elements cannot have any padding or margin. */
            }

            /* Wrapper for page content to push down footer */
            #wrap {
                min-height: 100%;
                height: auto !important;
                height: 100%;
                /* Negative indent footer by its height */
                margin: 0 auto -60px;
                /* Pad bottom by footer height */
                padding: 0 0 60px;
            }

            /* Set the fixed height of the footer here */
            #footer {
                height: 60px;
                background-color: #f5f5f5;
            }


            /* Custom page CSS
            -------------------------------------------------- */
            /* Not required for template or sticky footer method. */

            #wrap > .container {
                padding: 60px 15px 0;
            }
            .container .credit {
                margin: 20px 0;
            }

            #footer > .container {
                padding-left: 15px;
                padding-right: 15px;
            }
            .btn.btn-primary {
                color: #fff !important;
                background-color: #3f7644 !important;
            }
            .btn.btn-default{
                color: #3f7644 !important;
            }
            code {
                font-size: 80%;
            }

            .siggy{
                font-weight: bold;
                font-family: Helvetica;
            }
        </style>

    </head>

    <body>
    <div id="wrap">
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <img src="https://julienguislain.files.wordpress.com/2019/11/see-2019v2-inverse-1.png" width="75" height="35"></a>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="page-header">
                <h1>Generate a Signature for your Email !</h1>
            </div>
            <form class="form-horizontal" role="form" method="post" target="preview" id="form">

                <div class="form-group">
                    <label for="Name" class="control-label col-xs-2">Company</label>

                    <div class="col-xs-10">
                        <select name="select" class="form-control" id="sel1">
                            <option value="value1">SEE</option>
                            <option value="value2">Guillebert</option>

                            <option value="value3">Saelen</option>
                            <option value="value4">SEE Produktion</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Name" class="control-label col-xs-2"> Firstname </label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" id="NOM" name="Sender[name1]" placeholder="Enter your firstname" required="true">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Name"  class="control-label col-xs-2">Name </label>
                    <div class="col-xs-10">
                        <input type="text"  onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="PRENOM" name="Sender[name]" placeholder="Enter your name" required="true">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Name" class="control-label col-xs-2"> Job</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" id="POSITION" name="Sender[position]" placeholder="Enter your position" required="true">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Name" class="control-label col-xs-2">Email</label>
                    <div class="input-group col-xs-10">
                        <input type="text" class="form-control" id="Email" name="Sender[email]" placeholder="Enter your email adress" aria-describedby="basic-addon2" required="true">
                        <span class="input-group-addon" id="basic-addon2"></span>
                    </div>
                </div>


                <div class="form-group">
                    <label for="Mobile" class="control-label col-xs-2">Phone (Office)</label>
                    <div class="input-group col-xs-10">
                        <input type="phone" class="form-control" id="Mobile1" name="Sender[mobile1]" placeholder="Enter your Phone number" required="true">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Mobile" class="control-label col-xs-2">Mobile / Fax</label>
                    <div class="input-group col-xs-10">
                        <input type="phone" class="form-control" id="Mobile" name="Sender[mobile]" placeholder="Enter your mobile phone number" required="true">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <button id="preview" type="submit" class="btn btn-primary">Preview</button>
                            <button id="download" class="btn btn-default">Download</button>
                            <input type="hidden" name="download" id="will-download" value="">
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center siggy">
                        Preview (Prévisualisation de la Signature)
                    </div>
                </div>
            </div>
           <iframe src="about:blank" name="preview" width="100%" height="300"></iframe> 
        </div>

    </div>

    <div id="footer">
        <div class="container">
            <p class="text-muted credit">Copyright Service Informatique ©2019 GroupeSEE
            </p>
        </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $("#download").bind( "click", function() {
                $('#will-download').val('true');
                $('#form').removeAttr('target').submit();
            });

            $("#preview").bind( "click", function() {
                $('#will-download').val('');
                $('#form').attr('target','preview');
            });

        });
    </script>
    </body>
    </html>
<?php endif;