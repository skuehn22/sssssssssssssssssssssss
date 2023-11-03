@extends('layouts.app')
@section('styles')
    <style>
        body {
            background-color: white!important;
        }
    </style>
@endsection
@section('content')

<div class="container">







    <div class="row justify-content-center bg-white" style="padding-top: 15%;">
        <div class="col-md-12">
            <div id="qrCode2">



                <video id="preview" playsinline style="display: none; max-width: 100%; margin-bottom: 20px;"></video>


                <div class="row">
                    <div class="col-12 d-flex justify-content-center mb-3">
                        <button id="switchCamera" class="btn btn-success btn-block btn-standard" style="display: none; font-size: 12px; width: 200px;">Kamera wechselnn</button>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <button id="stopScanner" class="btn btn-success btn-block btn-standard" style="display: none; font-size: 12px;  width: 200px; background-color: gray; color: white;  border: none;">Stop Scanner</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="row justify-content-center align-items-center bg-white" style="height: 10vh;">
        <div class="col-12 text-center">
            <div class="my-auto">
                <h1>Tak-Tak List App <i class="fas fa-heart text-danger me-2" style="cursor:pointer;"></i></h1> <!-- You can use h1-h6 depending on the importance and desired size -->
            </div>
        </div>
    </div>

    <div class="row justify-content-center bg-white">
        <div class="col-md-12">
            <div  id="loginForm" class="bg-white">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input id="name" type="text" PLACEHOLDER="tak tak code" class="form-control same-height @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <!--
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input id="password" PLACEHOLDER="Passwort" type="text" class="form-control same-height @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" autofocus>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>
                    </div>-->

                    <!-- Removed Remember Me -->

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary same-height" style="background-color: #009BD5; width:100%; border-radius: 7px; padding: 0px 14px;">{{ __('Tak Tak Go') }}</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>


@endsection
@section('scripts')
        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <!-- Add to the head of the document -->
        <script src="https://unpkg.com/@zxing/library@latest"></script>

        <script>
            let codeReader = new ZXing.BrowserQRCodeReader();

            function startScanning(deviceId) {
                document.getElementById('qrCodeImage').style.display = 'none';
                document.getElementById('preview').style.display = 'block';
                document.getElementById('stopScanner').style.display = 'block';


                const userAgent = window.navigator.userAgent.toLowerCase();

                console.log(userAgent);
                const isIOS =  /iphone|ipad|ipod/.test( userAgent );
                console.log(isIOS);


                if(isIOS){
                    document.getElementById('switchCamera').style.display = 'none';
                }else{
                    document.getElementById('switchCamera').style.display = 'block';
                }

                codeReader.decodeFromInputVideoDevice(deviceId, 'preview').then((result) => {
                    console.log(result);
                    window.location.href = result.text;
                }).catch((err) => {
                    console.error(err);
                });
            }


            function stopScanning() {
                codeReader.reset();
                document.getElementById('qrCodeImage').style.display = 'block';
                document.getElementById('preview').style.display = 'none';
                document.getElementById('stopScanner').style.display = 'none';
                document.getElementById('switchCamera').style.display = 'none';
            }

            document.getElementById('qrCodeImage').addEventListener('click', function() {
                startScanning(currentDeviceId);
            });


            document.getElementById('stopScanner').addEventListener('click', function() {
                // rest of your UI logic
                stopScanning();
            });

            let currentDeviceId = undefined;
            let availableDevices = [];

            function loadCameras() {
                // Get the list of available video input devices (cameras)
                codeReader.getVideoInputDevices().then((devices) => {
                    availableDevices = devices;
                    if (devices.length > 0) {
                        currentDeviceId = devices[0].deviceId; // Default to the first camera
                        //startScanning(currentDeviceId);
                        if (devices.length > 1) {
                            // If there's more than one camera, show the switch button
                            //document.getElementById('switchCamera').style.display = 'block';
                        }
                    }
                }).catch((err) => {
                    console.error(err);
                });
            }

            // Call loadCameras when the page loads
            window.onload = loadCameras;


            function switchCamera() {
                if (availableDevices.length === 0) return;

                // Find the index of the current device
                const currentIndex = availableDevices.findIndex(device => device.deviceId === currentDeviceId);

                // Calculate the index of the next device
                const nextIndex = (currentIndex + 1) % availableDevices.length;
                currentDeviceId = availableDevices[nextIndex].deviceId;

                // Stop the current scanning
                codeReader.reset();

                // Start scanning with the new camera
                startScanning(currentDeviceId);
            }


            // Call loadCameras when the page loads
            loadCameras();

            // Attach the switchCamera function to the switchCamera button
            document.getElementById('switchCamera').addEventListener('click', switchCamera);

            const isIOS = () => {
                const userAgent = window.navigator.userAgent.toLowerCase();

                console.log(userAgent);
                const test =  /iphone|ipad|ipod/.test( userAgent );
                console.log(test);
            };


        </script>


@endsection
