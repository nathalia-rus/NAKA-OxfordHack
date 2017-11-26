<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../../../favicon.ico">

        <title>Bottom navbar example for Bootstrap</title>

        <link href="static/css/bootstrap.css" rel="stylesheet">
        <link href="static/css/starter-template.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


        <style>
            @media screen and (min-width: 768px) {
                .modal-dialog {
                    width: 700px; /* New width for default modal */
                }
                .modal-sm {
                    width: 350px; /* New width for small modal */
                }
            }
            @media screen and (min-width: 992px) {
                .modal-lg {
                    width: 950px; /* New width for large modal */
                }
            }

        </style>
    </head>

    <body>
        <main role="main">

            <!-- Hidden config table -->
            <table style="display:none;" id="settings" width="100%">
                <tr>
                    <td></td>
                    <td>
                        <h1 style="font-weight:500;">Speech Recognition</h1>
                        <h2 style="font-weight:500;">Microsoft Cognitive Services</h2>
                    </td>
                </tr>
                <tr>
                    <td align="right"><a href="https://www.microsoft.com/cognitive-services/en-us/sign-up" target="_blank">Subscription</a>:</td>
                    <td><input id="key" type="text" size="40" value="57311ec19665421e9456f8db9b01d7ca"></td>
                </tr>
                <tr>
                    <td align="right">Language:</td>
                    <td align="left">
                        <select id="languageOptions">
                            <option value="zh-CN">Chinese - CN</option>
                            <option value="en-GB">English - GB</option>
                            <option value="en-US" selected="selected">English - US</option>
                            <option value="fr-FR">French - FR</option>
                            <option value="de-DE">German - DE</option>
                            <option value="it-IT">Italian - IT</option>
                            <option value="es-ES">Spanish - ES</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">Recognition Mode:</td>
                    <td align="left">
                        <select id="recognitionMode">
                            <option value="Interactive">Interactive</option>
                            <option value="Conversation">Conversation</option>
                            <option value="Dictation">Dictation</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">Format:</td>
                    <td align="left">
                        <select id="formatOptions">
                            <option value="Simple" selected="selected">Simple Result</option>
                            <option value="Detailed">Detailed Result</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">Input:</td>
                    <td align="left">
                        <select id="inputSource">
                            <option value="Mic" selected="selected">Microphone</option>
                            <option value="File">Audio File</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button id="startBtn" disabled="disabled">Start</button>
                        <button id="stopBtn" disabled="disabled">Stop</button>
                        <input type="file" id="filePicker" accept=".wav" style="display:none"/>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <table>
                            <tr>
                                <td>Results:</td>
                                <td>Current hypothesis:</td>
                            </tr>
                            <tr>
                                <td>
                                    <textarea id="phraseDiv" style="display: inline-block;width:500px;height:200px"></textarea>
                                </td>
                                <td style="vertical-align: top">
                                    <span id="hypothesisDiv" style="width:200px;height:200px;display:block;"></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="right">Status:</td>
                    <td align="left"><span id="statusDiv"></span></td>
                </tr>
            </table>
            <!-- End of hidden config table -->

            <div class="container">
                <div class="starter-template">
                    <img src="static/img/logo.png">
                </div>
            </div>
            <div class="container">
                <div class="onoffswitch">
                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox button-run" id="myonoffswitch" unchecked>
                    <label class="onoffswitch-label" for="myonoffswitch">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="display-4">Speech </h1><hr>
                        <div id="speach"></div>
                    </div>

                    <div class="col-sm-6">
                        <h1 class="display-4">Symptoms </h1><hr>
                        <div id="symptoms"></div>
                    </div>
                </div>

                <div clas="row" id="suggestedLit">
                    <h1 class="display-4">Suggested literature </h1><hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card literature" number="1">
                                <div class="card-body">
                                    <h4 class="card-title">Special title treatment</h4>
                                    <div class="card-body">
                                        <a href="#" class="card-link" number="0">More info</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card literature" number="2">
                                <div class="card-body">
                                    <h4 class="card-title">Special title treatment</h4>
                                    <div class="card-body">
                                        <a href="#" class="card-link" number="1">More info</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card literature" number="3">
                                <div class="card-body">
                                    <h4 class="card-title">Special title treatment</h4>
                                </div>
                                <div class="card-body">
                                    <a href="#" class="card-link" number="2">More info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="temp">
                    </div>
                </div>
            </div>

            <!--            Modal data-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width:1250px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id='exampleModalBody'>
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a target="_blank" class="btn btn-primary" id="ModalLinkArticle" href="#" role="button">Full Article</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </body>





    <!-- Bootstrap core JavaScript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="static/js/popper.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>

    <!-- The SDK has a dependency on requirejs (http://requirejs.org/). -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/require.js/2.3.3/require.min.js"></script>

    <!-- SDK REFERENCE -->
    <script src="distrib/speech.browser.sdk.js"></script>

    <!-- Generated list of symptoms -->
    <script src="static/js/symptoms.js"></script>
    <script>
        // Array containing all mentioned symptoms
        var mentioned_symptoms = [];

        // Generating badges for different diseases with different bootstrap class names
        function buildBadge(title, i) {
            var n = i % class_styles.length;    
            return '<span class="badge badge-'+class_styles[n]+'"><h5>'+title+'</h5></span> ';
        }

        var output = 0;

        function updateSuggestions(out) {
            test = 2;
            /* Number of entries to return */
            var RETURN_ENTRIES = 6;
            /* Earliest publication data */
            var MIN_YEAR = 2010;
            /* Latest publication date */
            var MAX_YEAR = 2017;

            var lookuplist = "";
            for(var i=0; i<mentioned_symptoms.length; i++) {
                lookuplist = mentioned_symptoms[i] + "," + lookuplist;
            }

            console.log(lookuplist);

            /*
                Call Mendeley API to obtain relevent research articles
            */
            $.get( "mendeley/curl.php", { number: RETURN_ENTRIES, words: lookuplist, miny: "2010", maxy: MAX_YEAR } )
                .done(function( data ) {
                //console.log(data);
                output = JSON.parse(data);
                out = output;
                /*
                for(var i=0; i < output.length; i++) {
                    $("#temp").append(output[i]['title'] + "<br><br> ");
                }
                */

                $( ".literature" ).each(function( index ) {
                    $(".card-title").eq(index).text(output[index]['title']);
                    //$(this).fadeOut();
                    console.log( index + ": " + $( this ).text() );
                });

            });
        }
    </script>

    <!-- SDK USAGE -->
    <script src="static/js/microsoft-sdk-action.js"></script>

    <script>
        $("#suggestedLit").hide();

        $(".button-run").click(function() {
            if (isListening == false)
                $("#startBtn").click();
            else 
                $("#stopBtn").click();
        });

        $(".card-link").click(function(){
            //alert($(this).attr("number"));
            var id = $(this).attr("number");
            console.log(output[id]['title']);
            $("#exampleModalLabel").text(output[id].title);
            $("#exampleModalBody").text(output[id].abstract);
            $("#ModalLinkArticle").attr("href", output[id].link);
            $("#exampleModal").modal();

        });
    </script>

</html>
