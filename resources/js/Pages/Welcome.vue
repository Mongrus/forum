<script setup>
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import myComputer from '../../assets/img/computer.png';

const click = new Audio('/sounds/click.mp3');

function soundPlay() {
    click.play();
}
</script>

<template>
    <Head title="Главная"/>
    <BaseLayout>
        <div class="computer">
            <div>
                <Link @click="soundPlay" :href="route('section.index')">
                    <img :src="myComputer" alt="myComputer">
                    <p>My Computer</p>
                </Link>
            </div>
        </div>
    </BaseLayout>
</template>

<style lang="sass" scoped>

.computer
    sections
    display: flex
    align-content: center
    justify-content: center
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
        color: Snow
        line-height: 1.2
        max-height: 2.4em
        width: 8rem
        overflow: hidden
        text-overflow: ellipsis
        display: -webkit-box
        -webkit-line-clamp: 2
        -webkit-box-orient: vertical
        word-break: break-word

</style>