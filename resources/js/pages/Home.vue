<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Accueil" desc="Bienvenue sur le site de la Blood League par les HUG" active="home">
        <section id="hero" class="relative h-[calc(100vh-76px)] flex flex-col justify-center items-center gap-20 md:gap-6">
            <h1 class="flex flex-col text-center text-2xl font-bold gap-2 items-center md:text-4xl md:gap-3 lg:text-[64px] lg:gap-6">
                <span class="-rotate-6 -translate-x-[calc(10vw)] md:-translate-x-[calc(20vw-100px)] lg:-translate-x-[calc(20vw-150px)]">Mobilisez votre équipe.</span>
                <span class="rotate-4 translate-x-[calc(10vw+15px)] lg:translate-x-[calc(25vw-80px)] lg:translate-y-2">Sauvez des vies.</span>
                <span>Rejoignez la Blood League.</span>
            </h1>
            <h2 class="hidden text-center font-medium uppercase tracking-[8%] max-w-[40%] md:block ">Blood League transforme les collectes de sang en entreprise en une compétition positive.</h2>
            <Link href="/contact" class="md:absolute md:bottom-[20%] md:right-[calc(20vw-80px)] lg:bottom-[8%]">
                <img src="../../assets/Round_Button.svg" alt="Bouton noir rond avec le texte Organiser une collecte" class="w-40 h-40 lg:w-50 lg:h-50">
            </Link>
        </section>
    </AppLayout>
</template>