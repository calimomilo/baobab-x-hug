<script setup lang="ts">
import LogoLoop from '@/components/bits/LogoLoop.vue';
import type { LogoItemImage } from '@/components/bits/LogoLoop.vue';

const props = defineProps({
    direction: { type: String, default: 'right' },
});

const characters = <Array<LogoItemImage>>[
    { src: `/assets/mascottes/ClockBlueHexa.svg`, alt: `ClockBlueHexa`, href: '' },
    { src: `/assets/mascottes/DanceGreenStar.svg`, alt: `DanceGreenStar`, href: '' },
    { src: `/assets/mascottes/DrinkPinkFlower.svg`, alt: `DrinkPinkFlower`, href: '' },
    { src: `/assets/mascottes/EgiptGreenTri.svg`, alt: `EgiptGreenTri`, href: '' },
    { src: `/assets/mascottes/HiGreenStar.svg`, alt: `HiGreenStar`, href: '' },
    { src: `/assets/mascottes/HiGreenTri.svg`, alt: `HiGreenTri`, href: '' },
    { src: `/assets/mascottes/KneelBlueFlower.svg`, alt: `KneelBlueFlower`, href: '' },
    { src: `/assets/mascottes/LightGreenTri.svg`, alt: `LightGreenTri`, href: '' },
    { src: `/assets/mascottes/LoveBlueCerf.svg`, alt: `LoveBlueCerf`, href: '' },
    { src: `/assets/mascottes/NinjaGreenFlam.svg`, alt: `NinjaGreenFlam`, href: '' },
    { src: `/assets/mascottes/NinjaPinkNona.svg`, alt: `NinjaPinkNona`, href: '' },
    { src: `/assets/mascottes/PaintGreenCerf.svg`, alt: `PaintGreenCerf`, href: '' },
    { src: `/assets/mascottes/PaintPinkHexa.svg`, alt: `PaintPinkHexa`, href: '' },
    { src: `/assets/mascottes/PeacePinkTri.svg`, alt: `PeacePinkTri`, href: '' },
    { src: `/assets/mascottes/PlantPinkTri.svg`, alt: `PlantPinkTri`, href: '' },
    { src: `/assets/mascottes/RunBlueFlam.svg`, alt: `RunBlueFlam`, href: '' },
    { src: `/assets/mascottes/RunGreenFlower.svg`, alt: `RunGreenFlower`, href: '' },
    { src: `/assets/mascottes/RunPinkCerf.svg`, alt: `RunPinkCerf`, href: '' },
    { src: `/assets/mascottes/ScreamBlueNona.svg`, alt: `ScreamBlueNona`, href: '' },
    { src: `/assets/mascottes/ScreamBlueTri.svg`, alt: `ScreamBlueTri`, href: '' },
    { src: `/assets/mascottes/ShopGreenHexa.svg`, alt: `ShopGreenHexa`, href: '' },
    { src: `/assets/mascottes/VenusPinkStar.svg`, alt: `VenusPinkStar`, href: '' },
    { src: `/assets/mascottes/WriteBlueStar.svg`, alt: `WriteBlueStar`, href: '' },
    { src: `/assets/mascottes/YeahPinkFlam.svg`, alt: `YeahPinkFlam`, href: '' },
];
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
