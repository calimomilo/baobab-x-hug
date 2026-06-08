<script setup lang="ts">

const props = defineProps({
    title : {type: String, default: ''},
    color : {type: String, default: 'black'}
})

type colors = {
    [key: string]: string;
}

const colors: colors = {
    'rose': 'text-brand-rose-400 border-brand-rose-400',
}
</script>

<template>
    <div class="flex flex-col items-start p-6 rounded-lg border border-2 w-[312px] gap-4 font-medium"  :class="colors[props.color]">
        <h3 class="text-lg font-semibold md:text-xl">{{ props.title }}</h3>
        <p class="leading-[130%]">
            <slot />
        </p>
    </div>
</template>