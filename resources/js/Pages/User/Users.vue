<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import CustomButton from '@/Components/CustomButton.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';
import IsOnlineUser from '@/Components/IsOnlineUser.vue';

defineProps({
    users: Object
})

const auth = computed(() => usePage().props.auth.user);
const friends = computed(() => usePage().props.auth.friends_ids);

function formatLabel(label) {
    if (label === '&laquo; Previous') return 'Назад'
    if (label === 'Next &raquo;') return 'Далее'
    return label
}
</script>

<template>
    <Head title="Список пользователей"/>
    <BaseLayout>
        <BaseWindow>
            <template #title>
                <b>Пользователи:</b>
            </template>
            <template #back>
                <Link :href="route('friends')">← Друзья</Link>
            </template>
            <div v-for="user in users.data" :key="user.id">
                <div class="users win98" :class="user.status === 'admin' || user.status === 'moderator' ? 'administration':''">
                    <div class="users__user">
                        <img class="miniAvatar" :src="`/${user.avatar}`" alt="avatar">
                    </div>
                    <div class="users__info">
                        <h3><b>Имя: </b>{{ user.name }}</h3>
                        <h3><b>Привилегии: </b> {{ user.status }}</h3>
                        <h3 v-if="user.status !== 'admin' && user.status !== 'moderator'"><b>Забанен:</b> <span :class="user.is_banned ? 'ban' : 'notBan'">{{ user.is_banned ? 'Да' : 'Нет'}}</span></h3>
                        <h3><b>Всего постов: </b>{{ user.posts.length }}</h3>
                    </div>
                    <div class="users__online">
                        <IsOnlineUser :status="user.is_online" variant="text"/>
                        <IsOnlineUser :status="user.is_online"/>
                    </div>
                    <div v-if="user.id !== auth.id" class="users__action">
                        <CustomButton variant="blue" class="button">
                            <Link :href="route('profile', user.id)">Профиль</Link>
                        </CustomButton>
                        <CustomButton variant="green" class="button">
                            <Link :href="route('chat', user.id)">Написать</Link>
                        </CustomButton>
                        <CustomButton v-if="!friends.includes(user.id)" variant="green" class="button">
                            <Link :href="route('friend.store', user.id)" method="post">Добавить</Link>
                        </CustomButton>
                        <CustomButton v-else variant="red" class="button">
                            <Link :href="route('friend.delete', user.id)" method="delete">Удалить</Link>
                        </CustomButton>
                        <CustomButton variant="dark" class="button">
                            <template v-if="user.status !== 'admin' && user.status !== 'moderator' && (auth.status === 'admin' || auth.status === 'moderator')">
                                <Link v-if="user.is_banned" :href="route('user.banned', user.id)" method="patch">Разбанить</Link>
                                <Link v-else :href="route('user.banned', user.id)" method="patch">Забанить</Link>
                            </template>
                        </CustomButton>
                    </div>
                    <div>
                        
                    </div>
                </div>
            </div>
            <div class="pagination">
                    <button
                        v-for="link in users.links"
                        :key="link.label"
                        class="pagination__btn"
                        :class="{ 'is-active': link.active }"
                        :disabled="!link.url"
                        @click="$inertia.visit(link.url)"
                    >
                    {{ formatLabel(link.label) }}
                    </button>
                </div>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

.users
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
        justify-content: center
        align-items: center
        width: 60rem

.ban
    color: Crimson

.notBan
    color: green

.administration
    background-color: #3A3A3A
    color: Snow

.button
    justify-content: left

</style>