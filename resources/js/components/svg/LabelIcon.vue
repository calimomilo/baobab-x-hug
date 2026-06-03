<script setup lang="ts">

const props = defineProps({
    label : {type: String, default: null},
})

</script>

<template>
    <img v-if="props.label === 'classic'" src="../../../assets/labels/LabelClassic.svg" alt="">
    <img v-if="props.label === 'gold'" src="../../../assets/labels/LabelGold.svg" alt="">
    <img v-if="props.label === 'legend'" src="../../../assets/labels/LabelLegend.svg" alt="">
</template>