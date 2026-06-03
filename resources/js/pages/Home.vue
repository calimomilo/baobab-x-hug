<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Card from '@/components/Card.vue';
import Button from '@/components/ui/button/Button.vue';
import {
    Carousel,
    CarouselContent,
    CarouselItem
} from '@/components/ui/carousel';
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
            <p class="hidden text-center font-medium uppercase tracking-[8%] max-w-[40%] md:block ">Blood League transforme les collectes de sang en entreprise en une compétition positive.</p>
            <Link href="/contact" class="md:absolute md:bottom-[20%] md:right-[calc(20vw-80px)] lg:bottom-[8%]">
                <img src="../../assets/round_button_organize.svg" alt="Bouton noir rond avec le texte Organiser une collecte" class="w-40 h-40 rotate-3 lg:w-50 lg:h-50 hover:scale-110 hover:rotate-30 transition duration-150 ease-in-out"> <!-- figure out how to make pink -->
            </Link>
        </section>
        <section id="blood-league" class="relative min-h-[calc(100vh-76px)] flex flex-col justify-start items-start pt-10 bg-brand-rose-300">
            <div class="flex flex-col px-4 text-white gap-4 ">
                <h2 class="text-[38px]/[130%] font-semibold">La Blood League, c'est quoi ?</h2>
                <p class="font-medium">CE TEXTE VA ENCORE CHANGER Rejoindre Blood League c'est simple. Vous prenez contact avec le CTS, on crée votre page co-brandée aux couleurs de votre entreprise, et vous recevez un kit de communication clé en main pour mobiliser vos employés. Aucun visuel à créer, aucune logistique à gérer seul.</p>
                <Link href="/blood-league">
                    <Button></Button>
                </Link>
            </div>
            
            <Carousel class="w-full pt-8 pb-10 my-auto" :opts="{loop: true}">
                <CarouselContent class="">
                    <CarouselItem class="basis-[328px]">
                        <Card title="The Blood League" badge="Championnat" background="white" color="rose">
                            Une ligue de don du sang en entreprise. Les entreprises organisent des collectes pour leurs employés et accumulent des points tout au long de l'année selon leur efficacité et leur mobilisation. Plus une entreprise prépare bien ses employés en amont, plus son score est élevé.
                        </Card>
                    </CarouselItem>
                    <CarouselItem class="basis-[328px]">
                        <Card title="The Blood League Label" badge="Label RSE" background="white" color="teal">
                            Chaque entreprise engagée reparte avec une reconnaissance concrète. En fin de saison, toutes les entreprises participantes reçoivent un label officiel à afficher sur leur site, dans leur rapport RSE ou sur LinkedIn.
                        </Card>
                    </CarouselItem>
                    <CarouselItem class="basis-[328px]">
                        <Card title="The Blood League Awards" badge="Cérémonie" background="white" color="sage">
                            Une ligue de don du sang en entreprise. Les entreprises organisent des collectes pour leurs employés et accumulent des points tout au long de l'année selon leur efficacité et leur mobilisation. Plus une entreprise prépare bien ses employés en amont, plus son score est élevé.
                        </Card>
                    </CarouselItem>
                </CarouselContent>
            </Carousel>
        </section>
    </AppLayout>
</template>