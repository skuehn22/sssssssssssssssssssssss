<template>
    <div class="container">

        <div class="row bg-white pt-3 pb-1 mb-3">
            <div class="col-12">
                <p v-html="content"></p>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="col-12 text-center">
                    <div class="card mb-1">
                        <div class="card-body task1" @click="openNavigationApp(1)">
                            <div class="card-header p-3" style="background-color: transparent; font-weight: 700; text-align: left; border: none;">
                                <h1>Prenzlauer Berg</h1>
                                <p>Kollwitzplatz - am Käthe Kollwitz Denkmal</p>
                                <button type="button" class="btn btn-primary-less" style="margin-right: 5px;" @click="openNavigationApp(1)">Navigation starten</button>
                                <img src="/images/Navigation2.png" style="width: 35px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="col-12 text-center">
                    <div class="card mb-1">
                        <div class="card-body task1" @click="openNavigationApp(0)">
                            <div class="card-header p-3" style="background-color: transparent; font-weight: 700; text-align: left;border: none;">
                                <h1>Kreuzberg</h1>
                                <p>Oranienplatz - am Drachenbrunnen</p>
                                <button type="button" class="btn btn-primary-less" style="margin-right: 5px;" @click="openNavigationApp(0)">Navigation starten</button>
                                <img src="/images/Navigation2.png" style="width: 35px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="col-12 text-center">
                    <div class="card mb-1">
                        <div class="card-body task1" @click="openNavigationApp(2)">
                            <div class="card-header p-3" style="background-color: transparent; font-weight: 700; text-align: left;border: none;">
                                <h1>Berlin Mitte</h1>
                                <p>Unter den Linden - am Springbrunnen im Lustgarten</p>
                                <button type="button" class="btn btn-primary-less" style="margin-right: 5px;border: none;" @click="openNavigationApp(2)">Navigation starten</button>
                                <img src="/images/Navigation2.png" style="width: 35px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Navigation",
    data() {
        return {
            count: 0,
            title: '',
            content: '',
            task: 3,
            maps_key: "AIzaSyAuUWAVzOTJQuo6UKUhAWuxNypq4kAu1dk",
            markers: [],
            places: [],
            currentPlace: null,
            center: {lat: 52.50367138140576, lng: 13.410974845668491},
            markerOptions: [
                {
                    position: {lat: 52.50297, lng: 13.41617},
                    label: "1",
                    title: "Kreuzberg",
                    description: "Drachenbrunnen",
                    icon: "https://app.ontour.org/images/icons/icon-48x48.png"
                },
                {
                    position: {lat: 52.53652, lng:13.41740},
                    label: "2",
                    title: "Prenzlauer Berg - ",
                    description: "Käthe Kollwitz Denkmal" // Added description field
                },
                {
                    position: {lat: 52.51874, lng:13.39968},
                    label: "3",
                    title: "Berlin Mitte",
                    description: "Springbrunnen im Lustgarten" // Added description field
                }
            ]

        }
    },
    methods: {
        openNavigationApp(index) {
            const marker = this.markerOptions[index];

            // Check if the device is iOS
            if (/iPhone|iPad|iPod|iOS/i.test(navigator.userAgent)) {
                // Use Apple Maps URL scheme for iOS
                const url = `maps://?q=${marker.position.lat},${marker.position.lng}`;

                // Create an anchor element to open the URL
                const anchor = document.createElement('a');
                anchor.href = url;
                anchor.target = '_blank'; // Open in a new window/tab

                // Trigger a click event on the anchor element
                const clickEvent = new MouseEvent('click', {
                    bubbles: true,
                    cancelable: true,
                    view: window,
                });

                anchor.dispatchEvent(clickEvent);
            } else {
                // For other devices and browsers, open Google Maps in a new tab/window
                const googleMapsUrl = `http://maps.google.com/?q=${marker.position.lat},${marker.position.lng}(${marker.title})`;
                window.open(googleMapsUrl, '_blank');
            }
        },

        openGoogleMaps(index) {
            const marker = this.markerOptions[index];

            let url;

            // Try to use the appropriate URL scheme for the device
            if (/iPhone|iPad|iPod|iOS/i.test(navigator.userAgent)) {
                url = `comgooglemaps://?q=${marker.position.lat},${marker.position.lng}(${marker.title})`;

                // Try to open Google Maps app, fallback to web version if not installed
                if (!window.open(url)) {
                    url = `http://maps.apple.com/?q=${marker.position.lat},${marker.position.lng}`;
                    window.open(url);
                }
            } else if (/Android/i.test(navigator.userAgent)) {
                url = `geo:${marker.position.lat},${marker.position.lng}?q=${marker.position.lat},${marker.position.lng}(${marker.title})`;
                window.open(url);
            } else {
                // For other devices, default to the web version
                url = `http://maps.google.com/?q=${marker.position.lat},${marker.position.lng}(${marker.title})`;
                window.open(url);
            }
        }

    },
    mounted() {

        axios.get('/task/content/60')
            .then(response => {
                this.title = response.data.title; // Assign title from the response
                this.content = response.data.intro; // Assign content from the response
            })
            .catch(error => {
                console.error(error);
            });
    },
}
</script>

<style scoped>
.btn-custom {
    display: inline;
}

</style>
