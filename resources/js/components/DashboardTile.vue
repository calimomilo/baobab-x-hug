<script setup lang="ts">

const props = defineProps({
    title : {type: String, default: ''},
    color : {type: String, default: 'black'},
    size : {type: String, default: ''},
    class: {type: String, default: ''}
})

type strings = {
    [key: string]: string;
}

const colors: strings = {
    'rose': 'text-brand-rose-900 bg-brand-rose-100',
    'teal': 'text-brand-teal-900 bg-brand-teal-200',
    'sage': 'text-brand-sage-900 bg-brand-sage-200',
    'violet': 'text-brand-violet-900 bg-brand-violet-200',
    'indigo': 'text-brand-indigo-900 bg-brand-indigo-200'
}

const sizes: strings = {
    '3': 'col-span-3',
    '4': 'col-span-4',
    '6': 'col-span-6',
    '12': 'col-span-12',
}
</script>

<template>
    <div class="flex flex-col justify-center items-center rounded-lg min-h-40 px-6 py-10 gap-1 text-xl text-center font-medium" :class="colors[props.color] + ' ' + sizes[props.size] + ' ' + props.class">
        <slot />
    </div>
</template>