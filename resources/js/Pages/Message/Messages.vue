<script setup>
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import CustomButton from '@/Components/CustomButton.vue';
import IsOnlineUser from '@/Components/IsOnlineUser.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, Link} from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineProps({
    chats: Object
})

</script>

<template>
    <Head title="Чаты"/>
    <BaseLayout>
        <BaseWindow>
            <template #title>
                <b>Чаты:</b>
            </template>
            <template #next>
                <Link :href="route('friends')">Друзья →</Link>
            </template>
            <div v-if="chats.length">
                <div v-for="user in chats" :key="user.id" class="chats win98">
                    <div class="chats__user">
                        <h3><b>{{ user.name }}</b></h3>
                        <img class="miniAvatar" :src="`/${user.avatar}`" alt="avatar">
                    </div>
                    <div class="chats__online">
                        <IsOnlineUser :status="user.is_online" variant="text"/>
                        <IsOnlineUser :status="user.is_online"/>
                    </div>
                    <div class="chats__action">
                        <CustomButton variant="green" class="button">
                            <Link :href="route('chat', user.id)">
                                Открыть чат
                            </Link>
                        </CustomButton>
                        <CustomButton variant="blue" class="button">
                            <Link :href="route('profile', user.id)">
                                Профиль
                            </Link>
                        </CustomButton>
                        <CustomButton variant="red" class="button">
                            <Link :href="route('message.delete', user.id)" method="delete">
                                Удалить чат
                            </Link>
                        </CustomButton>
                    </div>
                </div>
                <div class="customWindow__line"></div>
                <div class="infoMessages">
                    <h3>Всего чатов с пользователями - {{ chats.length }}</h3>
                </div>
            </div>
            <div v-else class="notChats">
                <h3>У вас нет чатов, напишите кому-нибудь из 
                    <Link :href="route('friends')"><b>списка друзей</b></Link>
                    или начните общаться с кем-то из 
                    <Link :href="route('users')"><b>списка всех пользователей</b></Link>.
                </h3>
            </div>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

.chats
    display: flex
    flex-direction: row
    justify-content: space-evenly
    align-items: center
    margin: 1rem 10rem
    &__user
        display: flex
        flex-direction: column
        align-items: center
        width: 25rem
        h3
            font-size: 1.3rem
    &__online
        display: flex
        flex-direction: column
        align-items: center
        width: 25rem
    &__action
        display: flex
        flex-direction: row
        align-items: center


.notChats
    h3
        font-size: 1.4rem
    a
        color: indigo
        text-decoration: underline
        &:hover
            color: black

.button
    justify-content: left
    width: 12rem

.infoMessages
    padding-top: .5rem
    h3
        text-align: center
        font-size: 1.3rem

</style>