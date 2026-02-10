<script setup>
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import CustomButton from '@/Components/CustomButton.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const form = useForm({
    section_id: null,
    title: ''
})

defineProps({
    sections: Object
})

function submit() {
    form.post(route('theme.store'));
}
</script>

<template>
    <Head title="Создание темы (административная страница)"/>
    <BaseLayout>
        <BaseWindow theme="black">
            <template #title>
                <b>Создание темы (административная страница)</b>
            </template>
            <template #back>
                <Link :href="route('section.create')">← Создать раздел</Link>
            </template>
            <div class="description">
                <h3><b>На этой странице создаются новые темы в разделах для форума.</b></h3>
                <h4 class="win98">
                    <strong>Внимание:</strong> данная страница доступна исключительно для администрации сайта.
                    Если вы не относитесь к нашей команде, пожалуйста, покиньте её и сообщите о возможном сбое
                    <Link :href="route('support.index')"><b>по данной ссылке</b></Link>.
                </h4>
            </div>
            <form @submit.prevent="submit" class="form">
                <label><b>Раздел:</b></label>
                <select v-model.number="form.section_id">
                    <option disabled>Выберите</option>
                    <option v-for="section in sections" :value="section.id" :key="section.id">{{section.title}}</option>
                </select>
                <div class="form__error" v-if="form.errors.section_id">
                    <p>{{ form.errors.section_id }}</p>
                </div>
                <div class="form__elem">
                    <label for="custom_theme"><b>Тема:</b></label>
                    <input class="form__input" type="text" v-model="form.title">
                </div>
                <div class="form__error" v-if="form.errors.title">
                    <p>{{ form.errors.title }}</p>
                </div>
                <CustomButton variant="dark">
                    <button type="submit">Создать тему</button>
                </CustomButton>
            </form>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

.description
    h3
        font-size: 1.4rem 
    h4
        font-size: 1.4rem
        color: blue
    a
        text-decoration: underline
        color: indigo

.form
    display: flex
    flex-direction: column
    justify-content: center
    align-items: center
    padding: 3rem
    label
        font-size: 1.3rem
        margin-bottom: .3rem
        margin-top: 1rem
    input
        font-size: 1.3rem
        width: 25rem
    select
        font-size: 1.3rem
        width: 25rem
    button
        margin-top: 2rem
    &__elem
        display: flex
        flex-direction: column
        justify-content: center
        align-items: center
    &__error
        font-size: 1.3rem
        color: red

</style>