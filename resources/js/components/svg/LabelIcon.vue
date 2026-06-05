<script setup lang="ts">

const props = defineProps({
    label : {type: String, default: null},
    class : {type: String, default: null}
})

</script>

<template>
    <img v-if="props.label === 'classic'" src="/assets/labels/LabelClassic.svg" alt="" :class="props.class">
    <img v-if="props.label === 'gold'" src="/assets/labels/LabelGold.svg" alt="" :class="props.class">
    <img v-if="props.label === 'legend'" src="/assets/labels/LabelLegend.svg" alt="" :class="props.class">
</template>