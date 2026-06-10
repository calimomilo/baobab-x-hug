<script setup lang="ts">
const props = defineProps({
    color : {type: String, default: 'black'},
    class : {type: String, default: ''}
})

type colors = {
    [key: string]: string;
}

const colors: colors = {
    'completed': 'text-lime-800 border-lime-800 bg-lime-200',
    'soon': 'text-brand-teal-800 border-brand-teal-800 bg-brand-teal-200',
    'todo': 'text-brand-rose-600 border-brand-rose-600 bg-brand-rose-100',
}
</script>

<template>
    <div class="flex px-2 py-1 border rounded-full font-medium w-fit" :class="colors[props.color] + ' ' + props.class">
        <p>
            <slot />
        </p>
    </div>
</template>