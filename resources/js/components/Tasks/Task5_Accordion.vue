<template>
    <div>
        <div @click="toggleOpen" class="accordion-header">
            <slot name="header"></slot>
            <span class="chevron" :class="isOpen ? 'open' : ''">❯</span> <!-- Add this line -->
        </div>
        <div v-if="isOpen" class="accordion-content"  style="border-top: 1px solid #000; padding: 0;">
            <slot name="body"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        defaultOpen: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            isOpen: this.defaultOpen
        };
    },
    methods: {
        toggleOpen() {
            this.isOpen = !this.isOpen;
        },
    },
};
</script>


<style scoped>
.accordion-header {
    cursor: pointer;
    padding: 10px;
    background-color: #fff;
    border-top: 1px solid #6e6868;
    border-bottom: 1px solid #6e6868;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
    position: relative;
    border-bottom: none;
}

.accordion-content {
    padding: 10px;
    border: none;
    border-top: none;
}

/* Add these styles for the chevron */
.chevron {
    position: absolute;
    right: 15px;
    transition: transform 0.3s ease;
    transform: rotate(0deg);
}

.chevron.open {
    transform: rotate(90deg);
}



</style>
