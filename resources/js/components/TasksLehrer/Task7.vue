<template>
    <div class="container">
        <div  v-if="!loading" class="row bg-white  pb-3">
            <div class="col-12">
                <p v-html="content"></p>
            </div>
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
                            <button type="button" class="btn btn-primary-less" style="margin-right: 5px;">Navigation starten</button>
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
    <div  v-if="!loading"  class="row pt-3 pb-3 no-bottom-margin" style="background-color: #e0f0f4; padding-left:30px; padding-right:30px;">
        <div class="col-12" style="font-weight: 700;">
            Wählen Sie hier einen Stadtteil aus
        </div>
    </div>
    <div  v-if="!loading" class="row bg-white no-top-margin pb-5" style="padding-top: 0">
        <div class="col-12">



            <div v-for="(location, index) in locations" :key="location.name">
                <Accordion :defaultOpen="index === 0">
                    <template #header>
                        {{ location.name }}
                    </template>
                    <template #body>
                        <div v-if="location.name === 'Berlin Mitte'">
                            <img src="/images/Berlin-Mitte-Karte.png" alt="Berlin Mitte Map" style="width: 100%">
                        </div>
                        <div v-if="location.name === 'Prenzlauer Berg'">
                            <img src="/images/Berlin-Prenzlauer-Berg-Karte.png" alt="Prenzlauer Berg Map" style="width: 100%">
                        </div>
                        <div v-if="location.name === 'Kreuzberg'">
                            <img src="/images/Berlin-Kreuzberg-Karte.png" alt="Kreuzberg Map" style="width: 100%">
                        </div>
                    </template>
                </Accordion>
            </div>



        </div>
    </div>


    <div v-if="loading" class="overlay">
        <div class="spinner"></div>
    </div>
</template>

<script>
import axios from 'axios';
import { GoogleMap, Marker, InfoWindow, Polygon  } from "vue3-google-map";
import Accordion from './Task7_Accordion.vue';
export default {
    name: "Task7",
    components: { GoogleMap, Marker, InfoWindow,Polygon,  Accordion  },
    data() {
        return {
            loading: true,
            count: 0,
            title: '',
            content: '',
            task: 70,
            currentPlace: null,
            locations: [
                {
                    name: "Berlin Mitte",
                    mapCenter: { lat: 52.51585716721603, lng: 13.394452567844812 }
                },
                {
                    name: "Prenzlauer Berg",
                    mapCenter: { lat: 52.5369484737577, lng:13.414130089766347 }
                },
                {
                    name: "Kreuzberg",
                    mapCenter: { lat: 52.50367138140576, lng: 13.410974845668491 }
                },
            ],
            taskNumber: 70,
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
        goToRecord() {
            this.$router.push('/lehrer-task7-recording');
        },
        goToUpload(taskNumber) {
            this.$router.push({
                path: `/task-upload/${taskNumber}`,
                query: { maxVideoDuration: 17, format: 'hoch', types: 'video/*', wording: 'Video', amount: 3 }
            });
        },
        goBack() {
            this.$router.go(-1);
        },
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

        getGoogleMapsUrl(index) {
            const marker = this.markerOptions[index];
            return `http://maps.google.com/?q=${marker.position.lat},${marker.position.lng}(${marker.title})`;
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
    async mounted() {

        // Handling Axios requests using Promise.all
        try {
            // Wait for both requests to complete
            const [contentResponse, allTaskResponse] = await Promise.all([
                axios.get('/task/content/70'),
                axios.get('/task/get-all-task', { params: { task: 70 } })
            ]);

            // Now handle the responses
            this.title = contentResponse.data.title;
            this.content = contentResponse.data.intro;
            this.count = allTaskResponse.data.count;
            console.log(this.count);
            this.loading = false;
        } catch (error) {
            console.error(error);
        }
    },

}
</script>

<style scoped>
.progress-container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.progress-circle {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 6px solid gray;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.progress-circle.small {
    width: 10px;
    height: 10px;
    background: gray;
}

.progress-group {
    display: flex;
    align-items: center;
    flex-grow: 1;
    position: relative; /* Added this line */
}

.progress-text {
    text-align: center;
    width: 100%;
    position: absolute;
    top: -20px;
}

.progress-line {
    flex-grow: 1;
    height: 5px;
    background: gray;
    margin: 0 10px;
}

.progress-circle-green {
    background: green;
    border: 6px solid green;

}

.progress-line-green {
    background: green;
}

.checkmark::after {
    content: "✔";
    color: white;
    position: absolute;
    top: 50%;
    left: 90%;
    transform: translate(-50%, -50%);
}

.progress-text-green{
    color: green;
}


.video-link {
    color: gray;
    font-weight: 600;  /* increase font weight */
    text-decoration: none;  /* remove underline */
}
.video-link i {
    margin-right: 5px;
}

.no-bottom-margin {
    margin-bottom: 0 !important;
}

.no-top-margin {
    margin-top: 0 !important;
}
</style>
