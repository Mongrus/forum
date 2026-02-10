<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const flash = computed(() => usePage().props.flash)

function clickFlash() {
    usePage().props.flash = '';
}
</script>

<template>
    <div v-if="flash.success" @click="clickFlash">
        <p class="flashSuccess">{{ flash.success }}</p>
    </div>
</template>

<style lang="sass" scoped>

.flashSuccess
    position: absolute
    background-color: LightGreen
    width: 100%
    font-size: 1.2rem
    text-align: center
    border: .2rem inset MediumSeaGreen
    color: green
    cursor: pointer

</style>