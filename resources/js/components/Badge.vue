<script setup lang="ts">
const props = defineProps({
    color : {type: String, default: 'black'},
    class : {type: String, default: ''}
})

type colors = {
    [key: string]: string;
}

const colors: colors = {
    'rose': 'text-brand-rose-400 border-brand-rose-400 bg-white',
    'teal': 'text-brand-teal-600 border-brand-teal-600 bg-white',
    'sage': 'text-brand-sage-600 border-brand-sage-600 bg-white',
    'rose-selected': 'text-white border-white bg-rose-500 hover:cursor-pointer',
    'empty': 'text-white-border-white hover:cursor-pointer'
}
</script>

<template>
    <div class="flex px-4 py-2 border rounded-full font-medium" :class="colors[props.color] + ' ' + props.class">
        <p>
            <slot />
        </p>
    </div>
</template>