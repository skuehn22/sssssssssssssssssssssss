<script setup lang="ts">
import { VueFinalModal } from 'vue-final-modal'

defineProps<{
    title?: string
}>()

const emit = defineEmits<{
    (e: 'confirm'): void,
    (e: 'cancel'): void
}>()
</script>

<template>
    <VueFinalModal
        class="confirm-modal"
        content-class="confirm-modal-content"
        overlay-transition="vfm-fade"
        content-transition="vfm-fade"
    >
        <h1>{{ title }}</h1>
        <slot />

        <div class="row">
            <div class="col-6">   <button @click="emit('cancel')" class="btn btn-secondary" style="padding: 8px; width: 100%;">Cancel</button></div>
            <div class="col-6">  <button @click="emit('confirm')" class="btn btn-primary" style="padding: 8px; width: 100%;">
               Tak Tak
            </button></div>
        </div>



    </VueFinalModal>
</template>

<style>
.confirm-modal {
    position: absolute;
    top: 0; /* position it at the top */
    left: 0; /* start from the leftmost edge */
    width: 100%; /* full width */
    display: flex;
    justify-content: center;
    align-items: flex-start; /* align content to the top instead of center */
}

.confirm-modal-content h1 {
    font-size: 1.375rem;
    text-align: center; /* Center-align the text */
}

.confirm-modal-content {
    width: 100%; /* full width */
    display: flex;
    flex-direction: column;
    padding: 1rem;
    background: #fff;
    border-radius: 0.5rem 0.5rem 0 0;
    text-align: center;
}
.confirm-modal-content > * + *{
    margin: 0.5rem 0;
}
.confirm-modal-content h1 {
    font-size: 1.375rem;
}
.confirm-modal-content button {
    margin: 0.25rem 0 0 auto;
    padding: 0 8px;
    border: 1px solid;
    border-radius: 0.5rem;
}
.dark .confirm-modal-content {
    background: #000;
}
</style>
