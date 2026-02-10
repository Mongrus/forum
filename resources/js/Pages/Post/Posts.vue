<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import postCreate from '../../../assets/img/message_tack.png';
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import CustomButton from '@/Components/CustomButton.vue';
import Smile from '@/Components/bloc/Smile.vue';

const {posts, sectionId, themeId} = defineProps({
    posts: Object,
    sectionId:  Number,
    themeId: Number
})

const form = useForm({
    title: '',
    description: '',
    section_id: sectionId,
    theme_id: themeId,
    custom_theme: null
})

function submit() {
    form.post(route('post.store'))
}

function formatLabel(label) {
    if (label === '&laquo; Previous') return 'Назад'
    if (label === 'Next &raquo;') return 'Далее'
    return label
}
</script>

<template>
    <Head title="Посты"/>
    <BaseLayout>
        <BaseWindow>
            <template #title>
                <b>Посты:</b>
            </template>
            <template #back>
                <Link :href="route('theme.index', sectionId)">← Назад</Link>
            </template>
            <div v-if="posts.total" class="posts__main">
                <div class="customWindow posts__post" v-for="el in posts.data" :key="el.id">
                    <div>
                        <h3>
                            <p>{{ el.title }}</p>
                            <Link :href="route('post.show', el.id)">Подробнее >>></Link>
                        </h3>
                        <h4>{{ el.description }}</h4>
                        <div class="customWindow__line"></div>
                        <div class="customWindow__author">
                            <Link class="posts__post__author" :href="route('profile', el.author.id)">Автор: {{ el.author.name }}</Link>
                            <p>{{ new Date(el.created_at).toLocaleDateString() }}</p>
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
            <div v-else class="postNull">
                <h3>Пока обсуждений по этой теме нет, вы можете стать первым и опубликовать новый пост в данной категории</h3>
            </div>
        </BaseWindow>
        
        <BaseWindow>
            <template #title>
                <b>Написать пост по этой теме:</b>
            </template>
            <div class="posts__create">
                    <form @submit.prevent="submit">
                        <label for="title"><b>Заголовок:</b></label>
                        <input type="text" v-model="form.title">
                        <div class="posts__create__errors" v-if="form.errors.title">
                            <p>{{ form.errors.title }}</p>
                        </div>
                        <label for="title"><b>Текст поста:</b></label>
                        <div class="posts__create__text">
                            <textarea type="text" v-model="form.description"></textarea>
                            <Smile v-model="form.description"/>
                        </div>
                        <div class="posts__create__errors" v-if="form.errors.description">
                            <p>{{ form.errors.description }}</p>
                        </div>
                        <CustomButton>
                            <button  type="submit" :disabled="form.processing">
                                <img :src="postCreate" alt="create_post">
                                <p>Опубликовать</p>
                            </button>
                        </CustomButton>
                    </form>
            </div>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

.posts
    &__main
        display: flex
        flex-direction: column
        align-items: center
        margin: 1rem 0
    &__post
        h3
            display: flex
            justify-content: space-between
            align-items: center
            padding: 0 1rem
        a
            &:active
                color: Snow
        width: 80vw
        &__author
            &:hover
                color: DarkBlue
    &__create
        form
            display: flex
            flex-direction: column
            padding: 0 3rem
            min-height: 30rem
            font-size: 1.3rem
            input
                font-size: 1.5rem
                width: 30rem
            textarea
                font-size: 1.5rem
                width: 80rem
                height: 20rem
            button
                width: 13rem
                margin: 1rem
        &__errors
            p
                color: red
        &__text
            display: flex
            flex-direction: row

.postNull
    font-size: 1.4rem

</style>