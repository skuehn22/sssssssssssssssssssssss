<template>
    <div class="container">
        <div  v-if="!loading" class="row bg-white  pb-3">
            <div class="col-12">
                <p v-html="content"></p>
            </div>
        </div>
    </div>
    <div  v-if="!loading"  class="row pt-3 pb-3 no-bottom-margin" style="background-color: #e0f0f4; padding-left:30px; padding-right:30px;">
        <div class="col-12" style="font-weight: 700;">
            Wählt hier Euren Stadtteil aus
        </div>
    </div>
        <div  v-if="!loading" class="row bg-white no-top-margin" style="padding-top: 0">
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
    <!--
    <div  v-if="!loading"  class="row pt-3 pb-3" style="background-color: #e0f0f4; padding-left:30px; padding-right:30px;">
        <div class="col-12" style="font-weight: 700;">
            Falls Ihr einen anderen Stadtteil ausgesucht
            habt, erkundet diesen eigenständig.
        </div>
    </div>

    -->
    <div class="container">
        <div  v-if="!loading" class="row bg-white pt-5 pb-3">
            <div class="col-md-12 d-flex align-items-center">
                <!-- Loop for green squares -->
                <div v-for="n in count" :key="n" class="custom-square-check" ></div>

                <!-- Loop for red squares -->
                <div v-for="n in (3 - count)" :key="n + 'red'" class="custom-square-red"></div>
                <router-link to="/task5-videos" class="video-link ml-auto" v-if="count > 0">

                    <button class="video-link ml-auto btn btn-primary zu-videos">
                        Zu den Videos
                    </button>
                </router-link>
            </div>

        </div>
        <div v-if="!loading" class="row pb-5 pt-3 bg-white ">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-primary" style="font-size: 13px; width:100%" @click="goToUpload(taskNumber)" v-if="count < 3">Video hochladen</button>
            </div>
        </div>
</div>
    <div v-if="loading" class="overlay">
        <div class="spinner"></div>
    </div>
</template>

<script>
import axios from 'axios';
import Accordion from './Task5_Accordion.vue';
export default {
    name: "Task5_overview",
    components: { Accordion  },
    data() {
        return {
            loading: true,
            count: 0,
            title: '',
            content: '',
            task: 5,
            taskNumber: 5,
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
        }
    },
    methods: {
        goToRecord() {
            this.$router.push('/task5-recording');
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

    },
    async mounted() {


        // Handling Axios requests using Promise.all
        try {
            // Wait for both requests to complete
            const [contentResponse, allTaskResponse] = await Promise.all([
                axios.get('/task/content/5'),
                axios.get('/task/get-all-task', { params: { task: 5 } })
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
