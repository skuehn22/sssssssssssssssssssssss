<template>
    <div class="container">
        <div class="row pt-3 bg-white">
            <div v-if="task5">
                <!-- Loop through each group -->
                <div v-for="group in allGroups" :key="group" class="mb-3">
                    <strong>{{ group }}</strong>

                    <!-- For each group, loop through the tasks -->
                    <div v-for="taskId in Object.keys(taskTotals)" :key="taskId" class="d-flex align-items-center mt-2">
                        <div class="col-8">{{ taskNames[taskId] }}</div>
                        <div class="col-4 d-flex align-items-center justify-content-end pb-2">
                            <!-- Display squares for each task based on taskTotals -->
                            <template v-for="(n, index) in taskTotals[taskId]" :key="index">
                                <div :class="getSquareClass(task5[taskId] ? task5[taskId][group] : null, n)" class="mr-1"></div>
                            </template>
                        </div>
                    </div>
                    <hr> <!-- Add this line -->
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
            loading: true,
            allGroups: ['Gruppe 1', 'Gruppe 2', 'Gruppe 3', 'Gruppe 4', 'Gruppe 5'],
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
                6: 3
            };
        },
        taskNames() {
            return {
                1: "Teamname",
                2: "Teamfoto",
                3: "Erinnerungsvideos",
                4: "Sprachnotiz",
                6: "Outtakes",
                5: "Stadtteilvideos"
            };
        },

    },
    created() {
        axios.get('/task/get-auswertung', { params: { task: 5 } })
            .then(response => {
                this.task5 = response.data.allTasks;
            })
            .catch(error => {
                console.error(error);
            })
            .finally(() => {
                this.loading = false;
            });
    },
    methods: {
        getSquareClass(tasksForGroup, n) {
            // Check if tasksForGroup is defined
            if (!tasksForGroup) return 'custom-square-red';

            return (tasksForGroup.length >= n) ? 'custom-square-check' : 'custom-square-red';
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
</style>
