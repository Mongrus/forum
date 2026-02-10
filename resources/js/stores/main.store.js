import { defineStore } from "pinia";

export const useMainStore = defineStore('layout', {
    state: () => ({
            layoutColor: localStorage.getItem('theme') ? localStorage.getItem('theme') : 'base'
    }),
    getters: {
        getTheme() {
            if (this.layoutColor === 'base') {
                return 'Бирюзовая'
            } else if (this.layoutColor === 'silver') {
                return 'Пепельный'
            } else if (this.layoutColor === 'purple') {
                return 'Индиго'
            } else if (this.layoutColor === 'green') {
                return 'Лесной'
            }
        }
    },
    actions: {
        setTheme(theme) {
            this.layoutColor = theme
            localStorage.setItem('theme', theme);
        },
    }
})
