<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import section from '../../../assets/img/directory_open_file.png'
import BaseWindow from '@/Components/bloc/BaseWindow.vue';

defineProps({
    sections: Object
})

const click = new Audio('/sounds/click.mp3');

function soundPlay() {
    click.play();
}
</script>

<template>
    <Head title="Разделы"/>
    <BaseLayout>
        <BaseWindow>
            <template #title>
                <b>Разделы:</b>
            </template>         
            <div>
                <div class="sections">
                    <div v-for="el in sections" :key="el.id">
                        <Link @click="soundPlay" :href="route('theme.index', el.id)">
                            <img :src="section" alt="section">
                            <p>{{ el.title }}</p>
                        </Link>
                    </div>
                </div>
                <div class="customWindow__line"></div>
                <div class="infoSections">
                    <h2>Всего разделов на форуме - {{ sections.length }}</h2>
                </div>
            </div>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

.sections
    display: flex
    flex-wrap: wrap
    align-content: flex-start
    min-height: 42rem
    div
        width: 8rem
        height: 9rem
        margin: .5rem
        border-radius: .3rem
        display: flex
        justify-content: center
        align-items: center
        &:hover
            outline: .1rem dashed #777
    a
        width: 100%
        height: 100%
        padding: .4rem
        display: flex
        flex-direction: column
        justify-content: flex-start
        align-items: center
        gap: .4rem
        text-decoration: none
        font-size: 1.2rem
        &:active img,
        &:active p
            background-color: DarkBlue
            color: #ffffff

        &:active img
            border-radius: .3rem
    img
        width: 4.2rem
        height: 4.2rem
        flex-shrink: 0
    p
        text-align: center
        line-height: 1.2
        max-height: 2.4em
        overflow: hidden
        text-overflow: ellipsis
        display: -webkit-box
        -webkit-line-clamp: 2
        -webkit-box-orient: vertical
        word-break: break-word

.infoSections
    h2
        text-align: center
        font-size: 1.3rem


</style>