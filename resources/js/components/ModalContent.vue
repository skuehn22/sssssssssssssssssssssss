<template>
    <div class="modal-backdrop">
        <div class="modal-content" style="background-color: #fff;">
            <span class="close-icon" @click="$emit('close')">&times;</span>
            <p>{{ content }}</p>
        </div>
    </div>
</template>


<script>
export default {
    props: {
        content: String,
    },
}
</script>

<style scoped>
.modal-backdrop {
    /* Existing styles for backdrop */
}

.modal-content {
    /* Existing styles for modal content */
    position: relative; /* Required for absolute positioning of the close icon */
}

.close-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    font-size: 1.5rem; /* Larger 'X' icon */
    color: #000; /* Icon color */
}
</style>

