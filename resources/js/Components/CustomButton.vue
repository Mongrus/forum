<script setup>

defineProps({
  variant: {
    type: String,
    default: 'main'
  }
})

</script>

<template>
    <div class="customButton" :class="`customButton__${variant}`">
        <slot />
    </div>
</template>

<style lang="sass">

.customButton
    display: flex
    flex-direction: row
    align-items: center
    justify-content: center
    a, button
        display: flex
        justify-content: center
        font-size: 1.4rem
        width: 13rem
        height: min-content
        box-shadow: -.5rem -.5rem .5rem -.5rem rgba(34, 60, 80, 0.6) inset

    img
        width: 2rem
        height: 2rem
        margin-right: .3rem


.customButton.customButton__main
    a, button
        background-color: Gainsboro
        border: .3rem outset LightGrey

        &:active
            border: .3rem inset LightGrey


.customButton.customButton__red
    a, button
        background-color: FireBrick
        border: .3rem outset IndianRed
        color: white

        &:active
            border: .3rem inset IndianRed


.customButton.customButton__blue
    a, button
        background-color: SteelBlue
        border: .3rem outset LightSteelBlue
        color: white

        &:active
            border: .3rem inset LightSteelBlue


.customButton.customButton__green
    a, button
        background-color: SeaGreen
        border: .3rem outset MediumSeaGreen
        color: white

        &:active
            border: .3rem inset MediumSeaGreen

.customButton.customButton__dark
    a, button
        background-color: #3A3A3A
        color: #F0F0F0
        border: .3rem outset #7A7A7A
        box-shadow: inset -1px -1px 0 #1A1A1A, inset 1px 1px 0 #9A9A9A

        &:hover
            background-color: #404040

        &:active
            border: .3rem inset #7A7A7A
            box-shadow: inset 1px 1px 0 #1A1A1A, inset -1px -1px 0 #9A9A9A

</style>