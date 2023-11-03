import { createWebHistory, createRouter } from 'vue-router';

import Overview from './components/Overview.vue'
import Start from './components/Start.vue'
import Einleitung from './components/Tasks/Einleitung.vue'
import Drehorte from './components/Tasks/Drehorte.vue'
import Navigation from './components/Tasks/Navigation.vue'

import Task1 from './components/Tasks/Task1.vue'
import Task2 from './components/Tasks/Task2.vue'
import Task2_ViewImage from './components/Tasks/Task2_ViewImage_____.vue'
import Task3_Overview from './components/Tasks/Task3_Overview.vue'
import Task3_VideoRecording from './components/Tasks/Task3_VideoRecording.vue'
import VideoUpload from './components/VideoUpload.vue'
import Task3_VideoOverview from './components/Tasks/Task3_VideoOverview.vue'
import Task4 from './components/Tasks/Task4.vue'
import Task5_Overview from './components/Tasks/Task5_Overview.vue'
import Task5_VideoRecording from './components/Tasks/Task5_VideoRecording.vue'
import Task5_VideoUpload from './components/Tasks/Task5_VideoUpload___________.vue'
import Task5_VideoOverview from './components/Tasks/Task5_VideoOverview.vue'
import Task6 from './components/Tasks/Task6.vue'
import Task6_VideoUpload from './components/Tasks/Task6_VideoUpload_____________.vue'
import Task6_FilesOverview from './components/Tasks/Task6_FilesOverview.vue'
import Task7 from './components/Tasks/Task7.vue'
import Task8 from './components/Tasks/Task8.vue'
import Task_Extra from './components/Tasks/Task_Extra.vue'
import Task_Extra_VideoUpload from './components/Tasks/Task_Extra_VideoUpload.vue'
import Task_Extra_FilesOverview from './components/Tasks/Task_Extra_FilesOverview.vue'

import Overview_Lehrer from './components/Overview_Lehrer.vue'
import Start_Lehrer from './components/Start_Lehrer__.vue'
import LehrerNavigation from './components/TasksLehrer/Navigation.vue'
import Auswertung from './components/TasksLehrer/Auswertung.vue'
import LehrerEinleitung from './components/TasksLehrer/Einleitung.vue'

import LehrerTask1 from './components/TasksLehrer/Task1.vue'
import LehrerTask2 from './components/TasksLehrer/Task2.vue'
import LehrerTask2_ViewImage from './components/TasksLehrer/Task2_ViewImage.vue'

import LehrerTask3 from './components/TasksLehrer/Task3.vue'
import LehrerTask3_VideoRecording from './components/TasksLehrer/Task3_VideoRecording.vue'
import LehrerTask3_VideoUpload from './components/TasksLehrer/Task3_VideoUpload______________.vue'

import LehrerTask4 from './components/TasksLehrer/Task4.vue'

import LehrerTask5_Overview from './components/TasksLehrer/Task5_Overview.vue'
import LehrerTask5_VideoRecording from './components/TasksLehrer/Task5_VideoRecording.vue'
import LehrerTask5_VideoUpload from './components/TasksLehrer/Task5_VideoUpload________.vue'
import LehrerTask5_VideoOverview from './components/TasksLehrer/Task5_VideoOverview.vue'



import LehrerTask6 from './components/TasksLehrer/Task6.vue'

import LehrerTask7 from './components/TasksLehrer/Task7.vue'
import LehrerTask7_VideoUpload from './components/TasksLehrer/Task7_VideoUpload_____________________.vue'
import LehrerTask7_VideoRecording from './components/TasksLehrer/Task7_VideoRecording.vue'
import LehrerTask7_FilesOverview from './components/TasksLehrer/Task7_FilesOverview.vue'

import LehrerTask_Extra from './components/TasksLehrer/Task_Extra.vue'
import LehrerTask_Extra_VideoUpload from './components/TasksLehrer/Task_Extra_VideoUpload.vue'
import LehrerTask_Extra_FilesOverview from './components/TasksLehrer/Task_Extra_FilesOverview.vue'



import OnTourAuswertung from './components/OnTourAuswertung.vue'



