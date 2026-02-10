<script setup>
import { useMainStore } from '@/stores/main.store';
import CustomButton from '../CustomButton.vue';
import { onBeforeUnmount, onMounted, ref } from 'vue';

const store = useMainStore();

const time = ref(new Date().toLocaleTimeString('ru-RU', {
	hour: '2-digit',
	minute: '2-digit',
	hour12: true
	}))

let timer = null

onMounted(() => {
  timer = setInterval(() => {
    time.value = new Date().toLocaleTimeString('ru-RU', {
	hour: '2-digit',
	minute: '2-digit',
	hour12: true
	})
  }, 1000)
})

onBeforeUnmount(() => {
  clearInterval(timer)
})

</script>

<template>
	<footer class="footer">
		<div class="colorMain win98footer">
			<b>Тема - {{ store.getTheme }}</b>
			<CustomButton variant="blue">
				<button @click="store.setTheme('base')"><b>1</b></button>
				<button @click="store.setTheme('silver')"><b>2</b></button>
				<button @click="store.setTheme('purple')"><b>3</b></button>
				<button @click="store.setTheme('green')"><b>4</b></button>
			</CustomButton>
		</div>
		<div class="myInfo">
			<div class="customLine"></div>
			<a href="https://github.com/Mongrus">© 2026 Mongrus™ — GitHub</a>
			<div class="customLine"></div>
		</div>
		<div class="time win98">
			<p>{{ time }}</p>
		</div>
	</footer>
</template>

<style lang="sass" scoped>

.myInfo
	display: flex
	align-items: center
	
.footer
	display: flex
	justify-content: space-between
	align-items: center
	align-items: center
	padding: 0 3rem
	background-color: Gainsboro
	border: .2rem outset gray
	min-height: 5rem
	text-align: center
	a
		font-size: 1.3rem
		&:hover
			text-decoration: underline
	p
		font-size: 1.4rem
		span
			animation: blink 1s infinite

.win98footer
	background: Gainsboro
	border-top: 2px solid #404040
	border-left: 2px solid #404040
	border-right: 2px solid #fff
	border-bottom: 2px solid #fff
	padding: 0 1rem

.colorMain
	button
		font-size: 1rem
		width: 2.3rem
		height: 2.3rem

.time
	display: flex
	align-items: center
	justify-content: center
	height: 4rem
	width: 12rem

@keyframes blink 
	0%   
		opacity: 1
	50%  
		opacity: 0
	100% 
		sopacity: 1


</style>