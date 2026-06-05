<script setup lang="ts">
import LogoLoop from '@/components/bits/LogoLoop.vue';
import type { LogoItemImage } from '@/components/bits/LogoLoop.vue';

const props = defineProps({
    direction : {type: String, default: "right"}
})

const characters = <Array<LogoItemImage>>[
    { src: `/assets/mascottes/ClockBlueHexa.svg`, alt: `nom de la mascotte`, href: "" }
]
</script>

<template>
    <div class="bg-white py-20">
        <LogoLoop
            v-if="props.direction === 'right'"
            :logos="characters"
            :speed="30"
            :direction="'right'"
            :logoHeight="120"
            :gap="40"
            :pauseOnHover="false"
            :scaleOnHover="false"
            :fadeOut="true"
            fadeOutColor="#FFFFFF"
            ariaLabel="Mascottes de la Blood League"
            />
        <LogoLoop
            v-if="props.direction === 'left'"
            :logos="characters"
            :speed="30"
            :direction="'left'"
            :logoHeight="120"
            :gap="40"
            :pauseOnHover="false"
            :scaleOnHover="false"
            :fadeOut="true"
            fadeOutColor="#FFFFFF"
            ariaLabel="Mascottes de la Blood League"
            />
        </div>
</template>