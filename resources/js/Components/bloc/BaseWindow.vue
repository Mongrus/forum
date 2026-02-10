<script setup>

defineProps({
    theme: {
        type: String,
        default: 'base'
    }
})

</script>


<template>
    <div class="baseWindow" :class="`baseWindow__${theme}`">
        <div class="baseWindow__back">
            <slot name="back" />
        </div>
        <div class="baseWindow__next">
            <slot name="next" />
        </div>
        <h1>
            <slot name="title"/>
        </h1>
        <div class="baseWindow__main">
            <slot/>
        </div>
    </div>
</template>

<style lang="sass" scoped>

.baseWindow
    position: relative
    border: .2rem outset LightGrey
    background-color: Gainsboro
    width: 90vw
    min-height: 30rem
    margin: 3rem 0
    h1
        display: flex
        flex-direction: row
        justify-content: center
        align-items: center
        font-size: 1.6rem
        text-align: center
        padding: .5rem
        margin-bottom: 1.5rem
        border-bottom: .2rem outset LightGrey
        color: white
    &__main
        padding: 1rem
    &__back
        left: .5rem
        padding: .7rem
        position: absolute
        color: Snow
        font-size: 1.5rem
        &:active
            color: LightSteelBlue
    &__next
        right: .5rem
        padding: .7rem
        position: absolute
        color: Snow
        font-size: 1.5rem
        &:active
            color: LightSteelBlue

.baseWindow__base
    h1
        background-color: DarkBlue

.baseWindow__black
    h1
        background-color: #1A1A1A

</style>