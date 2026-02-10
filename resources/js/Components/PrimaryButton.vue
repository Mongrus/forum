<template>
    <button
        class="inline-flex items-center rounded-md border border-transparent bg-gray-800 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
    >
        <slot />
    </button>
</template>

<style lang="sass" scoped>

button
    font-size: 1rem
    padding: .9rem 1.5rem

</style>