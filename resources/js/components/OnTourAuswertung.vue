<template>
    <div class="container">
        <div class="row  bg-white">
            <div class="col-4">
                <div class="booking-form">
                    <input v-model="bookingNumber" type="text" class="form-control" placeholder="Buchungsnummer eingeben" value="11175">
                </div>
            </div>
            <div class="col-2">
                <button @click="getClasses" class="btn" style="background-color: #0a58ca; color: #fff;">Suchen</button>
            </div>
        </div>
        <div class="row bg-white pb-3" style="padding: 0; padding-left: 10px;"  v-if="classes.length">
            <div class="col-4">
                <div class="booking-form">
                    <select v-if="classes.length" v-model="selectedClass" class="mt-2 form-control">
                        <option value="">Bitte Klasse auswählen</option>
                        <option v-for="classItem in classes" :key="classItem.id" :value="classItem.id">{{ classItem.name }}</option>
                    </select>
                </div>
            </div>

            <div class="col-2">
                <button @click="fetchAuswertung" class="btn" v-if="classes.length" style="background-color: #98800a; color: #fff;margin-top: 7px;margin-left: -3px;">Refresh</button>
            </div>

        </div>


        <div class="row pt-3 bg-white" v-if="task5">
            <div class="col-1">

            </div>
            <div class="col-2" style="text-align: center;">
                <strong>Aufgabe 1 <br> Teamname</strong>
            </div>
            <div class="col-1" style="text-align: center;">
                <strong>Aufgabe 2 <br> Teamfoto</strong>
            </div>
            <div class="col-2" style="text-align: center;">
                <strong>Aufgabe 3 <br> Erinnerungen</strong>
            </div>
            <div class="col-1" style="text-align: center;">
                <strong>Aufgabe 4 <br> Sprachnotiz</strong>
            </div>
            <div class="col-1" style="text-align: center;">
                <strong>Aufgabe 5 <br> Outtakes</strong>
            </div>
            <div class="col-1" style="text-align: center;">
                <strong>Aufgabe 6 <br> Stadtteil</strong>
            </div>
            <div class="col-1" style="text-align: center;">
                <strong>Aufgabe 7 <br> Videobotschaft</strong>
            </div>
            <div class="col-1" style="text-align: center;">
                <strong>Aufgabe 8 <br> Klassenfoto</strong>
            </div>
        </div>
        <div class="row bg-white" v-if="task5 && classes.length">
            <div class="col-12">
                <hr>
            </div>
        </div>

        <div class="row pt-3 bg-white" v-if="task5">
            <div>
                <!-- Loop through each group -->
                <div v-for="group in allGroups" :key="group" class="mb-3">
                    <div class="col-12 d-flex align-items-center">
                        <div class="col-1 font-weight-bold"><strong>{{ group }}</strong></div>
                        <!-- For each group, loop through the tasks -->
                        <template v-for="taskId in Object.keys(taskTotals)">
                            <!-- Conditionally set col-3 for task 1, col-2 for task 5, and col-1 for other tasks -->
                            <div :class="taskId == '1' ? 'col-2' : taskId == '3' ? 'col-2' : 'col-1'"  style="text-align: center;">

                                <!-- Display team name for task 1 -->
                                <div v-if="taskId == '1' && task5[taskId] && task5[taskId][group]">
                                    {{ task5[taskId][group][0]['value'] }}
                                </div>

                                <!-- Check if it's not task1 to render the squares -->
                                <template v-if="taskId != '1'" v-for="(n, index) in taskTotals[taskId]" :key="index">
                                    <template v-if="task5[taskId] && task5[taskId][group] && getSquareClass(task5[taskId][group], n) === 'custom-square-check'">
                                        <a :href="'/uploads/' + task5[taskId][group][0]['value']" target="_blank">
                                            <div class="mr-1 inline-block custom-square-check"></div>
                                        </a>
                                    </template>
                                    <template v-else>
                                        <div :class="getSquareClass(task5[taskId] && task5[taskId][group] ? task5[taskId][group] : [], n)" class="mr-1 inline-block"></div>
                                    </template>
                                </template>

                            </div>
                        </template>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        <div class="row bg-white pb-5"  v-if="task5">
            <div class="col-12">
                <a :href="zipUrl" v-if="zipUrl" download style="color: #032152; text-decoration: none;">
                    <i class="fas fa-download"></i>  Alle Dateien herunterladen
                </a>
            </div>
        </div>
        <div class="row bg-white" style="padding-top: 0px; padding-bottom: 0px;" v-if="veranstalter">
            <div class="col-2">
                <strong>Veranstalter:</strong>
            </div>
            <div class="col-4">
                <div v-if="veranstalter">
                    {{veranstalter['name']}}
                </div>
            </div>
        </div>
        <div class="row bg-white" style="padding-top: 0px; padding-bottom: 0px;"  v-if="task5">
            <div class="col-2">
                <strong>Schulname:</strong>
            </div>
            <div class="col-4">
                <div v-if="data">
                    {{data['school']}}
                </div>
            </div>
        </div>
        <div class="row bg-white"  style="padding-top: 0px; padding-bottom: 0px;" v-if="task5">
            <div class="col-2">
                <strong>Klassenname:</strong>
            </div>
            <div class="col-4">
                <div v-if="data">
                    {{data['classname_teacher']}}
                </div>
            </div>
        </div>
        <div class="row bg-white pb-1"  style="padding-top: 0px; padding-bottom: 0px;" v-if="task5">
            <div class="col-2">
                <strong>E-Mail Durchführender:</strong>
            </div>
            <div class="col-4">
                <div v-if="lehrer_data">
                    {{lehrer_data['email']}}
                </div>
            </div>
        </div>
        <div class="row bg-white pb-1"  v-if="task5 && schuler">
            <div class="col-2">
                <strong>Schülernamen:</strong>
            </div>
            <div class="col-4">
                <div v-for="s in schuler" class="mb-1">
                    {{s['name']}}
                </div>
            </div>

        </div>
        <div class="row bg-white pb-1"  v-if="task5 && lehrer">
            <div class="col-2">
                <strong>Lehrernamen:</strong>
            </div>
            <div class="col-4">
                <div v-for="l in lehrer" class="mb-1">
                    {{l['name']}}
                </div>
            </div>

        </div>

    </div>

    <div v-if="loading" class="overlay">
        <div class="spinner"></div>
    </div>
