<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';


const message = computed(() => usePage().props.errors);

</script>

<template>
    <div v-if="message.error" class="limitError">
        <p>{{ message.error }}</p>
    </div>
</template>

<style lang="sass" scoped>

.limitError
    background-color: #ffd6d6
    width: 100%
    font-size: 1.2rem
    text-align: center
    border: .2rem inset #ff7a7a
    color: #a60000
    cursor: pointer

</style>