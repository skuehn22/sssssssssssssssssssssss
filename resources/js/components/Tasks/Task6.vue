<template>
    <div class="container">
        <div class="row bg-white pt-3">
            <div class="col-12">
                <p v-html="content"></p>
            </div>
        </div>
        <div v-if="!loading" class="row bg-white">
            <div class="col-md-12 d-flex align-items-center">
                <!-- Loop for green squares -->
                <div v-for="n in count" :key="n" class="custom-square-check" ></div>

                <!-- Loop for red squares -->
                <div v-for="n in (3 - count)" :key="n + 'red'" class="custom-square-red"></div>
                <router-link to="/task6-files" class="video-link ml-auto" v-if="count > 0">
                    <button class="video-link ml-auto btn btn-primary zu-videos">
                        Zu den Bildern / Videos
                    </button>


                </router-link>
            </div>

        </div>
        <div  v-if="!loading" class="row pt-3 bg-white pb-5 ">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-primary" style="width: 100%; font-size: 13px;" @click="goToUpload(taskNumber)" v-if="count < 3">Datei hochladen</button>
            </div>
        </div>
    </div>
    <div v-if="loading" class="overlay">
        <div class="spinner"></div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    query: { maxVideoDuration: 32, format: 'beides', types: 'image/*, video/*', wording: 'Datei' },
    name: "Task20",
    data() {
        return {
            count: 0,
            title: '',
            content: '',
            task: 6,
            taskNumber: 6,
            loading: true,
            geolocationError: null,
        }
    },
    methods: {
        goToRecord() {
            this.$router.push('/task6-recording');
        },
        goToUpload(taskNumber) {
            this.$router.push({
                path: `/task-upload/${taskNumber}`,
                query: { maxVideoDuration: 32, format: 'beides', types: 'image/*, video/*' , wording: 'Datei', amount: 3 }
            });
        },
        goBack() {
            this.$router.go(-1);
        }
    },
    async mounted() {
        try {
            // Wait for both requests to complete
            const [contentResponse, allTaskResponse] = await Promise.all([
                axios.get('/task/content/6'),
                axios.get('/task/get-all-task', { params: { task: 6 } })
            ]);

            // Now handle the responses
            this.title = contentResponse.data.title;
            this.content = contentResponse.data.intro;
            this.count = allTaskResponse.data.count;

        } catch (error) {
            console.error(error);
        } finally {
            this.loading = false;
        }
    }

}
</script>

<style scoped>

</style>
