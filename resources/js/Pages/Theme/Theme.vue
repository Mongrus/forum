<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import postsImg from '../../../assets/img/web_file_set.png';
import BaseWindow from '@/Components/bloc/BaseWindow.vue';

defineProps({
    themes: Object
})

const click = new Audio('/sounds/click.mp3');

function soundPlay() {
    click.play();
}

function formatLabel(label) {
    if (label === '&laquo; Previous') return 'Назад'
    if (label === 'Next &raquo;') return 'Далее'
    return label
}
</script>

<template>
    <Head title="Темы"/>
    <BaseLayout>
        <BaseWindow>
            <template #title>
                <b>Темы:</b>
            </template>
            <template #back>
                <Link :href="route('section.index')">← Назад</Link>
            </template>
            <div v-if="themes.total">
                <div class="themes">
                    <div class="themes__theme" v-for="el in themes.data" :key="el.id">
                        <Link @click="soundPlay" :href="route('post.index', {section: el.section_id, themeId: el.id})">
                            <img :src="postsImg" alt="img_posts">
                            <div>
                                <p>Тема: {{ el.title }}</p>
                                <p>Создана: {{ new Date(el.created_at).toLocaleDateString() }}</p>
                                <p>Постов за все время: {{ el.posts.length }}</p>
                                <p>Последний созданный пост: {{ el.posts_max_created_at }}</p>
                            </div>
                        </Link>
                        <div class="customWindow__line"></div>
                    </div>
                </div>
                <div>
                <div class="pagination">
                    <button
                        v-for="link in themes.links"
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
                <div class="customWindow__line"></div>
                <div class="infoThemes">
                    <h2>Всего тем в этом разделе - {{ themes.total }}</h2>
                </div>
            </div>
            <div v-else class="notPosts">
                <h3>
                    В этой теме пока нет постов. Если вы хотите создать пост по данной теме, перейдите в раздел
                    <Link :href="route('post.create')"><b>«Создать»</b></Link>, выберите нужный раздел и тему,
                    после чего опубликуйте новый пост.
                </h3>
            </div>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

.themes
    display: flex
    flex-direction: column
    align-items: center
    min-height: 41rem
    &__theme
        width: 80%
        height: 10rem
        &:hover
            border: .1rem dashed gray
    a
        display: flex
        flex-direction: row
        align-items: center
        justify-content: flex-start
        font-size: 1.5rem
        &:active img, 
        &:active p
            background-color: DarkBlue
            color: white
    img
        width: 4rem
        height: 4rem
        margin-right: 2rem

.infoThemes
    h2
        text-align: center
        font-size: 1.3rem

.notPosts
    h3
        font-size: 1.4rem
    a
        color: Indigo
        text-decoration: underline

</style>