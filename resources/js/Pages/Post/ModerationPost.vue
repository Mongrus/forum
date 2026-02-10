<script setup>
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import CustomButton from '@/Components/CustomButton.vue';
import UserInfo from '@/Components/UserInfo.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Link, Head } from '@inertiajs/vue3';

defineProps({
    posts: Object
})

function formatLabel(label) {
    if (label === '&laquo; Previous') return 'Назад'
    if (label === 'Next &raquo;') return 'Далее'
    return label
}

</script>

<template>
    <Head title="Модерация постов пользователей"/>
    <BaseLayout>
        <BaseWindow theme="black">
            <template #title>
                <b>Посты на модерации (административная страница)</b>
            </template>
            <div class="posts">
                <div class="posts__post win98" v-for="post in posts.data">
                    <div class="posts__section">
                        <h3><b>№:</b> {{ post.id }}</h3>
                        <h3><b>Раздел:</b> {{ post.section.title }}</h3>
                        <h3><b>Тема:</b> {{ post.theme.title }}</h3>
                    </div>
                    <div class="posts__main">
                        <h3><b>Заголовок:</b> {{ post.title }}</h3>
                        <div class="customWindow__line"></div>
                        <h3><b>Текст поста:</b> {{ post.description }}</h3>
                        <div class="customWindow__line"></div>
                        <h3><b>Пользователь забанен:</b> <span :class="post.author.is_banned ? 'ban' : 'notBan'">{{ post.author.is_banned ? 'да' : 'нет' }}</span></h3>
                        <UserInfo :avatar="post.author.avatar" :name="post.author.name" :online="post.author.is_online" :date="new Date(post.created_at).toLocaleDateString()" />
                        <div class="action">
                            <CustomButton variant="dark">
                                <Link :href="route('post.confirm', post.id)" method="patch">Одобрить</Link>
                            </CustomButton>
                            <CustomButton variant="red">
                                <Link :href="route('post.delete', post.id)" method="delete">Отклонить</Link>
                            </CustomButton>
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
            <div class="postTotal">
                <div class="customWindow__line"></div>
                <h3>Всего постов на модерации - {{ posts.total }}</h3>
            </div>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

.posts
    &__post
        padding: 0
        border: outset
        margin-bottom: 2rem
        h3
            font-size: 1.5rem
        p
            font-size: 1.3rem
    &__section
        display: flex
        flex-direction: row
        justify-content: space-between
        align-items: center
        color: Snow
        background-color: #3a3a3a
        height: 3rem
        padding: 0 .5rem
        border-bottom: .2rem outset LightGrey
    &__main
        padding: 1rem

.userInfo
    margin: 1rem 0
    display: flex
    justify-content: space-between
    align-items: center
    height: max-content

.postTotal
    text-align: center
    h3
        padding: 1rem 0 0 0
        font-size: 1.4rem

.action
    display: flex
    flex-direction: row
    justify-content: space-around

.ban
    color: red

.notBan
    color: green

</style>