<template>
    <div class="container bg-white">
        <div class="row bg-white">
            <div class="col-12">
                <p v-html="content"></p>
            </div>
        </div>
        <router-link to="/task3-videos" class="custom-router-link" v-if="!loading && count > 0">
            <div class="row bg-white pb-3">
                <div class="col-md-12 d-flex align-items-center">
                    <!-- Loop for green squares -->
                    <div v-for="n in count" :key="n" class="custom-square-check"></div>

                    <!-- Loop for red squares -->
                    <div v-for="n in (5 - count)" :key="n + 'red'" class="custom-square-red"></div>

                        <button class="video-link ml-auto btn btn-primary zu-videos">
                            Zu den Videos
                        </button>
                </div>
            </div>
        </router-link>

        <!--
        <div v-if="!loading" class="row pb-5 pt-3 bg-white ">
            <div class="col-6 text-center">
                <button type="button" class="btn btn-primary" style="font-size: 13px;" @click="goToRecord" v-if="count < 3">Video aufnehmen</button>
            </div>
            <div class="col-6 text-center">
                <button type="button" class="btn btn-primary" style="font-size: 13px;" @click="goToUpload" v-if="count < 3">Video hochladen</button>
            </div>
        </div>
        -->

        <div v-if="!loading" class="row pb-5 pt-3 bg-white ">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-primary" style="font-size: 13px; width:100%" @click="goToUpload(taskNumber)" v-if="count < 5">Video hochladen</button>
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
    name: "Task3_Overview",

    data() {
        return {
            count: 0,
            title: '',
            content: '',
            task: 3,
            loading: true,
            taskNumber: 3
        }
    },
    methods: {
        goToRecord() {
            this.$router.push('/task3-recording');
        },
        goToUpload(taskNumber) {
            this.$router.push({
                path: `/task-upload/${taskNumber}`,
                query: { maxVideoDuration: 12, format: 'quer', types: 'video/*', wording: 'Video', amount: 5 }
            });
        },


        goBack() {
            this.$router.go(-1);
        },
    },
    async mounted() {

        try {
            // Wait for both requests to complete
            const [contentResponse, allTaskResponse] = await Promise.all([
                axios.get('/task/content/3'),
                axios.get('/task/get-all-task', { params: { task: 3 } })
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
