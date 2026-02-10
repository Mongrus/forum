<script setup>
import IsOnlineUser from './IsOnlineUser.vue';


defineProps({
    avatar: {
        type: String,
        default: '/avatars/1.png'
    },
    online: {
        type: Boolean,
        default: false
    },
    name: {
        type: String,
        default: 'anonim'
    },
    date: {
        type: String,
        default: ''
    }
})
</script>

<template>
        <div class="userInfo win98">
            <div>
                <img class="miniAvatar" :src="`/${avatar}`" alt="avatar">
                <div class="userInfo__online">
                    <IsOnlineUser :status="online" variant="text"/>
                    <IsOnlineUser :status="online"/>
                </div>
            </div>
            <h3>{{ name }}</h3>
            <h3>{{ new Date(date).toLocaleDateString() }}</h3>
        </div>
</template>

<style lang="sass" scoped>

.userInfo
    margin: 3rem 0
    display: flex
    justify-content: space-between
    align-items: center
    height: max-content
    h3
        font-size: 1.5rem
    &__online
        display: flex
        flex-direction: row
        justify-content: center
        align-items: center

</style>