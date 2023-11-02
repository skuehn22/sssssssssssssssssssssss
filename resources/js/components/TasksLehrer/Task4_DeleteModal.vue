<template>
    <div class="modal" :class="{ 'show d-block': true }">
        <div class="modal-dialog modal-delete">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Löschen bestätigen</h5>
                    <button type="button" class="btn-close" @click="$emit('close-modal')"></button>
                </div>
                <div class="modal-body">
                    <p>Soll die Datei wirklich gelöscht werden?</p>
                </div>
                <div class="modal-footer">
                    <div class="row w-100"> <!-- An inner container to hold the grid -->
                        <div class="col-6">
                            <button type="button" class="btn btn-primary w-100" @click="$emit('close-modal')">Nein</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-danger w-100" @click="deleteFile">Ja, löschen</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    props: ['videoId'],
    methods: {
        deleteFile() {
            console.log("hier");
            this.$emit('delete-file', this.videoId);
        },
    },
};
</script>
