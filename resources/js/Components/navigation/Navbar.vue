<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';
import hierarchial from '../../../assets/img/expand_hierarchial_array.png'
import winrep from '../../../assets/img/winrep.png'
import main from '../../../assets/img/world.png'
import users from '../../../assets/img/users.png'
import support from '../../../assets/img/msg_question.png'
import message from '../../../assets/img/envelope_closed.png'
import pageUsers from '../../../assets/img/page_users.png'
import CustomButton from '../CustomButton.vue';
import moderation from '../../../assets/img/file_eye.png';
import helpModerator from '../../../assets/img/help_book_cool.png';
import createSection from '../../../assets/img/rename.png';
import createTheme from '../../../assets/img/registration.png';

const user = computed(() => usePage().props.auth.user)

</script>

<template>
    <div class="nav">
        <CustomButton variant="main"> 
            <Link :href="route('welcome')">
                <img :src="main" alt="main">
                <p>Главная</p>
            </Link>
            <Link :href="route('section.index')">
                <img :src="hierarchial" alt="hierarchial">
                <p>Разделы</p>
            </Link>
            <Link :href="route('post.create')">
                <img :src="winrep" alt="create_post">
                <p>Создать</p>
            </Link>
        </CustomButton>

        <CustomButton variant="main">
            <Link :href="route('messages')">
                <img :src="message" alt="create_post">
                <p>Сообщения</p>
            </Link>
            <Link :href="route('friends')">
                <img :src="users" alt="create_post">
                <p>Друзья</p>
            </Link>
            <Link :href="route('users')">
                <img :src="pageUsers" alt="create_post">
                <p>Пользователи</p>
            </Link>
        </CustomButton>
        <CustomButton>        
            <Link :href="route('support.index')">
                <img :src="support" alt="create_post">
                <p>Поддержка</p>
            </Link>
        </CustomButton>
        <CustomButton variant="blue" v-if="!user">
            <Link  :href="route('login')">Войти</Link>
            <Link  :href="route('register')">Регистрация</Link>
        </CustomButton>

        <div v-else class="auth">
            <div class="auth__name">
                <img class="mini" :src="`/${user.avatar}`" alt="avatar">
                <Link :href="route('profile', user.id)">{{ user.name }}</Link>
            </div>
            <CustomButton class="auth" variant="blue">
                <Link class="customButtonBlue" :href="route('logout')" method="post">Выйти</Link>
            </CustomButton>
        </div>
    </div>

    <div v-if="user?.status === 'admin' || user?.status === 'moderator'" class="adminPanel">
        <CustomButton variant="dark"> 
            <Link :href="route('section.create')">
                <img :src="createSection" alt="create_section">
                <p>Создать раздел</p>
            </Link>
            <Link :href="route('theme.create')">
                <img :src="createTheme" alt="create_theme">
                <p>Создать тему</p>
            </Link>
        </CustomButton>

        <div class="adminTitle">
            <div class="customDark"></div>
            ADMIN PANEL
            <div class="customDark"></div>
        </div>

        <CustomButton variant="dark"> 
            <Link :href="route('posts.moderation')">
                <img :src="moderation" alt="moderation">
                <p>Модерация</p>
            </Link>
            <Link :href="route('support.moderation')">
                <img :src="helpModerator" alt="help">
                <p>Обращения</p>
            </Link>
        </CustomButton>
    </div>
</template>

<style lang="sass" scoped>

.nav
    display: flex
    flex-direction: row
    justify-content: space-between

.adminPanel
    display: flex
    flex-direction: row
    justify-content: center
    background-color: #1A1A1A
    padding-top: .3rem
    a
        width: 15rem

.adminTitle
    padding: .2rem 1rem
    margin: 0 10rem
    color: #E6E6E6
    font-size: 1.4rem
    letter-spacing: .15rem
    text-transform: uppercase
    display: flex
    align-items: center
    justify-content: center

.customDark
    width: .4rem
    height: 2rem
    background-color: #3A3A3A
    border-top: 1px solid #8A8A8A
    border-left: 1px solid #8A8A8A
    border-bottom: 1px solid #1A1A1A
    border-right: 1px solid #1A1A1A
    margin: 0 1rem



.auth
    display: flex
    flex-direction: row
    justify-content: center
    align-items: center
    &__name
        display: flex
        flex-direction: row
        text-align: center
        padding: 0 1rem
        a
            font-size: 1.4rem
            &:hover
                    text-decoration: underline
        img
            margin-right: .2rem

.mini
    border: .1rem inset DarkGray
    width: 2.3rem
    height: 2.3rem

</style>