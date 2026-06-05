<script setup lang="ts">

const props = defineProps({
    label : {type: String, default: null},
    class : {type: String, default: null}
})

</script>

<template>
    <img v-if="props.label === 'classic'" src="/assets/labels/LabelClassic.svg" alt="Blood League Label Classic" :class="props.class">
    <img v-if="props.label === 'gold'" src="/assets/labels/LabelGold.svg" alt="Blood League Label Gold" :class="props.class">
    <img v-if="props.label === 'legend'" src="/assets/labels/LabelLegend.svg" alt="Blood League Label Legend" :class="props.class">
</template>
