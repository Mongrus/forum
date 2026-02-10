<script setup>
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import CustomButton from '@/Components/CustomButton.vue';
import IsOnlineUser from '@/Components/IsOnlineUser.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';

const {user, posts, my_friends} = defineProps({
    user: Object,
    posts: Object,
    my_friends: Array
})

const auth = computed(() => usePage().props.auth.user)

function formatLabel(label) {
    if (label === '&laquo; Previous') return 'Назад'
    if (label === 'Next &raquo;') return 'Далее'
    return label
}
</script>

<template>
    <Head title="Профиль пользователя"/>
    <BaseLayout>
        <BaseWindow :theme="user.status === 'admin' || user.status === 'moderator' ? 'black' : 'base'">
            <template #title>
                <b v-if="auth.id !== user.id">Профиль пользователя {{ user.name }}</b>
                <b v-else>Добро пожаловать {{ user.name }}</b>
                <IsOnlineUser :status="user.is_online"/>
                <span class="ban" v-if="user.is_banned">Заблокирован</span>
            </template>
            <div class="profile">
                <div class="user">
                    <div class="user__info">
                        <h2>Информация о пользователе:</h2>
                        <div class="user__info__main">
                            <h3><b>Имя:</b> {{ user.name }}</h3>
                            <div class="customWindow__line"></div>
                            <h3><b>Email:</b> {{ user.email }}</h3>
                            <div class="customWindow__line"></div>
                            <div class="user__info__status">
                                <h3><b>Привилегии:</b></h3>
                                <h3 v-if="user.status === 'user'">Пользователь</h3>
                                <h3 v-if="user.status === 'admin'">Администратор</h3>
                                <h3 v-if="user.status === 'moderator'">Модератор</h3>
                            </div>
                            <div class="customWindow__line"></div>
                            <h3><b>Дата регистрации:</b> {{ new Date(user.created_at).toLocaleDateString() }}</h3>
                            <div class="customWindow__line"></div>
                            <div class="user__info__avatar">
                                <img class="avatar" :src="`/${user.avatar}`" alt="avatar">
                                <div v-if="auth.id === user.id">
                                    <h3><b>Изменить аватар:</b></h3>
                                    <CustomButton variant="main">
                                        <Link class="avatarId" :href="route('avatar.update', i)" v-for="i in 16" :key="i" method="put">{{ i }}</Link>
                                    </CustomButton>
                                </div>
                                <div v-else class="action">
                                    <CustomButton variant="green">
                                        <Link :href="route('chat', user.id)"> Открыть чат </Link>
                                    </CustomButton>
                                    <CustomButton v-if="!my_friends.includes(user.id)" variant="blue">
                                        <Link :href="route('friend.store', user.id)" method="post">Стать друзьями</Link>
                                    </CustomButton>
                                    <CustomButton v-else variant="red">
                                        <Link :href="route('friend.delete', user.id)" method="delete">Удалить</Link>
                                    </CustomButton>
                                    <template v-if="user.status !== 'admin' && user.status !== 'moderator' && (auth.status === 'admin' || auth.status === 'moderator')">
                                        <CustomButton v-if="user.is_banned" variant="dark">
                                            <Link  :href="route('user.banned', user.id)" method="patch">Разбанить</Link>
                                        </CustomButton>
                                        <CustomButton v-else variant="dark">
                                            <Link :href="route('user.banned', user.id)" method="patch">Забанить</Link>
                                        </CustomButton>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="user__posts">
                        <div v-if="posts.total > 0">
                            <div>
                                <h2 v-if="auth.id !== user.id">Всего постов у пользователя - {{ posts.total }}</h2>
                                <h2 v-else>Ваши посты - {{ posts.total }}</h2>
                                <div v-for="el in posts.data">
                                <div class="customWindow">
                                    <h3 class="titlePost">
                                        <p>{{ el.title }}</p>
                                        <Link v-if="el.moderation" :href="route('post.show', el.id)">Подробнее >>></Link>
                                    </h3>
                                    <h4>{{ el.description }}</h4>
                                    <div class="customWindow__line"></div>
                                    <div class="customWindow__author">
                                        <p>{{ new Date(el.created_at).toLocaleDateString() }}</p>
                                        <p v-if="el.moderation" class="confirm">Прошел модерацию</p>
                                        <p v-else class="notConfirm">На модерации</p>
                                    </div>
                                </div>
                            </div>
                            </div>
                                <div class="pagination">
                                    <button
                                        v-for="link in posts.links"
                                        :key="link.label"
                                        class="pagination__btn"
                                        :class="{ 'is-active': link.active }"
                                        :disabled="!link.url"
                                        @click="$inertia.visit(link.url)"
                                    >
                                    {{ formatLabel(link.label) }}
                                    </button>
                                </div>
                        </div>
                        <div v-else>
                            <h2>Пользователь не публиковал посты</h2>
                        </div>     
                    </div>
                </div>
            </div>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

.profile
    width: 90vw
    h2
        font-size: 1.5rem
        text-align: center

.user
    display: flex
    justify-content: space-evenly
    min-height: 43rem
    &__posts
        width: 40vw
    &__info
        width: 40vw
        h3
            font-size: 1.3rem
        &__status
            display: flex
            flex-direction: row
            h3
                &:first-child
                    padding-right: .3rem
        &__main
            margin-top: 3rem
        &__avatar
            margin-top: 2rem
            img
                margin-bottom: 1rem

.titlePost
    display: flex
    flex-direction: row
    align-items: center
    justify-content: space-between
    padding: 0 1rem

.confirm
    color: green

.notConfirm
    color: Crimson

.action
    display: flex
    flex-direction: row
    justify-content: center
    align-items: center
    min-height: 16rem

.ban
    color: Crimson
    border: 1px solid Crimson
    padding: 0 1rem
    font-size: 1.7rem

</style>