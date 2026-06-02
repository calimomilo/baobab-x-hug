<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href : {type: String, default: ''},
    selected : {type: Boolean, default: false},
    type : {type: String, default: 'normal'}
})
</script>

<template>
    <Link :href="props.href" 
        class="px-3 py-2 rounded font-medium"
        :class="{'bg-brand-sage-100' : props.selected, 
            'text-brand-sage-950 hover:bg-white/60 active:bg-white/80' : props.type==='normal',
            'text-white bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100' : props.type==='highlight-pink'}">
        <slot />
        <!-- <hr v-if="props.selected" class="border-2 mx-1 rounded-full"> -->
    </Link>
</template>