<script setup>
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import CustomButton from '@/Components/CustomButton.vue';
import IsOnlineUser from '@/Components/IsOnlineUser.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';

defineProps({
    friends: Object
});

const user = computed(() => usePage().props.auth.user);

</script>

<template>
    <Head title="Друзья"/>
    <BaseLayout>
        <BaseWindow>
            <template #title>
                <b>Друзья пользователя {{ user.name }}</b>
            </template>
            <template #back>
                <Link :href="route('messages')">← Чаты</Link>
            </template>
            <template #next>
                <Link :href="route('users', user.id)">Пользователи →</Link>
            </template>
                <div v-if="friends.length" >
                    <div v-for="friend in friends" class="friends win98">
                        <div class="friends__user">
                            <h3>{{ friend.name }}</h3>
                            <img class="miniAvatar" :src="`/${friend.avatar}`" alt="avatar">
                        </div>
                        <div class="friends__info">
                            <h3><b>Привилегии:</b> {{ friend.status }}</h3>
                            <h3><b>email:</b> {{ friend.email }}</h3>
                            <h3><b>Дата регистрации:</b> {{ new Date(friend.created_at).toLocaleDateString() }}</h3>
                            <h3><b>Забанен:</b> {{ friend.is_banned ? 'Да' : 'Нет'}}</h3>
                        </div>
                        <div class="friends__online">
                            <IsOnlineUser :status="friend.is_online" variant="text"/>
                            <IsOnlineUser :status="friend.is_online"/>
                        </div>
                        <div class="friends__action">
                            <CustomButton variant="green" class="button">
                                <Link :href="route('chat', friend.id)">Написать</Link>
                            </CustomButton>
                            <CustomButton variant="blue" class="button">
                                <Link :href="route('profile', friend.id)">Профиль</Link>
                            </CustomButton>
                            <CustomButton variant="red" class="button">
                                <Link :href="route('friend.delete', friend.id)" method="delete">Удалить</Link>
                            </CustomButton>
                        </div>
                    </div>
                    <div class="customWindow__line"></div>
                    <div class="infoFriends">
                        <h3>Всего друзей - {{ friends.length }}</h3>
                    </div>
                </div>
                <div v-else class="notFriends">
                    <h3>
                        Ваш список друзей пока пуст, перейдите на вкладку
                        <b><Link :href="route('users')">"Пользователи"</Link></b>
                        и найдите друзей.
                    </h3>
                </div>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

.friends
    display: flex
    flex-direction: row
    justify-content: space-between
    align-items: center
    margin: 1rem
    h3
        font-size: 1.3rem
    &__user
        display: flex
        flex-direction: column
        align-items: center
        justify-content: left
        width: 20rem
    &__info
        display: flex
        flex-direction: column
        align-items: left
        justify-content: left
        width: 25rem
    &__online
        display: flex
        flex-direction: row
        align-items: center
        justify-content: center
        width: 10rem
    &__action
        display: flex
        flex-direction: row
        align-items: center

.notFriends
    h3
        font-size: 1.4rem
    a
        color: indigo
        text-decoration: underline
        &:hover
            color: black

.button
    justify-content: left

.infoFriends
    padding-top: .5rem
    h3
        text-align: center
        font-size: 1.3rem

</style>