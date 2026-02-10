<script setup>
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import Smile from '@/Components/bloc/Smile.vue';
import CustomButton from '@/Components/CustomButton.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    message: ''
})

defineProps({
    tickets: Object
})

function submit() {
    form.post(route('support.store'));
}
</script>

<template>
    <Head title="Обращения в поддержку"/>
    <BaseLayout>
        <BaseWindow>
            <template #title>
                <b>Ваши обращения в поддержку</b>
            </template>
            <h3 class="description">
                На обработку обращений уходит от <span>2 часов</span> до <span>3 рабочих дней</span>.
                При написании обращения будьте внимательны: подробно опишите проблему и постарайтесь
                наиболее полно изложить то, с чем вы столкнулись — команда нашего форума обязательно
                постарается вам помочь.
            </h3>
            <div v-if="tickets.length" class="tickets">
                <div v-for="ticket in tickets" class="win98 ticket">
                    <div class="ticket__title">
                        <h3><b>№:</b> {{ ticket.id }}</h3>
                        <h2><b>Тема:</b> {{ ticket.title }}</h2>
                        <h3><b>От:</b> {{ new Date(ticket.created_at).toLocaleDateString() }}</h3>
                    </div>
                    <div class="customWindow__line"></div>
                    <h3 class="ticket__message"><b>Сообщения:</b> {{ ticket.message }}</h3>
                    <div class="customWindow__line"></div>
                    <div class="ticket__info">
                        <h3 class="ticket__status">
                            <b>Статус:</b> 
                            <span class="completed" v-if="ticket.completed"> обработано</span>
                            <span class="notCompleted" v-else="ticket.completed"> в обработке</span>
                        </h3>
                    </div>
                    <div v-if="ticket.answer" class="customWindow__line"></div>
                    <h3 class="ticket__answer" v-if="ticket.answer"><b>Ответ поддержки:</b> {{ ticket.answer }}</h3>
                </div>
                <div class="ticketsInfo">
                    <div class="customWindow__line"></div>
                    <h2>Всего обращений в поддержку - {{ tickets.length }}</h2>
                </div>
            </div>
            <div v-else>
                <h3>Вы пока не обращались в поддержку</h3>
            </div>
        </BaseWindow>

        <BaseWindow>
            <template #title>
                <b>Создать обращение</b>
            </template>
            <form class="form" @submit.prevent="submit">
                <div class="form__field">
                    <label for="title"><b>Тема обращения:</b></label>
                    <input type="text" v-model="form.title">
                    <div v-if="form.errors.title">
                        <p>{{ form.errors.title }}</p>
                    </div>
                </div>
                <div class="form__field">
                    <label for="message"><b>Суть проблемы:</b></label>
                    <div class="textAndSmile">
                        <textarea v-model="form.message"></textarea>
                        <Smile v-model="form.message"/>
                    </div>
                    <div class="error" v-if="form.errors.message">
                        <p>{{ form.errors.message }}</p>
                    </div>
                </div>
                <CustomButton>
                    <button type="submit">Отправить</button>
                </CustomButton>
            </form>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

h3
    font-size: 1.4rem

.description
    span
        color: blue

.tickets
    display: flex
    flex-direction: column

.ticket
    margin: 2rem
    padding: .03rem
    border: outset
    &__title
        background-color: DarkBlue
        padding: 0 1rem
        color: Snow
        display: flex
        flex-direction: row
        justify-content: space-between
        text-align: center
        h2
            font-size: 1.5rem
    &__message
        padding: 1rem
    &__info
        display: flex
        flex-direction: row
        justify-content: space-between
        margin: .5rem
    &__status
        padding: .5rem
    &__answer
        padding: 1rem

.form
    display: flex
    flex-direction: column
    justify-content: center
    padding: 2rem 5rem
    font-size: 1.2rem
    input
        width: 40rem
        font-size: 1.2rem
    textarea
        width: 80rem
        height: 20rem
        font-size: 1.2rem
    &__field
        display: flex
        flex-direction: column
        padding-bottom: 1rem

.textAndSmile
    display: flex

.completed
    border: .2rem solid green
    padding: .2rem
    color: green

.notCompleted
    border: .2rem solid crimson
    padding: .2rem
    color: Crimson

.error
    color: red

.ticketsInfo
    h2
        text-align: center
        font-size: 1.3rem

</style>