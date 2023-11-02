<template>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="col-12 text-center">
                <div class="card mb-1">
                    <div class="card-body task1" @click="openGoogleMaps(1)" :style="task1Color">
                        <div class="card-header p-3" style="background-color: transparent; font-weight: 700; text-align: left;">
                            <h1>Prenzlauer Berg</h1>
                            <p>Kollwitzplatz - am Käthe Kollwitz Denkmal</p>
                            <button type="button" class="btn btn-primary" style="margin-right: 5px;" @click="openGoogleMaps(1)">Navigation starten</button>
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
                    <div class="card-body task1" @click="openGoogleMaps(0)" :style="task1Color">
                        <div class="card-header p-3" style="background-color: transparent; font-weight: 700; text-align: left;">
                            <h1>Kreuzberg</h1>
                            <p>Oranienplatz - am Drachenbrunnen</p>
                            <button type="button" class="btn btn-primary" style="margin-right: 5px;" @click="openGoogleMaps(0)">Navigation starten</button>
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
                    <div class="card-body task1" @click="openGoogleMaps(2)" :style="task1Color">
                        <div class="card-header p-3" style="background-color: transparent; font-weight: 700; text-align: left;">
                            <h1>Berlin Mitte</h1>
                            <p>Unter den Linden - am Springbrunnen im Lustgarten</p>
                            <button type="button" class="btn btn-primary" style="margin-right: 5px;" @click="openGoogleMaps(2)">Navigation starten</button>
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
                    position: {lat: 52.50367138140576, lng: 13.410974845668491},
                    label: "1",
                    title: "Kreuzberg",
                    description: "Drachenbrunnen",
                    icon: "https://app.ontour.org/images/icons/icon-48x48.png"
                },
                {
                    position: {lat: 52.5369484737577, lng:13.414130089766347},
                    label: "2",
                    title: "Prenzlauer Berg - ",
                    description: "Käthe Kollwitz Denkmal" // Added description field
                },
                {
                    position: {lat: 52.51585716721603, lng:13.394452567844812},
                    label: "3",
                    title: "Berlin Mitte",
                    description: "Springbrunnen im Lustgarten" // Added description field
                }
            ]

        }
    },
    methods: {

        openGoogleMaps(index) {
            const marker = this.markerOptions[index];
            const url = `http://maps.google.com/?q=${marker.position.lat},${marker.position.lng}(${marker.title})`;
            window.open(url);
        }




    },
}
</script>

<style scoped>
.btn-custom {
    display: inline;
}
</style>
