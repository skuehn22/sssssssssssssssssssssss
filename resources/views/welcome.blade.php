<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>Videoprojekt</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="register-service-worker.js"></script>

    @laravelPWA

    <style>
        .custom-modal .modal-dialog {
            max-width: 80%;  /* Adjust this value to suit your needs */
            margin: auto;
            font-family: Arial, Helvetica, sans-serif;
        }
        .custom-modal .modal-header {
            border: none;
            padding-bottom: 0;
        }
        .custom-modal .modal-body {
            padding-top: 0;
        }
        .custom-close {
            opacity: 1 !important;  /* Use !important to override the Bootstrap's default */
        }
    </style>

</head>
<body class="antialiased d-flex flex-column min-vh-100">
<div class="container" style="padding: 30px;">

    <!-- Logo -->
    <div class="row justify-content-center align-items-center mt-4" style="padding-top: 15%;">
        <div class="col-sm-12 text-center">
            <img src="/images/videoproject.png" alt="Logo" class="img-fluid safari-fix" style="width: 90%; height: auto;">
        </div>
    </div>

    <!-- Banner -->


    <!-- Content and Buttons -->
    <div class="row justify-content-center my-4"  style="padding-top: 15%;">
        <div class="col-sm-12 text-center">
            <!--
            <h2>Hier bekommst du unsere App</h2>
            <p class="pt-3">Installiere dir die App und genieße deine <br>Reise durch die Stadt</p>
            -->

            <div class="row justify-content-center my-2 pt-3">
                 <div class="col-12">
                     <button id="installButton" class="btn btn-primary mx-2" style="width: 100%; background-color: #009bd5">Web-App installierenn</button>
                     <p  style="padding-top:25px; font-size: 12px;">  Wenn die Web-App installiert wurde, die Web-App auf dem Smartphone öffnen</p>
                 </div>
            </div>

            <div class="row justify-content-center my-2 pt-3">
                <div class="col-12">
                    <a href="{{ route('login') }}" class="mx-2" style="color: gray; text-decoration: underline">Log in</a>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="fixed-bottom text-center py-3" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center align-items-center mt-4">
                <div class="col-sm-12 text-center" style="font-size: 12px;">
                    Präsentiert von <img src="https://ontour.org/wp-content/uploads/2023/04/Element-1-1.svg" alt="Logo" class="img-fluid" style="max-width: 80px;">
                </div>
            </div>
        </div>
    </footer>

</div>

<div class="modal fade custom-modal" id="iosInstructionModal" tabindex="-1" role="dialog" aria-labelledby="iosInstructionModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close custom-close" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 10px; top: -35px; background: transparent; border: none; color: #fff;">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-header justify-content-center">
                <p><img src="images/videoproject.png" alt="App icon" style="width:100%"></p>
            </div>
            <div class="modal-body text-center">
                <h5 class="modal-title" id="iosInstructionModalLabel" style="font-weight: 800;">App installieren</h5>
                <!--<p style="padding-top: 20px; padding-right: 25px; padding-left: 25px;">Installiere die App auf deinem Startbildschirm für einen schnellen und einfachen Zugriff wenn du unterwegs bist.</p>
                -->
            </div>
            <div class="modal-footer justify-content-center" style="background-color: #e2e3e5; text-align: center; padding:0;">
                <p style="margin: 0; padding-top: 10px; padding-bottom: 10px;">Tippe auf das <img src="/images/home.png" alt="Share icon" style="width: 22px;margin-bottom: 7px;"> und dann auf <br>"Zum Home-Bildschirm" <img src="/images/plus.png" alt="Share icon" style="width: 22px;margin-bottom: 7px;"></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-modal" id="firefoxInstructionModal" tabindex="-1" role="dialog" aria-labelledby="iosInstructionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close custom-close" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 10px; top: -35px; background: transparent; border: none; color: #fff;">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-header justify-content-center">
                <p><img src="images/banner_app_icons.PNG" alt="App icon" style="width:100%"></p>
            </div>
            <div class="modal-body text-center">
                <h5 class="modal-title" id="iosInstructionModalLabel" style="font-weight: 800;">Installiere die <br> onTour App</h5>
                <p style="padding-top: 20px; padding-right: 25px; padding-left: 25px;">Installiere die App auf deinem Startbildschirm für einen schnellen und einfachen Zugriff wenn du unterwegs bist.</p>
            </div>
            <div class="modal-footer justify-content-center" style="background-color: #e2e3e5; text-align: center; padding:0;">
                <p style="margin: 0; padding-top: 10px; padding-bottom: 10px;">Tippe auf <img src="/images/61140.png" alt="Share icon" style="width: 22px;margin-bottom: 7px;"> unten rechts und dann auf <br>"Installieren"</p>
            </div>
        </div>
    </div>
</div>

</body>
<script>

    let installButton = document.getElementById('installButton');
    let deferredPrompt;

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();

        // Stash the event so it can be triggered later.
        deferredPrompt = e;

        // Update UI to notify the user they can add to home screen
        installButton.style.display = 'block';
    });

    installButton.addEventListener('click', (e) => {
        if (isIOS()) {
            // Show the iOS instruction modal if the device is an iOS device
            $('#iosInstructionModal').modal('show');
        } else if (isFirefox()) { // If Firefox, show the Firefox-specific modal
            $('#firefoxInstructionModal').modal('show');
        } else if (isSamsungBrowser()) {
            // If Samsung Browser is detected, show the install prompt directly
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                } else {
                    console.log('User dismissed the A2HS prompt');
                }
                deferredPrompt = null;
            });
        } else {
            // If not an iOS device and not using Samsung Browser, proceed with the usual installation flow

            // hide our user interface that shows our A2HS button
            installButton.style.display = 'none';

            // If deferredPrompt is not defined, just return
            if (!deferredPrompt) {
                return;
            }

            // Show the prompt
            deferredPrompt.prompt();

            // Wait for the user to respond to the prompt
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                } else {
                    console.log('User dismissed the A2HS prompt');
                }
                deferredPrompt = null;
            });
        }
    });



    // Check if the user's device is running iOS
    const isIOS = () => {
        const userAgent = window.navigator.userAgent.toLowerCase();
        return /iphone|ipad|ipod/.test( userAgent );
    };

    const isSamsungBrowser = () => {
        const userAgent = window.navigator.userAgent.toLowerCase();
        return userAgent.includes('samsungbrowser');
    };

    const isFirefox = () => {
        const userAgent = window.navigator.userAgent.toLowerCase();
        return userAgent.includes('firefox');
    };



    // Check if the app is running in standalone mode
    const isInStandaloneMode = () => ('standalone' in window.navigator) && (window.navigator.standalone);

    if (isInStandaloneMode()) {
        // If the app is running in standalone mode, redirect to /login
        window.location.href = '/login';
    } else if (isIOS()) {
        // If the device is running iOS and not in standalone mode, show the modal
        $('#iosInstructionModal').modal('show');
    }




</script>
</html>