</template>


<script>
import axios from "axios";

export default {
    name: "Auswertung",
    data() {
        return {
            teamName: null,
            teamFoto: null,
            task3: null,
            task4: null,
            task5: null,
            task6: null,
            loading: false,
            allGroups: ['Gruppe 1', 'Gruppe 2', 'Gruppe 3', 'Gruppe 4', 'Gruppe 5', 'Gruppe 6'],
            bookingNumber: "",
            classes: [],
            selectedClass: null,
            zipUrl: null,
            schuler: null,
            lehrer: null,
            schule: null,
            mail: null,
            klassenname: null,
            veranstalter: null,
            data: null,
            lehrer_data: null,
            allTasks: [],
            op: null
        };
    },
    computed: {
        taskTotals() {
            return {
                1: 1,
                2: 1,
                3: 5,
                4: 1,
                5: 3,
                6: 3,
                7: 1,
                8: 1
            };
        },
        taskNames() {
            return {
                1: "Aufgabe 1 Teamname",
                2: "Aufgabe 2 Teamfoto",
                3: "Aufgabe 3 Erinnerungsvideos",
                4: "Aufgabe 4 Sprachnotiz",
                6: "Aufgabe 5 Outtakes",
                5: "Aufgabe 6 Stadtteilvideos",
                7: "Aufgabe 7 Videobotschaft",
                8: "Aufgabe 8 Klassenfoto"
            };
        },

    },
    watch: {
        selectedClass(newValue, oldValue) {
            if (newValue !== oldValue) {
                console.log("start fetchAuswertung");
                this.fetchAuswertung();
            }
        }
    },
    methods: {

        downloadAndDeleteFile() {
            // Wait for some time to ensure the download has started (e.g., 5 seconds). Adjust as needed.
            setTimeout(() => {
                this.deleteFileFromServer();
            }, 5000);
        },

        deleteFileFromServer() {
            // Assuming bookingNumber is either a data property or a computed property
            let bookingNumber = this.bookingNumber;

            // Ensure you have a booking number before proceeding
            if (!bookingNumber) {
                console.error("Booking number is not provided");
                return;
            }

            // Assuming you have an endpoint to handle the file deletion
            axios.post('/delete-zip', {
                fileUrl: this.zipUrl,
                bookingNumber: bookingNumber  // Add booking number to the payload
            })
                .then(() => {
                    console.log("File deleted successfully");
                    this.zipUrl = null;  // Optionally clear the download link
                })
                .catch(error => {
                    console.error("Error deleting file:", error);
                });
        },

        getSquareClass(tasksForGroup, n) {
            // Check if tasksForGroup is defined
            if (!tasksForGroup) return 'custom-square-red';

            return (tasksForGroup.length >= n) ? 'custom-square-check' : 'custom-square-red';
        },

        getClasses() {
            // Clear out the old classes
            this.classes = [];
            this.task5 = null;
            this.schuler= null,
            this.lehrer= null,
            this.schule= null,
            this.mail= null,
            this.klassenname= null,
            this.veranstalter= null,
            this.data= null,
            this.lehrer_data= null

            this.loading = true;
            axios.get('/task/get-classes', { params: { task: 5, bookingNumber: this.bookingNumber } })
                .then(response => {
                    this.classes = response.data.classes;
                })
                .catch(error => {
                    console.error(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },


        fetchAuswertung() {
            console.log("start fetchAuswertung2");

            this.loading = true;
            this.task5 = [];
            this.schuler= null,
            this.lehrer= null,
            this.schule= null,
            this.mail= null,
            this.klassenname= null,
            this.veranstalter= null,
            this.data= null,
            this.lehrer_data= null

            axios.get('/task/get-auswertung-ontour', {
                params: {
                    task: 5,
                    bookingNumber: this.bookingNumber,
                    classId: this.selectedClass   // sending the selected class ID
                }
            })
                .then(response => {

                    console.log("alltask1");
                    console.log(response.data.allTasks);


                    this.task5 = response.data.allTasks;
                    this.zipUrl = response.data.zipUrl;
                    this.schuler = response.data.schuler;
                    this.lehrer = response.data.lehrer;
                    this.data = response.data.data;
                    this.veranstalter = response.data.op;
                    this.lehrer_data = response.data.lehrer_data;
                })
                .catch(error => {
                    console.log("alltask2");
                    console.error(error);
                })
                .finally(() => {
                    console.log("alltask3");
                    this.loading = false;
                });
        }

    }
}
</script>

<style scoped>
.custom-square-check {
    width: 20px;
    height: 20px;
    background-color: green;
}

.custom-square-red {
    width: 20px;
    height: 20px;
    background-color: red;
}

.booking-form {
    display: flex;
    align-items: center;
    gap: 10px;
}

.inline-block {
    display: inline-block;
}

.container{
    min-width: 97%!important;
}

</style>
