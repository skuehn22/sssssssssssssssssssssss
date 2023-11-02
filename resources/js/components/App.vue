<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style=" position: sticky; top:0; padding:0;">
            <div class="container">
                <!-- Conditional rendering of back arrow -->
                <a v-if="showBackOption" @click.prevent="goBack" class="navbar-brand" style="cursor: pointer; margin-right: 0; font-size: 27px; color: #009BD5;">
                    <img src="/images/Pfeil-blau-links-zurueck.png" style="width: 20px; padding-left:5px;">
                </a>

                <!-- Display the heading here -->
                <span class="navbar-text mx-auto" style="font-weight: 900; font-size: 21px;"><strong>{{ heading }}</strong></span>

                <a class="nav-link" @click="showLogoutConfirmation">
                    <img src="/images/ausloggen.png" style="width: 29px; padding-right:5px;">
                </a>
            </div>
        </nav>

        <main class="pt-4">
            <ModalsContainer />
            <router-view></router-view>
        </main>
    </div>
    <div class="modal fade" id="countdownModal" tabindex="-1" aria-labelledby="countdownModalLabel" aria-hidden="true" style="display: none;" ref="countdownModalRef">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="countdownModalLabel">dsfsdf</h5>
                </div>
                <div class="modal-body">
                 dsfsdf
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="confirmLogout"> sdfdsf</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import $ from 'jquery';
import axios from 'axios';
import { useRouter } from 'vue-router';
import ModalInfo from "./Modal.vue";
import 'vue-final-modal/style.css'
import { ModalsContainer, useModal } from 'vue-final-modal'

export default {
    components: {ModalsContainer, ModalInfo},
    data() {
        return {
            user: null,
            heading: 'Default Heading',
            showBackOption: true,
            showLogoutModal: false,
            modal: false,
        };
    },
    methods: {

        cancelLogout() {
            this.showLogoutModal = false;
        },
        confirmLogout() {
            axios.post('/logout')
                .then(response => {
                    this.$router.push('/home');
                    window.location.reload();
                })
                .catch(error => {
                    console.error(error);
                });
        },
        goBack() {

            if (this.$route.path === '/task2') {
                this.$router.push('/overview');
            } else {
                if (this.$route.path === '/overview') {
                    this.$router.push('/home');
                }else{
                    this.$router.go(-1);
                }
            }
        },
    },
    watch: {
        '$route': {
            immediate: true,
            handler(to, from) {
                // Update the heading when the route changes
                this.heading = to.meta.title || this.heading;

                // Control the visibility of the back arrow
                console.log(to.path);
                this.showBackOption = to.path !== '/home' && to.path !== '/task1/new';

            }
        }
    },
    setup() {
        const router = useRouter();
        const { open, close } = useModal({
            component: ModalInfo,
            attrs: {
                title: 'Abmelden',
                onConfirm() {
                    confirmLogout() // logout the user when "Ja" is clicked
                },
                onCancel() {
                    close() // just close the modal when "abbrechen" is clicked
                },
            },
            slots: {
                default: '<p>Möchtet Ihr Euch wirklich abmelden?</p>',
            },
        });

        const confirmLogout = () => {
            router.push('/home');
            axios.post('/logout')
                .then(response => {
                    // Notice the change here from this.$router to router
                    window.location.reload();
                })
                .catch(error => {
                    console.error(error);
                });
        };

        // Define the method here
        const showLogoutConfirmation = () => {
            open();
        };

        return {

            open,
            close,
            showLogoutConfirmation,
            confirmLogout
        };
    }
    ,
};
</script>
<style>

.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    width: 300px;
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
}

.modal-close {
    position: absolute;
    top: 20px;
    right: 20px;
    cursor: pointer;
}

</style>

