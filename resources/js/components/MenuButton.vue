<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useCurrentUrl } from '@/composables/useCurrentUrl';

const props = defineProps({
    href : {type: String, default: ''},
    type : {type: String, default: 'normal'},
    display : {type: String, default: 'desktop'}
})

const { isCurrentUrl } = useCurrentUrl();

const type = ref(props.type);

type style = {
    [key: string]: {
        [key: string]: string;
    };
}

const style: style = {
    'normal' : {
        'base' : 'text-brand-sage-950 hover:bg-white/60 active:bg-white/80',
        'active' : 'text-brand-sage-950 bg-white/85 hover:bg-white/60 active:bg-white/80'
    },
    'highlight-pink' : {
        'base': 'text-white font-semibold bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100',
        'active' : 'text-white font-semibold bg-brand-rose-300 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100'
    }
}
</script>

<template>
    <Link v-if="props.display==='desktop'" :href="props.href" 
        class="flex items-center px-3 h-11 rounded font-medium"
        :class="style[type][isCurrentUrl(props.href)? 'active': 'base']">
        <slot />
    </Link>
    <Link v-if="props.display==='mobile'" :href="props.href"
        class="w-full flex justify-start items-center h-11 rounded px-3"
        :class="{'bg-brand-sage-100 font-semibold' : isCurrentUrl(props.href),
            'font-medium text-sm' : props.type==='normal',
            'text-white font-semibold text-base bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100 mt-3' : props.type==='highlight-pink'}">
        <slot />
    </Link>

    <!-- <Link v-if="props.display==='desktop'" :href="props.href"
        class="flex items-center px-3 h-11 rounded font-medium"
        :class="{'text-brand-pink-950 hover:text-brand-rose-400 active:text-brand-rose-500' : props.type==='normal',
            'text-white font-semibold bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100' : props.type==='highlight-pink',
            'text-brand-rose-400 font-semibold' : isCurrentUrl(props.href),}">
        <div>
            <slot />
            <hr v-if="isCurrentUrl(props.href)" class="border border-brand-rose-400 mx-1 rounded-full">
        </div>
    </Link>
    <Link v-if="props.display==='mobile'" :href="props.href"
        class="w-full flex justify-start items-center h-11 rounded px-3"
        :class="{'font-medium text-sm' : props.type==='normal',
            'text-white font-semibold text-base bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100 mt-3' : props.type==='highlight-pink',
            'text-brand-rose-400 font-semibold' : isCurrentUrl(props.href),}">
        <div>
            <slot />
            <hr v-if="isCurrentUrl(props.href)" class="border border-brand-rose-400 mx-1 rounded-full">
        </div>
    </Link> -->
</template>