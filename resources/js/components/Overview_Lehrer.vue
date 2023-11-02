<template>
    <div class="container">
        <div class="row justify-content-center bg-white pb-3">
            <div class="col-md-8 text-center">
                <span style="font-weight: 700; font-size: 22px;">Ihre Aufgaben</span>
            </div>
        </div>
        <div class="row justify-content-center pt-2 pb-2">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-body task1" @click="goToTask(1)" :style="task1Color">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-6">
                                <span>Ihr Teamname</span>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end"> <!-- This wrapping div will contain the icons and make them stay close together -->
                                <div v-if="teamName && teamName.length > 0" class="custom-square-check"></div>
                                <div v-else class="custom-square-red"></div>
                            </div>
                            <div class="col-2" style="text-align: right; width: 10%">
                                <div style="background-color: #009bd5; width: 35px; height: 35px; border-radius: 12px; display: inline-flex; justify-content: center; align-items: center;">
                                    <img src="/images/Pfeil-weiss-rechts.png" style="width: 20px; padding: 5px;">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="card mb-1">
                    <div class="card-body task1" @click="goToTask(2)" :style="task1Color">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-6">
                                <span>Ihr Teamfoto</span>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end"> <!-- This wrapping div will contain the icons and make them stay close together -->
                                <div v-if="teamFoto && teamFoto.length > 0" class="custom-square-check"></div>
                                <div v-else class="custom-square-red"></div>
                            </div>
                            <div class="col-2" style="text-align: right; width: 10%">
                                <div style="background-color: #009bd5; width: 35px; height: 35px; border-radius: 12px; display: inline-flex; justify-content: center; align-items: center;">
                                    <img src="/images/Pfeil-weiss-rechts.png" style="width: 20px; padding: 5px;">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-body task1" @click="goToTask(3)" :style="task1Color">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-6">
                                <span>Videobotschaft</span>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end"> <!-- This wrapping div will contain the icons and make them stay close together -->
                                <div v-if="task3 && task3.length > 0" class="custom-square-check"></div>
                                <div v-else class="custom-square-red"></div>
                            </div>
                            <div class="col-2" style="text-align: right; width: 10%">
                                <div style="background-color: #009bd5; width: 35px; height: 35px; border-radius: 12px; display: inline-flex; justify-content: center; align-items: center;">
                                    <img src="/images/Pfeil-weiss-rechts.png" style="width: 20px; padding: 5px;">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-body task1" @click="goToTask(4)" :style="task1Color">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">

                            <div class="col-6">
                                <span>Klassenfoto</span>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end">
                                <div v-if="task4 && task4.length > 0" class="custom-square-check"></div>
                                <div v-else class="custom-square-red"></div>
                            </div>
                            <div class="col-2" style="text-align: right; width: 10%">
                                <div style="background-color: #009bd5; width: 35px; height: 35px; border-radius: 12px; display: inline-flex; justify-content: center; align-items: center;">
                                    <img src="/images/Pfeil-weiss-rechts.png" style="width: 20px; padding: 5px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row justify-content-center bg-white pb-3">
            <div class="col-md-8 text-center">
                <span style="font-weight: 700; font-size: 22px;">Optionale Aufgaben</span>
            </div>
        </div>
        <div class="row justify-content-center pt-2 pb-2">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-body task1" @click="goToTask(5)">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-6">
                                <span>Erinnerungsvideos</span>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end">
                                <div v-for="n in (task5 ? task5.count : 0)" :key="n" class="custom-square-check"></div>
                                <div v-for="n in (5 - (task5 ? task5.count : 0))" :key="n + 'red'" class="custom-square-red"></div>
                            </div>
                            <div class="col-2" style="text-align: right; width: 10%">
                                <div style="background-color: #009bd5; width: 35px; height: 35px; border-radius: 12px; display: inline-flex; justify-content: center; align-items: center;">
                                    <img src="/images/Pfeil-weiss-rechts.png" style="width: 20px; padding: 5px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="row justify-content-center bg-white">
            <div class="col-md-8 text-center">
                <span style="font-weight: 700; font-size: 22px;">Stadtteilerkundung</span> <br>Diese Aufgaben während der Stadtteilerkundung bearbeiten
            </div>
        </div>
        <div class="row justify-content-center  pt-2">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-body" @click="goToTask(6)">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-8">
                                <span>Zum Stadtteil navigieren</span>
                            </div>

                            <div class="col-2" style="text-align: right;">
                                <img src="/images/Navigation2.png" style="width: 35px">
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="row justify-content-center pb-2">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-body" @click="goToTask(7)">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-6">
                                <span>Stadtteilvideos</span>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end">
                                <div v-for="n in (task7 ? task7.count : 0)" :key="n" class="custom-square-check"></div>
                                <div v-for="n in (3 - (task7 ? task7.count : 0))" :key="n + 'red'" class="custom-square-red"></div>
                            </div>
                            <div class="col-2" style="text-align: right; width: 10%">
                                <div style="background-color: #009bd5; width: 35px; height: 35px; border-radius: 12px; display: inline-flex; justify-content: center; align-items: center;">
                                    <img src="/images/Pfeil-weiss-rechts.png" style="width: 20px; padding: 5px;">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>-->
    </div>
    <div v-if="loading" class="overlay">
        <div class="spinner"></div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "Overview_Lehrer",
    data() {
        return {
            teamName: null,
            teamFoto: null,
            task3: null,
            task4: null,
            task5: null,
            task6: null,
            task7: null,
            loading: true,
            totalTasks: 0,
        }
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        goToTask(taskNumber) {
            this.$router.push({ name: `lehrer-task${taskNumber}` });
        }
    },
    created() {
        axios.all([
            axios.get('/task/get-one-task', { params: { task: 10, trigger: 'overview' } }),
            axios.get('/task/get-one-task', { params: { task: 20, trigger: 'overview' } }),
            axios.get('/task/get-one-task', { params: { task: 30, trigger: 'overview' } }),
            axios.get('/task/get-one-task', { params: { task: 40, trigger: 'overview' } }),
            axios.get('/task/get-all-task', { params: { task: 50 } }),
            axios.get('/task/get-all-task', { params: { task: 70 } })
        ])
            .then(axios.spread((task1, task2, task3, task4, task5Data, task7Data) => {
                this.teamName = task1.data.teamname;
                this.teamFoto = task2.data.teamname;
                this.task3 = task3.data.teamname;
                this.task4 = task4.data.teamname;
                this.task5 = task5Data.data;
                this.task7 = task7Data.data;

                // Compute the total number of tasks found from the responses that contain the 'count' property
                this.totalTasks = (task5Data.data.count || 0) + (task7Data.data.count || 0);

                // Check each `teamname` and increase the count if it's not empty
                if (task1.data.teamname !== '') this.totalTasks += 1;
                if (task2.data.teamname !== '') this.totalTasks += 1;
                if (task3.data.teamname !== '') this.totalTasks += 1;
                if (task4.data.teamname !== '') this.totalTasks += 1;

                console.log(this.totalTasks);
            }))
            .catch(error => {
                console.error(error);
            })
            .finally(() => {
                this.loading = false;  // turn off the loading spinner when all calls are done
            });
    },
    computed: {
        task1Color() {
            console.log(this.teamName);
            return {
                // backgroundColor: this.teamName && this.teamName.length > 0 ? '#B9FBB9)' : '#fff' // Replace the color codes as per your need
            }
        }
    }
}
</script>
<style scoped>

.card-body{
    padding:0!important;
}

.card-header:first-child{
    border:0;
}


/* Add shadow to the cards */
.card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    transition: 0.3s;
}

/* On mouse-over, add a deeper shadow */
.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
}

</style>
