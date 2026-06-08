<script setup lang="ts">

const props = defineProps({
    title : {type: String, default: ''},
    color : {type: String, default: 'black'},
    size : {type: String, default: ''}
})

type strings = {
    [key: string]: string;
}

const colors: strings = {
    'rose': 'text-brand-rose-900 bg-brand-rose-200',
    'teal': 'text-brand-teal-900 bg-brand-teal-200'
}

const sizes: strings = {
    '3': 'col-span-3',
    '4': 'col-span-4',
    '6': 'col-span-6',
    '12': 'col-span-12',
}
</script>

<template>
    <div class="flex flex-col justify-center items-center p-6 rounded-lg h-40 gap-4 text-xl font-medium" :class="colors[props.color] + ' ' + sizes[props.size]">
        <h3 class="text-3xl font-bold">{{ props.title }}</h3>
        <slot />
    </div>
</template>