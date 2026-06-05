<script setup lang="ts">
const props = defineProps({
    award: { type: String, default: null },
    class: { type: String, default: null },
});
</script>

<template>
    <img
        v-if="props.award === 'climber'"
        src="/assets/awards/The_Climber.svg"
        alt="La médaille de la meilleure progression"
        :class="props.class"
    />
    <img
        v-if="props.award === 'flood'"
        src="/assets/awards/The_Flood.svg"
        alt="La médaille de la meilleure participation"
        :class="props.class"
    />
    <img
        v-if="props.award === 'golden_heart'"
        src="/assets/awards/The_Golden_Heart.svg"
        alt="La médaille du prix du jury"
        :class="props.class"
    />
    <img
        v-if="props.award === 'new_vein'"
        src="/assets/awards/The_New_Vein.svg"
        alt="La médaille de la meilleure nouvelle entreprise"
        :class="props.class"
    />
    <img
        v-if="props.award === 'pulse'"
        src="/assets/awards/The_Pulse.svg"
        alt="La médaille du meilleur soutien"
        :class="props.class"
    />
</template>
