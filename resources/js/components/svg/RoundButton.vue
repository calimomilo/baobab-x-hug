<script setup lang="ts">

const props = defineProps({
    id : {type: String, default: 'id'},
    src : {type: String, default: null},
    alt : {type: String, default: ''},
    background : {type: String, default: '#000000'}
})

const svg = document.querySelector(`#${props.id}`);
svg?.setAttribute('fill', props.background);
</script>

<template>
    <img v-if="props.src" :id="props.id" :src="props.src" :alt="props.alt">
</template>