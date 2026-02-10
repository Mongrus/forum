<script setup>

const model = defineModel()

const smiles = [
  '😀','😁','😂','🤣','😊',
  '😇','🙂','🙃','😉',
  '🥰','😍','😘','😋','😜',
  '😎','🤔','😴','😵','🤯',
  '😳','🥵','🥶','😱','😨',
  '😡','🤬','😤','😭','😢',
  '🤡','💩','👿','😈','☠️',
  '👍','👎','👏','🙏','👌',
  '💪','🔥','💯','✅','❌'
]

function createSmile(smile) {
    model.value += smile
}

</script>

<template>
    <div>
        <ul class="smile">
            <li
            v-for="smile in smiles"
            :key="smile"
            @click="createSmile(smile)"
            >
            {{ smile }}
            </li>
        </ul>
    </div>
</template>

<style lang="sass" scoped>

.smile
    display: flex
    justify-content: center
    align-items: center
    background-color: LightGrey
    flex-wrap: wrap
    width: 15vw
    height: 20rem
    border: .1rem solid black
    li
        text-align: center
        width: 2.6rem
        height: 2.6rem
        font-size: 1.7rem
        &:hover
            border: .1rem solid gray
            cursor: pointer

</style>