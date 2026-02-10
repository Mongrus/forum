<script setup>
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import postCreate from '../../../assets/img/message_tack.png';
import CustomButton from '@/Components/CustomButton.vue';
import Smile from '@/Components/bloc/Smile.vue';

const status = ref(0);
const customTheme = ref(false);
const user = computed(() => usePage().props.auth.user);

const {sections} = defineProps({
    sections: Object,
})

const form = useForm({
    section_id: null,
    theme_id: null,
    custom_theme: null,
    title: '',
    description: ''
})

function plusStage() {
    if(status.value < 2) {
        status.value++
    }
}

function backStage() {
    if(status.value > 0) {
        status.value--
    }
    if (status.value === 0) {
        form.theme_id = null
        form.custom_theme = null
    } else if (status.value === 1) {
        form.title = ''
        form.description = ''
    }
}

watch(customTheme, () => {
    if (customTheme.value) {
        form.theme_id = null
    } else {
        form.custom_theme = null
    }
})

function submit() {
    form.post(route('post.store'))
}
</script>

<template>
    <Head title="Создание нового поста"/>
    <BaseLayout>

        <BaseWindow>
            <template #title>
                <b>Итоговый пост:</b>
            </template>
            <div class="postInfo">
                <h3><b>Раздел:</b> {{ sections.find(s => s.id === form.section_id)?.title }}</h3>
                <div class="error" v-if="form.errors.section_id">
                    <p>{{ form.errors.section_id }}</p>
                </div>
                <div class="customWindow__line"></div>
                <div v-if="!customTheme">
                    <h3><b>Тема:</b> {{ sections.find(s => s.id === form.section_id)?.themes.find(t => t.id === form.theme_id)?.title }}</h3>
                    <div class="error" v-if="form.errors.theme_id">
                        <p>{{ form.errors.theme_id }}</p>
                    </div>
                </div>
                <div v-else>
                    <h3 ><b>Кастомная тема:</b> {{ form.custom_theme }}</h3>
                    <div class="error" v-if="form.errors.custom_theme">
                        <p>{{ form.errors.custom_theme }}</p>
                    </div>
                </div>
                <div class="customWindow__line"></div>
                <h3><b>Заголовок:</b> {{ form.title }}</h3>
                <div class="error" v-if="form.errors.title">
                    <p>{{ form.errors.title }}</p>
                </div>
                <div class="customWindow__line"></div>
                <h3><b>Текст поста:</b> {{ form.description }}</h3>
                <div class="error" v-if="form.errors.description">
                    <p>{{ form.errors.description }}</p>
                </div>
                <div class="customWindow__line"></div>
                <div class="userInfo win98">
                    <img class="miniAvatar" :src="`/${user.avatar}`" alt="avatar">
                    <h3>{{ user.name }}</h3>
                    <h3>{{ new Date().toLocaleDateString() }}</h3>
                </div>
            </div>
        </BaseWindow>

        <BaseWindow>
            <template #title>
                <b>Редактор:</b>
            </template>
            <form class="form" @submit.prevent="submit">
                <Transition v-if="status === 0" name="slide-fade">
                    <div class="form__elem">
                        <label for="section_id"><b>Раздел:</b></label>
                        <select v-model.number="form.section_id">
                            <option disabled>Выберите</option>
                            <option v-for="section in sections" :value="section.id" :key="section.id">{{section.title}}</option>
                        </select>
                    </div>
                </Transition>
                <Transition v-if="status === 1" name="slide-fade">
                    <div>
                        <h2><b>Своя тема:</b></h2>
                        <input class="form__check" type="checkbox" v-model="customTheme">
                        <div class="form__elem" v-if="!customTheme">
                            <label for="theme_id"><b>Тема:</b></label>
                            <select v-model="form.theme_id">
                                <option disabled>Выберите</option>
                                <option v-for="theme in sections.find(s => s.id === form.section_id)?.themes" :value="theme.id" :key="theme.id">{{theme.title}}</option>
                            </select>
                        </div>
                        <div class="form__elem" v-else>
                            <label for="custom_theme"><b>Тема:</b></label>
                            <input class="form__input" type="text" v-model="form.custom_theme">
                        </div>
                    </div>
                </Transition>
                <Transition v-if="status === 2" name="slide-fade">
                    <div class="form__elem">
                        <label for="title"><b>Заголовок:</b></label>
                        <input class="form__input" type="text" v-model="form.title">
                        <label for="description"><b>Текст:</b></label>
                        <div class="text">
                            <textarea v-model="form.description"></textarea>
                            <Smile v-model="form.description"/>
                        </div>
                    </div>
                </Transition>

                <CustomButton>
                    <button type="button" @click="backStage" :disabled="status === 0">Назад</button>
                    <button type="button" v-if="status < 2" @click="plusStage" :disabled="status === 2">Дальше</button>
                    <button v-if="status === 2" type="submit" >
                        <img :src="postCreate" alt="post_create">
                        <p>Отправить</p>
                    </button>
                </CustomButton>
            </form>
        </BaseWindow> 
        
    </BaseLayout>
</template>

<style lang="sass" scoped>

.form
    display: flex
    justify-content: space-between
    flex-direction: column
    padding: 0 3rem
    min-height: 20rem
    font-size: 1.3rem
    input
        font-size: 1.5rem
    textarea
        font-size: 1.5rem
        width: 80rem
        height: 20rem
    button
        width: 13rem
        margin: 1rem
    select
        font-size: 1.5rem
        width: 50rem
    &__input
        width: 50rem
    &__check
        width: 2rem
        height: 2rem
    &__elem
        display: flex
        flex-direction: column

.postInfo
    h3
        font-size: 1.5rem
    p
        font-size: 1.3rem

.text
    display: flex
    flex-direction: row
    textarea
        width: 75%

.userInfo
    margin: 3rem 0
    display: flex
    justify-content: space-between
    align-items: center
    height: max-content

.error
    color: red
// Анимация исчезновения
.slide-fade-enter-active,
.slide-fade-leave-active
  transition: opacity 0.5s ease

.slide-fade-enter-from,
.slide-fade-leave-to
  opacity: 0



</style>