<template>
    <div class="container bg-white">
        <div class="row pt-3">
            <div class="col-12">
                <p v-html="content"></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 d-flex align-items-center">
                <!-- Loop for green squares -->
                <div v-for="n in count" :key="n" class="custom-square-check" ></div>

                <!-- Loop for red squares -->
                <div v-for="n in (5 - count)" :key="n + 'red'" class="custom-square-red"></div>
                <router-link to="/lehrer-task5-videos" class="video-link ml-auto" v-if="count > 0">
                    <button class="video-link ml-auto btn btn-primary zu-videos">
                        Zu den Videos
                    </button>
                </router-link>
            </div>

        </div>
        <div v-if="!loading" class="row pb-5 pt-3 bg-white ">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-primary" style="font-size: 13px;" @click="goToUpload(taskNumber)" v-if="count < 5">Video hochladen</button>
            </div>
        </div>
</div>

</template>

<script>
import axios from 'axios';

export default {
    name: "Task20",
    data() {
        return {
            count: 0,
            title: '',
            content: '',
            task: 50,
            taskNumber: 50
        }
    },
    methods: {
        goToRecord() {
            this.$router.push('/lehrer-task5-recording');
        },
        goToUpload(taskNumber) {
            this.$router.push({
                path: `/task-upload/${taskNumber}`,
                query: { maxVideoDuration: 17, format: 'quer', types: 'video/*', wording: 'Video', amount: 5 }
            });
        },
        goBack() {
            this.$router.go(-1);
        }

    },
    mounted() {

        axios.get('/task/content/50')
            .then(response => {
                this.title = response.data.title;
                this.content = response.data.intro;
            })
            .catch(error => {
                console.error(error);
            });

        axios.get('/task/get-all-task', {
            params: {
                task: 50,
            }
        })
            .then(response => {
                this.count = response.data.count;
                console.log(this.count);
            })
            .catch(error => {
                console.error(error);
            });
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
</style>
