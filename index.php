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

    <!-- SDK USAGE -->
    <script>
        // On document load resolve the SDK dependency
        function Initialize(onComplete) {
            require(["Speech.Browser.Sdk"], function(SDK) {
                onComplete(SDK);
            });
        }

        // Setup the recognizer
        function RecognizerSetup(SDK, recognitionMode, language, format, subscriptionKey) {

            switch (recognitionMode) {
                case "Interactive" :
                    recognitionMode = SDK.RecognitionMode.Interactive;    
                    break;
                case "Conversation" :
                    recognitionMode = SDK.RecognitionMode.Conversation;    
                    break;
                case "Dictation" :
                    recognitionMode = SDK.RecognitionMode.Dictation;    
                    break;
                default:
                    recognitionMode = SDK.RecognitionMode.Interactive;
            }

            var recognizerConfig = new SDK.RecognizerConfig(
                new SDK.SpeechConfig(
                    new SDK.Context(
                        new SDK.OS(navigator.userAgent, "Browser", null),
                        new SDK.Device("SpeechSample", "SpeechSample", "1.0.00000"))),
                recognitionMode,
                language, // Supported languages are specific to each recognition mode. Refer to docs.
                format); // SDK.SpeechResultFormat.Simple (Options - Simple/Detailed)


            var useTokenAuth = false;

            var authentication = function() {
                if (!useTokenAuth)
                    return new SDK.CognitiveSubscriptionKeyAuthentication(subscriptionKey);

                var callback = function() {
                    var tokenDeferral = new SDK.Deferred();
                    try {
                        var xhr = new(XMLHttpRequest || ActiveXObject)('MSXML2.XMLHTTP.3.0');
                        xhr.open('GET', '/token', 1);
                        xhr.onload = function () {
                            if (xhr.status === 200)  {
                                tokenDeferral.Resolve(xhr.responseText);
                            } else {
                                tokenDeferral.Reject('Issue token request failed.');
                            }
                        };
                        xhr.send();
                    } catch (e) {
                        window.console && console.log(e);
                        tokenDeferral.Reject(e.message);
                    }
                    return tokenDeferral.Promise();
                }

                return new SDK.CognitiveTokenAuthentication(callback, callback);
            }();

            var files = document.getElementById('filePicker').files;
            if (!files.length) {
                return SDK.CreateRecognizer(recognizerConfig, authentication);
            } else {
                return SDK.CreateRecognizerWithFileAudioSource(recognizerConfig, authentication, files[0]);
            }
        }

        // Start the recognition
        function RecognizerStart(SDK, recognizer) {
            recognizer.Recognize((event) => {
                /*
                 Alternative syntax for typescript devs.
                 if (event instanceof SDK.RecognitionTriggeredEvent)
                */
                console.log("top swotcj");
                switch (event.Name) {
                    case "RecognitionTriggeredEvent" :
                        UpdateStatus("Initializing");
                        break;
                    case "ListeningStartedEvent" :
                        UpdateStatus("Listening");
                        break;
                    case "RecognitionStartedEvent" :
                        UpdateStatus("Listening_Recognizing");
                        break;
                    case "SpeechStartDetectedEvent" :
                        UpdateStatus("Listening_DetectedSpeech_Recognizing");
                        console.log(JSON.stringify(event.Result)); // check console for other information in result
                        break;
                    case "SpeechHypothesisEvent" :
                        UpdateRecognizedHypothesis(event.Result.Text, false);
                        console.log(JSON.stringify(event.Result)); // check console for other information in result
                        break;
                    case "SpeechFragmentEvent" :
                        UpdateRecognizedHypothesis(event.Result.Text, true);
                        console.log(JSON.stringify(event.Result)); // check console for other information in result
                        break;
                    case "SpeechEndDetectedEvent" :
                        OnSpeechEndDetected();
                        UpdateStatus("Processing_Adding_Final_Touches");
                        console.log(JSON.stringify(event.Result)); // check console for other information in result
                        break;
                    case "SpeechSimplePhraseEvent" :
                        UpdateRecognizedPhrase(JSON.stringify(event.Result, null, 3));
                        break;
                    case "SpeechDetailedPhraseEvent" :
                        UpdateRecognizedPhrase(JSON.stringify(event.Result, null, 3));
                        break;
                    case "RecognitionEndedEvent" :
                        OnComplete();
                        UpdateStatus("Idle");
                        break;
                    default:
                        console.log(JSON.stringify(event)); // Debug information
                }
            })
                .On(() => {
                // The request succeeded. Nothing to do here.
            },
                    (error) => {
                console.error(error);
            });
        }

        // Stop the Recognition.
        function RecognizerStop(SDK, recognizer) {
            // recognizer.AudioSource.Detach(audioNodeId) can be also used here. (audioNodeId is part of ListeningStartedEvent)
            recognizer.AudioSource.TurnOff();
        }
    </script>
    <!-- Browser Hooks -->
    <script>
        var isListening = false;
        var startBtn, stopBtn, hypothesisDiv, phraseDiv, statusDiv;
        var key, languageOptions, formatOptions, recognitionMode, inputSource, filePicker;
        var SDK;
        var recognizer;
        var previousSubscriptionKey;

        document.addEventListener("DOMContentLoaded", function () {
            createBtn = document.getElementById("createBtn");
            startBtn = document.getElementById("startBtn");
            stopBtn = document.getElementById("stopBtn");
            phraseDiv = document.getElementById("phraseDiv");
            hypothesisDiv = document.getElementById("hypothesisDiv");
            statusDiv = document.getElementById("statusDiv");
            key = document.getElementById("key");
            languageOptions = document.getElementById("languageOptions");
            formatOptions = document.getElementById("formatOptions");
            inputSource = document.getElementById("inputSource");
            recognitionMode = document.getElementById("recognitionMode");
            filePicker = document.getElementById('filePicker');

            languageOptions.addEventListener("change", Setup);
            formatOptions.addEventListener("change", Setup);
            recognitionMode.addEventListener("change", Setup);


            startBtn.addEventListener("click", function () {
                isListening = true;
                if (key.value == "" || key.value == "YOUR_BING_SPEECH_API_KEY") {
                    alert("Please enter your Bing Speech subscription key!");
                    return;
                }
                if (inputSource.value === "File") {
                    filePicker.click();
                } else {
                    if (!recognizer || previousSubscriptionKey != key.value) {
                        previousSubscriptionKey = key.value;
                        Setup();
                    }

                    hypothesisDiv.innerHTML = "";
                    phraseDiv.innerHTML = "";
                    RecognizerStart(SDK, recognizer);
                    startBtn.disabled = true;
                    stopBtn.disabled = false;
                }                
            });

            key.addEventListener("focus", function () {
                if (key.value == "YOUR_BING_SPEECH_API_KEY") {
                    key.value = "";
                }
            });

            key.addEventListener("focusout", function () {
                if (key.value == "") {
                    key.value = "YOUR_BING_SPEECH_API_KEY";
                }
            });

            filePicker.addEventListener("change", function () {
                Setup();
                hypothesisDiv.innerHTML = "";
                phraseDiv.innerHTML = "";
                RecognizerStart(SDK, recognizer);
                startBtn.disabled = true;
                stopBtn.disabled = false;
                filePicker.value = "";
            });

            stopBtn.addEventListener("click", function () {
                isListening = false;
                RecognizerStop(SDK, recognizer);
                startBtn.disabled = false;
                stopBtn.disabled = true;
            });

            Initialize(function (speechSdk) {
                SDK = speechSdk;
                startBtn.disabled = false;
            });
        });

        function Setup() {
            if (recognizer != null) {
                RecognizerStop(SDK, recognizer);
            }
            recognizer = RecognizerSetup(SDK, recognitionMode.value, languageOptions.value, SDK.SpeechResultFormat[formatOptions.value], key.value);
        }

        function UpdateStatus(status) {
            statusDiv.innerHTML = status;
        }

        function UpdateRecognizedHypothesis(text, append) {
            if (append) 
                hypothesisDiv.innerHTML += text + " ";
            else {
                hypothesisDiv.innerHTML = text;
            }



            var length = hypothesisDiv.innerHTML.length;
            if (length > 403) {
                hypothesisDiv.innerHTML = "..." + hypothesisDiv.innerHTML.substr(length-400, length);
            }
        }

        function OnSpeechEndDetected() {
            stopBtn.disabled = true;
        }

        function UpdateRecognizedPhrase(json) {
            hypothesisDiv.innerHTML = "";
            phraseDiv.innerHTML += json + "\n";

            data = JSON.parse(json,true);
            $("#speach").append(data.DisplayText + " ");

        }

        function OnComplete() {
            startBtn.disabled = false;
            stopBtn.disabled = true;
            if (isListening == true)
                $("#startBtn").click();
        }
    </script>

    <script>
        $(".button-run").click(function() {
            if (isListening == false)
                $("#startBtn").click();
            else 
                $("#stopBtn").click();
        });
    </script>

</html>