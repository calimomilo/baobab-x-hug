<script setup lang="ts">
import LabelIcon from './svg/LabelIcon.vue';

const props = defineProps({
    title : {type: String, default: ''},
    label : {type: String, default: null},
})

type colors = {
    [key: string]: string;
}

const colors: colors = {
    'classic': 'bg-brand-sage-300',
    'gold': 'bg-brand-warning-300',
    'legend': 'bg-brand-violet-300',
}

</script>

<template>
    <div class="relative flex flex-col items-center bg-white rounded-lg w-[312px] h-[352px] font-medium overflow-clip shadow-lg">
        <div :class="`${colors[props.label]} h-10 w-full`"></div>
        <LabelIcon :label="props.label" class="h-28 mt-4"></LabelIcon>
        <h3 class="text-[24px] font-bold py-2 text-center">{{ props.title }}</h3>
        <p class="text-md text-center px-6 pb-8">
            <slot />
        </p>
    </div>
</template>