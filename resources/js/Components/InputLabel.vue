<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="block text-sm font-medium text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>

<style lang="sass" scoped>

label
    color: Snow
    font-size: 1.3rem
    padding-bottom: .2rem

</style>