<script setup lang="ts">
import LogoLoop from '@/components/bits/LogoLoop.vue';
import type { LogoItemImage } from '@/components/bits/LogoLoop.vue';

const props = defineProps({
    direction: { type: String, default: 'right' },
});

const characters = <Array<LogoItemImage>>[
    { src: `/assets/mascottes/ClockBlueHexa.svg`, alt: `Mascotte en retard`, href: '' },
    { src: `/assets/mascottes/DanceGreenStar.svg`, alt: `Mascotte dance`, href: '' },
    { src: `/assets/mascottes/DrinkPinkFlower.svg`, alt: `Mascotte boit`, href: '' },
    { src: `/assets/mascottes/EgiptGreenTri.svg`, alt: `Mascotte dance`, href: '' },
    { src: `/assets/mascottes/HiGreenStar.svg`, alt: `Mascotte salue`, href: '' },
    { src: `/assets/mascottes/HiGreenTri.svg`, alt: `Mascotte salut`, href: '' },
    { src: `/assets/mascottes/KneelBlueFlower.svg`, alt: `Mascotte célèbre`, href: '' },
    { src: `/assets/mascottes/LightGreenTri.svg`, alt: `Mascotte à une idée`, href: '' },
    { src: `/assets/mascottes/LoveBlueCerf.svg`, alt: `Mascotte aime`, href: '' },
    { src: `/assets/mascottes/NinjaGreenFlam.svg`, alt: `Mascotte est ninja`, href: '' },
    { src: `/assets/mascottes/NinjaPinkNona.svg`, alt: `Mascotte est ninja`, href: '' },
    { src: `/assets/mascottes/PaintGreenCerf.svg`, alt: `Mascotte peint`, href: '' },
    { src: `/assets/mascottes/PaintPinkHexa.svg`, alt: `Mascotte peint`, href: '' },
    { src: `/assets/mascottes/PeacePinkTri.svg`, alt: `Mascotte signe V`, href: '' },
    { src: `/assets/mascottes/PlantPinkTri.svg`, alt: `Mascotte jardine`, href: '' },
    { src: `/assets/mascottes/RunBlueFlam.svg`, alt: `Mascotte court`, href: '' },
    { src: `/assets/mascottes/RunGreenFlower.svg`, alt: `Mascotte court`, href: '' },
    { src: `/assets/mascottes/RunPinkCerf.svg`, alt: `Mascotte court`, href: '' },
    { src: `/assets/mascottes/ScreamBlueNona.svg`, alt: `Moascotte crie`, href: '' },
    { src: `/assets/mascottes/ScreamBlueTri.svg`, alt: `Mascotte crie`, href: '' },
    { src: `/assets/mascottes/ShopGreenHexa.svg`, alt: `Mascotte fait du shopping`, href: '' },
    { src: `/assets/mascottes/VenusPinkStar.svg`, alt: `Mascotte est la Venus de botticelli`, href: '' },
    { src: `/assets/mascottes/WriteBlueStar.svg`, alt: `Mascotte écrit`, href: '' },
    { src: `/assets/mascottes/YeahPinkFlam.svg`, alt: `Mascotte supporte`, href: '' },
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
