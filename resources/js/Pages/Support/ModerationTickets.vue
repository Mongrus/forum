<script setup>
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import Smile from '@/Components/bloc/Smile.vue';
import CustomButton from '@/Components/CustomButton.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const {tickets} = defineProps({
    tickets: Object
})

const openTicketId = ref(null);

const forms = {}

tickets.data.forEach(ticket => {
    forms[ticket.id] = useForm({
        answer: ''
    })
})

function formatLabel(label) {
    if (label === '&laquo; Previous') return 'Назад'
    if (label === 'Next &raquo;') return 'Далее'
    return label
}

function submit(ticket) {
    forms[ticket.id].patch(
        route('support.completed', ticket.id)
    )
}
</script>

<template>
    <Head title="Обработка обращений в поддержку"/>
    <BaseLayout>
        <BaseWindow theme="black">
            <template #title>
                <b>Обращения в поддержку (административная страница)</b>
            </template>
            <div v-if="tickets.total">
                <div v-for="ticket in tickets.data">
                    <div class="supportMessage win98">
                        <h3><b>Тема:</b> {{ ticket.title }}</h3>
                        <div class="customWindow__line"></div>
                        <h3><b>Сообщения:</b> {{ ticket.message }}</h3>
                        <div class="customWindow__line"></div>
                        <div class="supportMessage__info">
                            <h3><b>Пользователь:</b> <Link :href="route('profile', ticket.user.id)"><b>{{ticket.user.name}}</b></Link></h3>
                            <h3><b>От:</b> {{ new Date(ticket.created_at).toLocaleDateString() }}</h3>
                        </div>
                        <CustomButton variant="dark">
                            <button  @click="openTicketId === ticket.id ? openTicketId = null : openTicketId = ticket.id">
                                {{ openTicketId === ticket.id ? 'Скрыть ответ' : 'Ответить' }}
                            </button>
                        </CustomButton>
                    </div>

                    <div v-if="openTicketId === ticket.id">
                        <div class="customWindow__line"></div>
                        <form @submit.prevent="submit(ticket)" class="form">
                            <div class="form__field">
                                <div>
                                    <textarea type="text" v-model="forms[ticket.id].answer"></textarea>
                                </div>
                                <Smile v-model="forms[ticket.id].answer"/>
                            </div>
                            <div class="error" v-if="forms[ticket.id].errors.answer">
                                <p>{{ forms[ticket.id].errors.answer }}</p>
                            </div>
                            <CustomButton variant="blue">
                                <button type="submit">Отправить</button>
                            </CustomButton>
                        </form>
                    </div>
                </div>
                <div class="pagination">
                    <button
                        v-for="link in tickets.links"
                        :key="link.label"
                        class="pagination__btn"
                        :class="{ 'is-active': link.active }"
                        :disabled="!link.url"
                        @click="$inertia.visit(link.url)"
                    >
                    {{ formatLabel(link.label) }}
                    </button>
                </div>
                <div class="ticketsInfo">
                    <div class="customWindow__line"></div>
                    <h2>Всего обращений в поддержку - {{ tickets.total }}</h2>
                </div>
            </div>
            <div v-else class="supportMessageNull">
                <h3>Пока список обращений пуст</h3>
            </div>
        </BaseWindow>
        
    </BaseLayout>
</template>

<style lang="sass" scoped>

.supportMessage
    font-size: 1.4rem
    margin-bottom: 1rem
    a
        color: Indigo
    &__info
        display: flex
        justify-content: space-between

.form
    display: flex
    flex-direction: column
    justify-content: center
    padding: 2rem 5rem
    margin: 0 4rem
    font-size: 1.2rem
    textarea
        width: 70rem
        height: 20rem
        font-size: 1.2rem
    button
        margin-top: 1rem
    &__field
        display: flex
        flex-direction: row

.supportMessageNull
    font-size: 1.3rem

.error
    color: red

.ticketsInfo
    h2
        text-align: center
        font-size: 1.3rem

</style>