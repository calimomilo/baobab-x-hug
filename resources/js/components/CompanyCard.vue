<script setup lang="ts">
import LabelIcon from './svg/LabelIcon.vue';



const props = defineProps({
    company : {type: Object, default: null},
})

</script>

<template>
    <div class="relative flex flex-col justify-between items-start p-4 bg-white rounded min-w-60 h-56 font-medium overflow-visible">
        <img :src="props.company.logo_url" :alt="`Logo de l'entreprise ${props.company.company_name}`" class="object-contain max-h-6/10 m-auto">
        <h4 class="text-[21px] font-medium text-black pr-14">{{ props.company.company_name }}</h4>
        <LabelIcon :label="props.company.label.slug" class="absolute -bottom-6 -right-2 rotate-8 w-20 z-2"></LabelIcon>
    </div>
</template>