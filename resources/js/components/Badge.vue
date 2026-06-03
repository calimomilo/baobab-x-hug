<script setup lang="ts">
const props = defineProps({
    background : {type: String, default: null},
    color : {type: String, default: 'black'}
    })
</script>

<template>
    <div :class="`flex px-4 py-2 ${props.background? 'bg-' + props.background : ''} border border-${props.color} rounded-full font-medium text-${props.color}`">
        <p>
            <slot />
        </p>
    </div>
</template>