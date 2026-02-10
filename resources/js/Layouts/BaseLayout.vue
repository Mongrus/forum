<script setup>
import Header from '@/Components/navigation/Header.vue';
import Footer from '@/Components/navigation/Footer.vue';
import Flash from '@/Components/Flash.vue';
import { useMainStore } from '@/stores/main.store';
import { onBeforeUnmount, onMounted } from 'vue';

const store = useMainStore();

onMounted(() => {
    axios.post(route('user.online'))
})

onBeforeUnmount(() => {
    axios.post(route('user.offline'))
})

let heartbeatInterval = null

onMounted(() => {
    axios.post(route('user.online'))

    heartbeatInterval = setInterval(() => {
        axios.post(route('user.online'))
    }, 30000)
})

onBeforeUnmount(() => {
    clearInterval(heartbeatInterval)
    axios.post(route('user.offline'))
})

</script>

<template>
    <div class="layout">
        <Header />
            <Flash />
            <pre></pre>
            <main class="main" :class="`main__${store.layoutColor}`">
                <slot />
            </main>
        <Footer />
    </div>
</template>

<style lang="sass" scoped>

.layout
    min-height: 100vh
    display: flex
    flex-direction: column

.main
    flex: 1
    display: flex
    flex-direction: column
    justify-content: center
    align-items: center
    padding: 1rem
    &__base
        background-color: #008080
    &__green
        background-color: #006400
    &__silver
        background-color: #A9A9A9
    &__purple
        background-color: #6A5ACD


</style>