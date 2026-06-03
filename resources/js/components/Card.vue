<script setup lang="ts">
import Badge from './Badge.vue';


const props = defineProps({
    title : {type: String, default: ''},
    badge : {type: String, default: null},
    background : {type: String, default: null},
    color : {type: String, default: 'black'}
})

const color = props.color;

type colors = {
    [key: string]: string;
}

const colors: colors = {
    'rose': 'text-brand-rose-400',
    'teal': 'text-brand-teal-600',
    'sage': 'text-brand-sage-600',
}
</script>

<template>
    <div class="flex flex-col justify-between items-start p-4 bg-white rounded w-[312px] h-[396px] font-medium"  :class="colors[color]">
        <div class="flex flex-col gap-2 items-start">
            <h3 class="text-[28px]/[130%]">{{ props.title }}</h3>
            <Badge :background="props.background" :color="props.color">{{ props.badge }}</Badge>
        </div>
        <p class="leading-[130%]">
            <slot />
        </p>
    </div>
</template>