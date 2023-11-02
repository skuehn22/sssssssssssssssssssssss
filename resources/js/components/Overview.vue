<template>
    <div class="container">
        <div class="row justify-content-center  pb-3">
            <div class="col-md-8 text-center">
                <div class="image-progress-wrapper" style="display: flex; flex-direction: column; align-items: center; width: 100%;">

                    <!-- Progress Bar -->
                    <div style="width: 100%;">
                        <div class="progress" style="height: 30px; position: relative;">
                            <div class="progress-bar"
                                 :class="totalTasks === maxTasks ? 'bg-green' : 'bg-orange'"
                                 role="progressbar"
                                 :style="{ width: progressPercentage + '%' }"
                                 aria-valuenow="25"
                                 aria-valuemin="0"
                                 aria-valuemax="100">

                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: black;">
                                    {{ totalTasks }} / {{ maxTasks }} Aufgaben erledigt
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center bg-white pb-3">
            <div class="col-md-8 text-center">
                <span style="font-weight: 700; font-size: 22px;">Unser Team</span> <br>Diese Aufgaben könnt Ihr jederzeit bearbeiten
            </div>
        </div>
        <div class="row justify-content-center pt-2 pb-2">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-body task1" @click="goToTask(1)" :style="task1Color">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-6">
                                <span>Teamname</span>
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
                                <span>Teamfoto</span>
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
                    <div class="card-body" @click="goToTask(3)">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-6">
                                <span>Erinnerungsvideos</span>
                                <!--<p v-if="task2 && (task2.count === 1 || task2.count === 2)" style="font-weight: 500">{{ task2.count }} von 3 Videos abgegeben</p>-->
                            </div>
                            <div class="col-4 d-flex align-items-center  justify-content-end">
                                <div v-for="n in (task3 ? task3.count : 0)" :key="n" class="custom-square-check"></div>
                                <div v-for="n in (5 - (task3 ? task3.count : 0))" :key="n + 'red'" class="custom-square-red"></div>
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
        <div class="row justify-content-center bg-white">
            <div class="col-md-8 text-center">
                <span style="font-weight: 700; font-size: 22px;">Stadtteilerkundung</span> <br>Diese Aufgaben während der Stadtteilerkundung bearbeiten
            </div>
        </div>
        <div class="row justify-content-center  pt-2">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-body" @click="goToTask(9)">
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
                    <div class="card-body" @click="goToTask(5)">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-6">
                                <span>Stadtteilvideos</span>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end">
                                <div v-for="n in (task5 ? task5.count : 0)" :key="n" class="custom-square-check"></div>
                                <div v-for="n in (3 - (task5 ? task5.count : 0))" :key="n + 'red'" class="custom-square-red"></div>
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
        <div class="row justify-content-center bg-white  pt-2 pb-2">
            <div class="col-md-8 text-center">
                <span style="font-weight: 700; font-size: 22px;">Unser Erlebnisse</span> <br>Diese Aufgaben könnt Ihr jederzeit bearbeiten
            </div>
        </div>
        <div class="row justify-content-center pt-2 pb-2">
            <div class="col-md-12">




            </div>
        </div>
        -->


        <div class="row justify-content-center bg-white">
            <div class="col-md-8 text-center">
                <span style="font-weight: 700; font-size: 22px;">Videoprojekt abschließen</span>
            </div>
        </div>

        <div class="row justify-content-center pt-2 pb-2">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-body" @click="goToTask(4)">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-6">
                                <span>Sprachnotiz</span>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end">
                                <!-- Green square if teamFoto has length greater than 0 -->
                                <div v-if="task4 && task4.length > 0" class="custom-square-check"></div>

                                <!-- Red square if teamFoto is null or has no length -->
                                <div v-else class="custom-square-red" ></div>
                            </div>
                            <div class="col-2" style="text-align: right; width: 10%">
                                <div style="background-color: #009bd5; width: 35px; height: 35px; border-radius: 12px; display: inline-flex; justify-content: center; align-items: center;">
                                    <img src="/images/Pfeil-weiss-rechts.png" style="width: 20px; padding: 5px;">
                                </div>
                            </div>
                        </div>

                        <!-- ... rest of your code -->
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-body" @click="goToTask(6)">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-6">
                                <span>Outtakes</span>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end">
                                <div v-for="n in (task6 ? task6.count : 0)" :key="n" class="custom-square-check"></div>
                                <div v-for="n in (3 - (task6 ? task6.count : 0))" :key="n + 'red'" class="custom-square-red"></div>
                            </div>
                            <div class="col-2" style="text-align: right; width: 10%">
                                <div style="background-color: #009bd5; width: 35px; height: 35px; border-radius: 12px; display: inline-flex; justify-content: center; align-items: center;">
                                    <img src="/images/Pfeil-weiss-rechts.png" style="width: 20px; padding: 5px;">
                                </div>
                            </div>
                        </div>

                        <!-- ... rest of your code -->
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-body" @click="goToTask(8)">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <div class="col-8">
                                <span>Abschließen & Bewerten</span>
                            </div>
                            <div class="col-2 d-flex align-items-center justify-content-end">
                                <div v-if="task8 && task8.status == 'success'" class="custom-square-check"></div>
                                <div v-else class="custom-square-red" ></div>
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
        <div class="row justify-content-center pt-3 pb-3">
            <div class="col-md-8">
                <button type="button" class="btn btn-info" style="margin-left: 5px;background-color: #fff; border: 1px solid #009bd5; color: #009bd5;" @click="goToTask('extra')">Datei hochladen</button>
            </div>
        </div>
        -->


    </div>
    <div v-if="loading" class="overlay">
        <div class="spinner"></div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "Overview",
    data() {
        return {
            teamName: null,
            teamFoto: null,
            task3: null,
            task4: null,
            task5: null,
            task6: null,
            task8: null,
            loading: true,
            totalTasks: 0,
            user: null
        }
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        goToTask(taskNumber) {
            this.$router.push({ name: `task${taskNumber}` });
        }
    },
    created() {
        // Using axios.all to manage multiple requests concurrently
        axios.all([
            axios.get('/task/get-one-task', { params: { task: 1, trigger: 'overview' } }),
            axios.get('/task/get-one-task', { params: { task: 2, trigger: 'overview' } }),
            axios.get('/task/get-all-task', { params: { task: 3 } }),
            axios.get('/task/get-one-task', { params: { task: 4, trigger: 'overview' } }),
            axios.get('/task/get-all-task', { params: { task: 5 } }),
            axios.get('/task/get-all-task', { params: { task: 6 } }),
            axios.get('/task/get-user-data', { params: { task: 8 } })



        ])
            .then(axios.spread((task1, task2, task3Data, task4, task5Data, task6Data, task8) => {
                this.teamName = task1.data.teamname;
                this.teamFoto = task2.data.teamname;
                this.task3 = task3Data.data;
                this.task4 = task4.data.teamname;
                this.task5 = task5Data.data;
                this.task6 = task6Data.data;
                this.task8 = task8.data;

                // Reset totalTasks
                this.totalTasks = 0;

                [this.teamName, this.teamFoto, this.task4].forEach(task => {
                    if (task && typeof task === 'string' && task.length > 0) {
                        this.totalTasks++;
                        console.log('Incremented for teamName, teamFoto, or task4:', task);
                    }
                });

                if (this.task8 && this.task8.status === 'success') {
                    this.totalTasks++;
                    console.log('Incremented for task8:', this.task8);
                }

                [this.task3, this.task5, this.task6].forEach(task => {
                    if (Array.isArray(task)) {
                        console.log('Incremented for array task (task3, task5, or task6). Adding length:', task.length);
                        this.totalTasks += task.length;
                    }
                });

                [this.task3, this.task5, this.task6].forEach(task => {
                    if (task && typeof task.count === 'number') {
                        console.log('Incremented for task with count (task5 or task6). Adding count:', task.count);
                        this.totalTasks += task.count;
                    }
                });







            }))
            .catch(error => {
                console.error(error);
            })
            .finally(() => {
                this.loading = false;
            });

    },
    computed: {
        task1Color() {
            return {
                backgroundColor: this.teamName && this.teamName.length > 0 ? '#fff' : '#fff'
            }
        },
        progressPercentage() {
            let maxTasks = this.user && this.user.role == 2 ? 7 : 15;
            return (this.totalTasks / maxTasks) * 100;
        },
        maxTasks() {
            return this.user && this.user.role == 2 ? 7 : 15;
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
