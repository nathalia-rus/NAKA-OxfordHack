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

            /* Appending input sentence into the div element */
            data = JSON.parse(json,true);
            message = data.DisplayText;
            
            /* If the message is empty do not display it */
            if (message == undefined)
                return;
            
            $("#speach").append(message + " ");

            /* Checking if input sentence contains any previously unmentioned symptoms 
               and adding them to the list of symptoms
            */
            for (var i=0; i < symptoms.length; i++) {
                if (message.toLowerCase().indexOf(symptoms[i]) >= 0 && (jQuery.inArray(symptoms[i], mentioned_symptoms) == -1)) {
                    mentioned_symptoms.push(symptoms[i]);
                    $("#symptoms").append(buildBadge(symptoms[i],i));
                }
            }

        }

        function OnComplete() {
            startBtn.disabled = false;
            stopBtn.disabled = true;
            if (isListening == true)
                $("#startBtn").click();
        }
