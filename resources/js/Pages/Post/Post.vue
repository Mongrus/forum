<script setup>
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import Smile from '@/Components/bloc/Smile.vue';
import CustomButton from '@/Components/CustomButton.vue';
import IsOnlineUser from '@/Components/IsOnlineUser.vue';
import UserInfo from '@/Components/UserInfo.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Link, useForm, usePage, Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import deleteComment from '../../../assets/img/recycle.png';


const updatePostBlock = ref(false);

const { post } = defineProps({
    post: Object
})

const user = computed(() => usePage().props.auth.user)

const form = useForm({
    comment: ''
})

const formPostUpdate = useForm({
    post_id: post.id,
    title: post.title,
    description: post.description 
})

function submit() {
    form.post(route('comment.store', post.id));
    form.comment = '';
}

function showBlockUpdatePost() {
    updatePostBlock.value = !updatePostBlock.value
}

function updatePost() {
    formPostUpdate.patch(route('post.update'));
}

</script>

<template>
    <Head title="Пост пользователя"></Head>
    <BaseLayout>
        <BaseWindow>
            <template #title>
                <b>{{ post.title }}</b>
            </template>
            <template #back>
                <Link :href="route('post.index', {section: post.section_id, themeId: post.theme_id})">← Все посты </Link>
            </template>
            <template #next>
                <Link :href="route('profile', post.author_id)">Профиль автора →</Link>
            </template>
            <div class="postInfo">
                <h3><b>Раздел:</b> {{ post.section.title }}</h3>
                <div class="customWindow__line"></div>
                <h3><b>Тема:</b> {{ post.theme.title }}</h3>
                <div class="customWindow__line"></div>
                <h3><b>Заголовок:</b> {{ post.title }}</h3>
                <div class="customWindow__line"></div>
                <h3><b>Текст поста:</b> {{ post.description }}</h3>
                <div class="customWindow__line"></div>
                <h3><b>Модерация:</b><span v-if="post.moderation"> пройдена </span></h3>
                <div class="customWindow__line"></div>
                <UserInfo :avatar="post.author.avatar" :online="post.author.is_online" :name="post.author.name" :date="post.created_at" />
                <div v-if="post.author.id === user?.id || user?.status === 'admin' || user?.status === 'moderator'" class="control">
                    <CustomButton variant="green">
                        <button @click="showBlockUpdatePost">Редактировать</button>
                    </CustomButton>
                    <CustomButton variant="red">
                        <Link :href="route('post.delete', post.id)" method="delete">Удалить пост</Link>
                    </CustomButton>
                </div>
            </div>
            <div v-if="updatePostBlock">
                <div class="customWindow__line"></div>
                <div class="updatePostBlock">
                    <form @submit.prevent="updatePost">
                        <div class="updatePostBlock__field">
                            <label><b>Заголовок:</b></label>
                            <input type="text" v-model="formPostUpdate.title">
                            <div class="error" v-if="formPostUpdate.errors.title">
                                <p>{{ formPostUpdate.errors.title }}</p>
                            </div>
                        </div>
                        <div class="updatePostBlock__field">
                            <label><b>Текст поста:</b></label>
                            <div class="textAndSmile">
                                <textarea v-model="formPostUpdate.description"></textarea>
                                <div class="error" v-if="formPostUpdate.errors.description">
                                    <p>{{ formPostUpdate.errors.description}}</p>
                                </div>
                                <Smile v-model="formPostUpdate.description"/>
                            </div>
                        </div>
                        <CustomButton>
                            <button type="submit">Отправить</button>
                        </CustomButton>
                    </form>
                </div>
            </div>
        </BaseWindow>

        <BaseWindow>
            <template #title>
                <b>Комментарии</b>
            </template>
            <div v-if="!post.comments.length">
                <h3>У этого поста пока нет комментариев</h3>
            </div>
            <ul v-else>
                <li v-for="comment in post.comments">
                    <div class="comment">
                        <div class="comment__user">
                            <img class="chatAvatar" :src="`/${comment.author.avatar}`" alt="avatar">
                            <Link :href="route('profile', comment.author.id)">{{ comment.author.name }}</Link>
                            <IsOnlineUser :status="comment.author.is_online"/>
                        </div>
                        <div class="comment__message">
                            <h3>
                                {{ comment.comment }}
                            </h3>
                        </div>
                        <div class="comment__actionAndTime">
                            <h3>{{ new Date(comment.created_at).toLocaleDateString() }}</h3>
                            <Link v-if="user.id === comment.author.id || (user.status === 'admin' || user.status === 'moderator')" :href="route('comment.delete', comment.id)" method="delete">
                                <img :src="deleteComment" alt="deleteComment">
                            </Link>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="customWindow__line"></div>
            <div>
                <form class="commentForm" v-if="user" @submit.prevent="submit">
                    <h3><b>Оставить комментарий:</b></h3>
                    <div class="textAndSmile">
                        <textarea v-model="form.comment"></textarea>
                        <div class="error" v-if="form.errors.comment">
                            <p>{{ form.errors.comment }}</p>
                        </div>
                        <Smile v-model="form.comment"/>
                    </div>
                    <CustomButton>
                        <button type="submit">Опубликовать</button>
                    </CustomButton>
                </form>
                <h3 v-else>
                    <Link :href="route('login')"><b>Войдите</b></Link>
                    или
                    <Link :href="route('register')"><b>зарегистрируйтесь</b></Link>
                    что бы оставлять комментарии!
                </h3>
            </div>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

.postInfo
    h3
        font-size: 1.5rem
        span
            color: green

    p
        font-size: 1.3rem

.error
    color: red

.control
    display: flex
    flex-direction: row
    justify-content: space-evenly
    padding-bottom: 1rem

.updatePostBlock
    display: flex
    flex-direction: row
    justify-content: center
    align-items: center
    padding: 2rem
    font-size: 1.2rem
    input
        width: 40rem
        font-size: 1.2rem
    textarea
        width: 40rem
        height: 20rem
        font-size: 1.2rem
    &__field
        display: flex
        flex-direction: column
        padding-bottom: 1rem

.textAndSmile
    display: flex

.comment
    display: flex
    justify-content: center
    flex-direction: column
    align-items: center
    background-color: Snow
    border: 1px solid black
    min-width: 30rem
    padding: 1rem
    max-width: 70rem
    width: max-content
    margin-bottom: 3rem
    align-self: flex-start
    border-radius: 0rem 1.5rem 1.5rem 1.5rem
    a
        color: blue
        font-size: 1.5rem
        padding-left: .5rem
    &__user
        display: flex
        justify-content: center
        align-items: center
    &__message
        font-size: 1.4rem
        padding: 1rem 0
    &__actionAndTime
        display: flex
        flex-direction: row
        justify-content: space-between
        align-items: center
        width: 100%
        h3
            font-size: 1.2rem
            color: gray
        img
            width: 3rem

.commentForm
    display: flex
    flex-direction: column
    justify-content: center
    align-items: center
    padding: 2rem 0
    h3
        font-size: 1.3rem
        margin-bottom: .5rem
    textarea
        font-size: 1.4rem
        width: 50rem
    button
        margin-top: 1.5rem

</style>