const routes = [

    // STUDENTS
    { path: '/home', component: Start, meta: { title: 'Tak Tak' } },
    { path: '/overview', component: Overview, meta: { title: 'Aufgaben' } },
    { path: '/einleitung', component: Einleitung, name: 'einleitung', meta: { title: 'Einleitung' } },
    { path: '/drehorte', component: Drehorte, name: 'drehorte', meta: { title: 'Drehorte' } },

    { path: '/task1/:param?', component: Task1, name: 'task1', meta: { title: 'Teamname' } },
    { path: '/task2', component: Task2, name: 'task2', meta: { title: 'Teamfoto' } },
    { path: '/task2-view', component: Task2_ViewImage, name: 'task2-view', meta: { title: 'Teamfoto' } },
    { path: '/task3', component: Task3_Overview, name: 'task3', meta: { title: 'Erinnerungsvideos' } },
    //{ path: '/task3-upload', component: Task3_VideoUpload, name: 'task3-upload', meta: { title: 'Erinnerungen' } },
    { path: '/task3-recording', component: Task3_VideoRecording, name: 'task3-recording', meta: { title: 'Erinnerungsvideos' } },
    { path: '/task3-videos', component: Task3_VideoOverview, name: 'task3-videos', meta: { title: 'Erinnerungsvideos' } },
    { path: '/task4', component: Task4, name: 'task4', meta: { title: 'Sprachnotiz' } },

    { path: '/task5', component: Task5_Overview, name: 'task5', meta: { title: 'Stadtteilvideos' } },
    { path: '/task5-upload', component: Task5_VideoUpload, name: 'task5-upload', meta: { title: 'Stadtteilvideos' } },
    { path: '/task5-recording', component: Task5_VideoRecording, name: 'task5-recording', meta: { title: 'Stadtteilvideos' } },
    { path: '/task5-videos', component: Task5_VideoOverview, name: 'task5-videos', meta: { title: 'Stadtteilvideos' } },

    { path: '/task6', component: Task6, name: 'task6', meta: { title: 'Outtakes' } },
    { path: '/task6-upload', component: Task6_VideoUpload, name: 'task6-upload', meta: { title: 'Outtakes' } },
    { path: '/task6-files', component: Task6_FilesOverview, name: 'task6-videos', meta: { title: 'Outtakes' } },
    { path: '/task7', component: Task7, name: 'task7', meta: { title: 'Task 7' } },
    { path: '/taskextra', component: Task_Extra, name: 'taskextra', meta: { title: 'Zusatzmaterial' } },
    { path: '/task-extra-upload', component: Task_Extra_VideoUpload, name: 'task-extra-upload', meta: { title: 'Zusatzmaterial' } },
    { path: '/task-extra-files', component: Task_Extra_FilesOverview, name: 'task-extra-videos', meta: { title: 'Zusatzmaterial' } },
    { path: '/task8', component: Task8, name: 'task8', meta: { title: 'Auswertung' } },
    { path: '/task9', component: Navigation, name: 'task9', meta: { title: 'Navigation' } },

    {
        path: '/task-upload/:taskNumber',
        component: VideoUpload,
        name: 'task-upload',
        props: route => ({
            taskNumber: route.params.taskNumber,
            maxVideoDuration: Number(route.query.maxVideoDuration),
            format: route.query.format,
            types: route.query.types,
            wording: route.query.wording,
            amount: Number(route.query.amount),
        }),
        meta: route => ({ title: route.query.wording || 'Video Upload' })
    },



    //TEACHER
    { path: '/home-lehrer', component: Start_Lehrer, meta: { title: 'Übersicht' } },
    { path: '/overview-lehrer', component: Overview_Lehrer, meta: { title: 'Aufgaben' } },
    { path: '/auswertung', component: Auswertung, meta: { title: 'Auswertung' } },

    { path: '/lehrer-task1/:param?', component: LehrerTask1, name: 'lehrer-task1', meta: { title: 'Ihr Teamname' } },
    { path: '/lehrer-task2', component: LehrerTask2, name: 'lehrer-task2', meta: { title: 'Ihr Teamfoto' } },
    { path: '/lehrer-task2-view', component: LehrerTask2_ViewImage, name: 'lehrer-task2-view', meta: { title: 'Ihr Teamfoto' } },

    { path: '/lehrer-task3', component: LehrerTask3, name: 'lehrer-task3', meta: { title: 'Videobotschaft' } },
    { path: '/lehrer-task3-upload', component: LehrerTask3_VideoUpload, name: 'lehrer-task3-upload', meta: { title: 'Videobotschaft' } },
    { path: '/lehrer-task3-recording', component: LehrerTask3_VideoRecording, name: 'lehrer-task3-recording', meta: { title: 'Videobotschaft' } },

    { path: '/lehrer-task4', component: LehrerTask4, name: 'lehrer-task4', meta: { title: 'Klassenfoto' } },

    { path: '/lehrer-task5', component: LehrerTask5_Overview, name: 'lehrer-task5', meta: { title: 'Erinnerungsvideos' } },
    { path: '/lehrer-task5-upload', component: LehrerTask5_VideoUpload, name: 'lehrer-task5-upload', meta: { title: 'Erinnerungsvideos' } },
    { path: '/lehrer-task5-recording', component: LehrerTask5_VideoRecording, name: 'lehrer-task5-recording', meta: { title: 'Erinnerungsvideos' } },
    { path: '/lehrer-task5-videos', component: LehrerTask5_VideoOverview, name: 'lehrer-task5-videos', meta: { title: 'Erinnerungsvideos' } },


    { path: '/lehrer-task6', component: LehrerTask6, name: 'lehrer-task6', meta: { title: 'Zum Stadtteil navigieren' } },


    { path: '/lehrer-task7', component: LehrerTask7, name: 'lehrer-task7', meta: { title: 'Stadtteile' } },
    { path: '/lehrer-task7-upload', component: LehrerTask7_VideoUpload, name: 'lehrer-task7-upload', meta: { title: 'Stadtteile' } },
    { path: '/lehrer-task7-recording', component: LehrerTask7_VideoRecording, name: 'lehrer-task7-recording', meta: { title: 'Stadtteile' } },
    { path: '/lehrer-task7-videos', component: LehrerTask7_FilesOverview, name: 'lehrer-task7-videos', meta: { title: 'Stadtteile' } },

    { path: '/lehrer-taskextra', component: LehrerTask_Extra, name: 'lehrer-taskextra', meta: { title: 'Zusatzmaterial' } },
    { path: '/lehrer-task-extra-upload', component: LehrerTask_Extra_VideoUpload, name: 'lehrer-task-extra-upload', meta: { title: 'Zusatzmaterial' } },
    { path: '/lehrer-task-extra-files', component: LehrerTask_Extra_FilesOverview, name: 'lehrer-task-extra-videos', meta: { title: 'Zusatzmaterial' } },

    { path: '/lehrer-task9', component: LehrerNavigation, name: 'lehrer-task9', meta: { title: 'Navigation' } },

    { path: '/lehrer-einleitung', component: LehrerEinleitung, name: 'lehrer-einleitung', meta: { title: 'Einleitung' } },


    { path: '/auswertung-ontour', component: OnTourAuswertung, meta: { title: 'Auswertung onTour' } },
]

const router = createRouter({
    history: createWebHistory('/app'),
    routes,
})

export default router
