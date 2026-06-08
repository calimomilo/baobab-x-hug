<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import DashboardTile from '@/components/DashboardTile.vue';

type company = {
    id: number;
    company_name: string;
    logo_url: string;
    label: {
        name: string;
        slug: string;
    };
};

const props = defineProps({
    season: Object,
    companies: Array<company>
})

</script>

<template>
    <header class="flex py-4 px-4 justify-between items-center bg-brand-neutral-100 lg:px-6" >
        <Link href="/" class="flex gap-3 items-center">
            <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-11 lg:h-12">
            <span class="hidden lg:inline">✕</span>
            <img src="/assets/logos/logo_hug_h_gris.png" alt="Logo HUG" class="h-11 hidden lg:inline">
        </Link>
        <Link href="/auth/logout" method="post">Déconnexion</Link>
    </header>
    <section id="login" class="relative min-h-[calc(100vh-76px)] grid grid-cols-12 gap-6 font-medium py-16 px-40">
        <DashboardTile color="teal" size="12">
            <div class="flex justify-between">
                <div class="flex flex-col w-0 grow gap-2 justify-center items-center">
                    <h3 class="text-3xl font-bold">{{ props.season }}</h3>
                    <p class="text-xl">efficaticé</p>
                </div>
            </div>
        </DashboardTile>
    </section>
</template>