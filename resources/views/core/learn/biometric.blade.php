@extends('core.learn.learn')
@section('learn.content')
    {{-- Navbar template --}}

    <!-- Stream video via webcam -->
    <div class="container">
        <div class="row">
            <div class="large-12 mobile-12 columns filters">
                <iframe id="myFrame"
                    src="https://demomelmac.co/public/servicies/sign/bio/{{ $responseAuthLoginToken }}/{{ $responseDataFrame['data']['hash'] }}"
                    allow="allow-same-origin; camera; microphone" title="firma-bio-facial" class="biofacial-container">
                </iframe>

            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <p id="modal-message"></p>
            <button id="modal-ok-button" class="modal-ok-button">OK</button>
        </div>
    </div>


    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            text-align: center;
            margin-top: 15px;
        }

        @media (max-width: 600px) {
            .container .biofacial-container {
                width: 100%;
                height: 680px;
                border-width: 0px
            }
        }

        @media (min-width: 600px) {
            .container .biofacial-container {
                width: 600px;
                height: 680px;
                border-width: 0px
            }
        }

        .video-wrap,
        .controller,
        .document-capture,
        canvas {
            margin-bottom: 20px;
        }

        .video-wrap video {
            max-width: 100%;
            height: auto;
        }

        .document-capture {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .document-capture>* {
            margin-bottom: 10px;
        }

        .document-capture input[type="file"] {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
            width: 100%;
            max-width: 300px;
        }

        canvas {
            display: block;
            margin: 0 auto;
        }

        #video-biofacial {
            text-align: center;
        }

        .video-wrap {
            position: relative;
            margin: 0 auto;
            margin-top: 15px;
            margin-bottom: 15px;
            width: 400px;
            height: 225px;
        }

        #video {
            width: 400px;
            height: 225px;
            border: 1px solid #c7c7c7;
            border-radius: 15px;

            -webkit-box-shadow: 6px 9px 39px 0px rgba(161, 161, 161, 1);
            -moz-box-shadow: 6px 9px 39px 0px rgba(161, 161, 161, 1);
            box-shadow: 6px 9px 39px 0px rgba(161, 161, 161, 1);
        }

        #video-guide {
            position: absolute;
            width: 400px;
            height: 225px;
            border-radius: 15px;
            z-index: 1;
            top: 0;
        }

        #face-position {
            width: 180px;
            height: 200px;
            margin: 0 auto;
            border-right: 5px solid #c7c7c7;
            border-left: 5px solid #c7c7c7;
            border-radius: 40%;
            display: flex;
            margin-top: 9px;
        }

        .img-action {
            margin: 0 auto;
            max-width: 400px;
            border: 1px solid #c7c7c7;
            border-radius: 15px;
            padding-top: 15px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 10px;
            text-align: center;
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-ok-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .modal-ok-button:hover {
            background-color: #45a049;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            setTimeout(function() {
                history.back();
            }, 270000);
            const modal = document.getElementById("modal");
            const modalMessage = document.getElementById("modal-message");

            // // Show modal function
            function showModal(message, redirect = null) {
                modalMessage.textContent = message;
                modal.style.display = "block";
                redirectUrl = redirect; // Set the redirect URL
            }


            const variable = "{{ $identificacionUsuario }}"

            var uri = "{{ $uri }}";

            setInterval(() => {

                var data = {
                    token: "{{ $responseAuthLoginToken }}",
                    hash: "{{ $responseDataFrame['data']['hash'] }}"
                };
                var baseUrl = 'http://localhost/plataforma/public';
                // var baseUrl = window.location.origin;
                $.ajax({
                    url: baseUrl + '/aprende/validate',
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    success: function(response) {
                        var decodedString = atob(uri);

                        if (response.status == true) {
                            if (response.sign.score > 70 && variable == response.sign.client
                                .identification + "") {
                                setTimeout(function() {
                                    window.location = baseUrl + decodedString
                                }, 2000);
                            } else {
                                showModal('Validación Erronea');
                                setTimeout(function() {
                                    history.back();
                                }, 3000);
                            }
                        }
                    },
                    error: function(error) {
                        console.log('Error:', error);
                        showModal('Error en la validación');
                        setTimeout(function() {
                            history.back();
                        }, 3000);
                    },

                });

            }, 5000);
        });
    </script>
@stop
