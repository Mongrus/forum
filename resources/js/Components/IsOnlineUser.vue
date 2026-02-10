<script setup>

defineProps({
    status: {
        type: Boolean,
        default: true
    },
    variant: {
        type: String,
        default: 'circle'
    }
})


</script>

<template>
    <div v-if="variant === 'circle'" class="circle" :class="status ? 'online' : 'offline'">
    </div>
    <div v-else>
        <h3 v-if="status">В сети</h3>
        <h3 v-else>Не в сети</h3>
    </div>
</template>

<style lang="sass" scoped>

h3
    font-size: 1.3rem

.circle
    width: 1rem
    height: 1rem
    border-radius: 50%
    border: 1px solid #f5f5f5
    margin: 0 1rem
    background-color: #9ca3af
    box-shadow: none

.online
    background-color: #22c55e
    animation: pulse 1.5s ease-in-out infinite

.offline
    background-color: #9ca3af

@keyframes pulse
    0%
        transform: scale(1)
        box-shadow: 0 0 0 0 rgba(34,197,94,0.7)
        opacity: 1

    50%
        transform: scale(1.15)
        box-shadow: 0 0 0 6px rgba(34,197,94,0.2)
        opacity: .85

    100%
        transform: scale(1)
        box-shadow: 0 0 0 0 rgba(34,197,94,0)
        opacity: 1

</style>