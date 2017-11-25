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
            #btn-close-modal {
                width:100%;
                text-align: center;
                cursor:pointer;
                color:#fff;
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
    </script>

    <!-- SDK USAGE -->
    <script src="static/js/microsoft-sdk-action.js"></script>

    <script>
        $(".button-run").click(function() {
            if (isListening == false)
                $("#startBtn").click();
            else 
                $("#stopBtn").click();
        });
    </script>

</html>