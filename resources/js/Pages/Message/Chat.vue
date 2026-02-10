<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import BaseWindow from '@/Components/bloc/BaseWindow.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onBeforeUnmount, ref, nextTick, watch } from 'vue';
import { route } from 'ziggy-js';
import CustomButton from '@/Components/CustomButton.vue';
import Smile from '@/Components/bloc/Smile.vue';
import axios from 'axios';
import IsOnlineUser from '@/Components/IsOnlineUser.vue';
import PostLimitMessage from '@/Components/PostLimitMessage.vue';

const {messages, recipient} = defineProps({
    messages: Object,
    recipient: Object,
})

const user = computed(() => usePage().props.auth.user);

const form = useForm({
    message: '',
    recipient_id: recipient.id
});

function submit() {
    form.post(route('message.store'), {
        preserveScroll: true,
        onSuccess: () => {
            messagesLocal.value.push({
                message: form.message,
                sender_id: user.value.id,
                recipient_id: recipient.id,
                created_at: new Date()
            })
            scrollToBottom()
            form.message = ''
        }
    })
}

const messagesBox = ref(null)

async function scrollToBottom() {
    await nextTick()
    if (messagesBox.value) {
        messagesBox.value.scrollTop =
            messagesBox.value.scrollHeight
    }
}

// Пользователь печатает
const typingUsers = ref([]);

watch(() => form.isDirty, (isDirty) => {
    if (isDirty) {
        axios.post(route('message.typing'), {
            recipient_id: recipient.id
        })
    } else {
        axios.post(route('message.notTyping'), {
            recipient_id: recipient.id
        })
    }
})


// Для сообщений через WebSocket
const messagesLocal = ref([...messages])

const chatId = computed(() => {
    return user.value.id < recipient.id
        ? `${user.value.id}_${recipient.id}`
        : `${recipient.id}_${user.value.id}`
})

onMounted(() => {
    window.Echo
        .private(`chat.${chatId.value}`)
        .listen('.message.sent', (e) => {
            messagesLocal.value.push(e.message)
            scrollToBottom()
        })
    
    window.Echo
        .private(`chat.${chatId.value}`)
        .listen('.user.typing', (e) => {
            if (!typingUsers.value.includes(e.user_id)) {
                typingUsers.value.push(e.user_id)
            }
            scrollToBottom()
        })

    window.Echo
        .private(`chat.${chatId.value}`)
        .listen('.user.notTyping', (e) => {
            typingUsers.value = typingUsers.value.filter(
                id => id !== e.user_id
            )
        })
    
    scrollToBottom()
})

onBeforeUnmount(() => {
    window.Echo.leave(`chat.${chatId.value}`)
})

</script>


<template>
    <Head title="Чат с пользователем"/>
    <BaseLayout>
        <BaseWindow>
            <template #title>
                <b>Чат с пользователем {{ recipient.name }}</b> <IsOnlineUser :status="recipient.is_online"/>
            </template>
            <template #back>
                <Link :href="route('messages')">← Чаты</Link>
            </template>
            <div>
                <CustomButton v-if="messagesLocal.length" variant="red" class="deleteChat">
                    <Link :href="route('message.delete', recipient.id)" method="delete">Удалить чат</Link>
                </CustomButton>
            </div>
            <div>
                <div>
                    <ul class="messageContainer" ref="messagesBox">
                        <li v-if="messagesLocal.length" v-for="message in messagesLocal" class="messageContainer__message" :class="message.sender_id === user.id ? 'sender' : 'recipient'">
                            <div class="messageUserInfo">
                                <img class="chatAvatar" :src="`/${message.sender_id === user.id ? user.avatar : recipient.avatar}`" alt="avatar">
                                <Link :href="route('profile', message.sender_id)">
                                    {{ message.sender_id === user.id ? user.name : recipient.name}}
                                </Link>
                            </div>
                            <p>{{ message.message }}</p>
                            <p class="messageContainer__data">{{ new Date(message.created_at).toLocaleTimeString('ru-RU', {
                                hour: '2-digit',
                                minute: '2-digit'
                            })
                            }}</p>
                        </li>
                        <h3 class="notMessage" v-else>
                            У вас еще нет сообщений этому пользователю
                        </h3>
                        <p v-if="typingUsers.includes(recipient.id)" class="typing">
                                {{ recipient.name }} печатает
                                <span class="dot">.</span>
                                <span class="dot">.</span>
                                <span class="dot">.</span>
                        </p>
                    </ul>
                </div>
                <div class="customWindow__line"></div>
                <div>
                    <form class="form" @submit.prevent="submit">
                        <PostLimitMessage />
                        <div class="form__text">
                            <textarea type="text" v-model="form.message"></textarea>
                            <div v-if="form.errors.message">
                                <p>{{ form.errors.message }}</p>
                            </div>
                            <Smile v-model="form.message" />
                        </div>
                        <CustomButton variant="green">
                            <button type="submit">Отправить</button>
                        </CustomButton>
                    </form>
                </div>
            </div>
        </BaseWindow>
    </BaseLayout>
</template>

<style lang="sass" scoped>

p
    font-size: 1.5rem


.messageContainer
    display: flex
    flex-direction: column
    max-height: 30rem
    padding: 2rem
    overflow-y: auto
    &__message
        position: relative
        display: flex
        justify-content: center
        flex-direction: column
        align-items: center
        background-color: Snow
        border: 1px solid black
        min-width: 13rem
        padding: .5rem .5rem 2.5rem .5rem
        width: min-content
        max-width: 40rem
        width: max-content
        margin-bottom: 1rem
        a
            font-size: 1.5rem
            padding: 1rem .5rem
    &__data
        position: absolute
        right: 1rem
        bottom: .5rem
        font-size: 1.1rem
        color: gray

.messageUserInfo
    display: flex

.sender
    align-self: flex-end
    border-radius: 1.5rem 1.5rem 0rem 1.5rem
    a
        color: red

.recipient
    align-self: flex-start
    border-radius: 0rem 1.5rem 1.5rem 1.5rem
    a
        color: blue
    
.deleteChat
    position: absolute
    right: 1rem
    top: .4rem

.form
    display: flex
    flex-direction: column
    padding: 2rem
    textarea
        font-size: 1.4rem
        width: 70rem
        height: 20rem
    &__text
        display: flex
        justify-content: center
        margin-bottom: 2rem

.notMessage
    font-size: 1.3rem
    color: gray

.typing
    font-size: 1.3rem
    color: gray
    font-style: italic
    display: flex
    align-items: center
    gap: .2rem

.dot
    opacity: 0
    animation: blink 1.4s infinite both

.dot:nth-child(1)
    animation-delay: 0s

.dot:nth-child(2)
    animation-delay: .2s

.dot:nth-child(3)
    animation-delay: .4s

@keyframes blink
    0%
        opacity: 0
    20%
        opacity: 1
    100%
        opacity: 0


</style>