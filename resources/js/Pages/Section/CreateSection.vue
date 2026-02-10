<script setup>
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import CustomButton from '@/Components/CustomButton.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const form = useForm({
    title: null
});

function submit() {
    form.post(route('section.store'));
}
</script>

<template>
    <Head title="Создание раздела (административная страница)"/>
    <BaseLayout>
        <BaseWindow theme="black">
            <template #title>
                <b>Создание раздела (административная страница)</b>
            </template>
            <template #next>
                <Link :href="route('theme.create')">Создать тему →</Link>
            </template>
            <div class="description">
                <h3><b>На этой странице создаются новые разделы форума.</b></h3>
                <h4 class="win98">
                    <strong>Внимание:</strong> данная страница доступна исключительно для администрации сайта.
                    Если вы не относитесь к нашей команде, пожалуйста, покиньте её и сообщите о возможном сбое
                    <Link :href="route('support.index')"><b>по данной ссылке</b></Link>.
                </h4>
            </div>
            <form @submit.prevent="submit" class="form">
                <label><b>Название для раздела:</b></label>
                <input type="text" v-model="form.title">
                <div class="form__error" v-if="form.errors.title">
                    <p>{{ form.errors.title }}</p>
                </div>
                <CustomButton variant="dark">
                    <button type="submit">Создать раздел</button>
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
    input
        font-size: 1.3rem
        width: 25rem
    button
        margin-top: 2rem
    &__error
        font-size: 1.3rem
        color: red

</style>