<template>
    <div class="modal" :class="{ 'show d-block': true }">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Löschen bestätigen</h5>
                    <button type="button" class="btn-close" @click="$emit('close-modal')"></button>
                </div>
                <div class="modal-body">
                    <p>Soll die Datei wirklich gelöscht werden?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="$emit('close-modal')">Nein</button>
                    <button type="button" class="btn btn-danger" @click="deleteVideo">Ja, löschen</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['videoId'],
    methods: {
        deleteVideo() {
            this.$emit('delete-video', this.videoId);
        },
    },
};
</script>
