<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import LogoLoop from '@/components/bits/LogoLoop.vue';
import type { LogoItemImage } from '@/components/bits/LogoLoop.vue';
import Card from '@/components/Card.vue';
import Button from '@/components/ui/button/Button.vue';
import {
    Carousel,
    CarouselContent,
    CarouselItem
} from '@/components/ui/carousel';
import AppLayout from '@/layouts/AppLayout.vue';

type company = {
    id: number,
    company_name: string,
    logo_url: string,
    label: {
        name: string,
        slug: string,
    }
}
const props = defineProps({
    companies: Array<company>
})

const companiesList = <Array<LogoItemImage>>[];

props.companies?.forEach(company => {
    companiesList.push({ src: `${company.logo_url}`, alt: `${company.company_name}`, href: "" })
})

// const isLg = window.innerWidth >= 1024;
</script>

<template>
        <!-- FIRST SCREEN : HERO -->

    <AppLayout title="Accueil" desc="Bienvenue sur le site de la Blood League par les HUG" active="home">
        <section id="hero" class="relative min-h-[calc(100vh-76px)] flex flex-col justify-center items-center gap-20 md:gap-6">
            <h1 class="flex flex-col text-center text-2xl font-bold gap-2 items-center md:text-4xl md:gap-3 lg:text-[64px] lg:gap-6">
                <span class="-rotate-6 -translate-x-[calc(10vw)] md:-translate-x-[calc(20vw-100px)] lg:-translate-x-[calc(20vw-150px)]">Mobilisez votre équipe.</span>
                <span class="rotate-4 translate-x-[calc(10vw+15px)] lg:translate-x-[calc(25vw-80px)] lg:translate-y-2">Sauvez des vies.</span>
                <span>Rejoignez la Blood League.</span>
            </h1>
            <p class="hidden text-center font-medium uppercase tracking-[8%] max-w-[40%] md:block ">Blood League transforme les collectes de sang en entreprise en une compétition positive.</p>
            <Link href="/contact" class="md:absolute md:bottom-[20%] md:right-[calc(20vw-80px)] lg:bottom-[15%]">
                <img src="../../assets/round_button_organize.svg" alt="Bouton noir rond avec le texte Organiser une collecte" class="w-40 h-40 rotate-3 lg:w-50 lg:h-50 hover:scale-110 hover:rotate-30 transition duration-150 ease-in-out"> <!-- figure out how to make pink -->
            </Link>
            <div>
                <img src="../../assets/mascottes/KneelBlueFlower.svg" alt="" class="absolute h-[calc(8vw+30px)] top-[14vh] left-[6vw] md:top-[20vh] md:left-[6vw] lg:top-[15vh] lg:left-[6vw]">
                <img src="../../assets/mascottes/PlantPinkTri.svg" alt="" class="absolute h-[calc(8vw+30px)] top-[8vh] left-[44vw] md:top-[12vh] md:left-[44vw] lg:top-[6vh] lg:left-[44vw]">
                <img src="../../assets/mascottes/EgiptGreenTri.svg" alt="" class="absolute h-[calc(8vw+30px)] top-[18vh] left-[80vw] md:top-[24vh] md:left-[78vw] lg:top-[12vh] lg:left-[80vw]">
                <img src="../../assets/mascottes/PeacePinkTri.svg" alt="" class="absolute h-[calc(8vw+30px)] top-[38vh] left-[10vw] md:top-[50vh] md:left-[14vw] lg:top-[44vh] lg:left-[10vw]">
                <img src="../../assets/mascottes/ClockBlueHexa.svg" alt="" class="absolute h-[calc(8vw+30px)] top-[42vh] left-[76vw] md:top-[44vh] md:left-[88vw] lg:top-[32vh] lg:left-[90vw]">
                <img src="../../assets/mascottes/HiGreenStar.svg" alt="" class="absolute h-[calc(8vw+30px)] top-[34vh] left-[38vw] md:top-[33vh] md:left-[32vw] lg:top-[33vh] lg:left-[36vw]">
                <img src="../../assets/mascottes/LoveBlueCerf.svg" alt="" class="absolute h-[calc(8vw+30px)] top-[72vh] left-[48vw] md:top-[62vh] md:left-[35vw] lg:top-[64vh] lg:left-[35vw]">
                <img src="../../assets/mascottes/NinjaPinkNona.svg" alt="" class="absolute h-[calc(8vw+30px)] top-[62vh] left-[80vw] md:top-[72vh] md:left-[60vw] lg:top-[72vh] lg:left-[62vw]">
                <img src="../../assets/mascottes/RunGreenFlower.svg" alt="" class="absolute h-[calc(8vw+30px)] top-[64vh] left-[13vw] md:top-[68vh] md:left-[8vw] lg:top-[68vh] lg:left-[15vw]">
            </div>
        </section>

        <!-- SECOND SCREEN : INFOS BLOOD LEAGUE -->

        <section id="blood-league" class="relative min-h-[calc(100vh-76px)] flex flex-col justify-start items-start pt-16 bg-brand-rose-300 lg:px-40">
            <div class="flex flex-col px-4 text-white gap-4 lg:flex-row">
                <h2 class="text-[38px]/[130%] font-semibold lg:w-[40vw] lg:shrink">La Blood League, c'est quoi ?</h2>
                <div class="lg:shrink-2">
                    <p class="font-medium mb-4">La Blood League, c'est à la fois un championnat entre entreprises, un label RSE reconnu et une cérémonie annuelle de remise de prix. En organisant une collecte de sang pour vos employés, vous entrez dans la ligue, accumulez des points et concourez pour des médailles tout en contribuant concrètement à la santé publique genevoise.</p>
                    <Link href="/blood-league">
                        <Button class="bg-white hover:bg-brand-neutral-100 active:bg-brand-neutral-200 text-brand-rose-300 font-semibold">En savoir plus</Button>
                    </Link>
                </div>
            </div>

            <img src="../../assets/mascottes/LightGreenTri.svg" alt="" class="hidden lg:block absolute h-[calc(15vw+150px)] top-40 left-6">
            
            <Carousel class="w-full pt-8 pb-10 my-auto lg:w-auto lg:mx-auto" :opts="{
                loop: true,
                // draggable: isLg
                }">
                <CarouselContent class="">
                    <CarouselItem class="basis-[328px]">
                        <Link href="/blood-league">
                            <Card title="The Blood League" badge="Championnat" color="rose">
                                Une ligue de don du sang en entreprise. Les entreprises organisent des collectes pour leurs employés et accumulent des points tout au long de l'année selon leur efficacité et leur mobilisation. Plus une entreprise prépare bien ses employés en amont, plus son score est élevé.
                            </Card>
                        </Link>
                    </CarouselItem>
                    <CarouselItem class="basis-[328px]">
                        <Link href="/blood-league">
                            <Card title="The Blood League Label" badge="Label RSE" color="teal">
                                Chaque entreprise engagée repart avec une reconnaissance concrète. En fin de saison, toutes les entreprises participantes reçoivent un label officiel à afficher sur leur site, dans leur rapport RSE ou sur LinkedIn.
                            </Card>
                        </Link>
                    </CarouselItem>
                    <CarouselItem class="basis-[328px]">
                        <Link href="/blood-league#awards">
                            <Card title="The Blood League Awards" badge="Cérémonie" color="sage">
                                Chaque saison, les meilleures entreprises de la Blood League sont récompensées. Lors de la cérémonie annuelle des Blood League Awards, cinq médailles sont décernées pour saluer la progression, la participation, la fidélité et le renouveau célébrant toutes les formes d'excellence, quelle que soit la taille de l'entreprise.
                            </Card>
                        </Link>
                    </CarouselItem>
                </CarouselContent>
            </Carousel>
        </section>
        
        <!-- THIRD SCREEN : ENTREPRISES LABELLISEES -->

        <section id="companies" class="bg-brand-teal-500 pt-16 pb-8 flex flex-col items-center text-white">
            <h2 class="text-[38px]/[130%] font-semibold px-4 mb-4 lg:textcenter">Les entreprises labellisées</h2>
            <Link href="/leaderboard">
                <Button class="bg-white hover:bg-brand-neutral-100 active:bg-brand-neutral-200 text-brand-teal-500 font-semibold">Voir le leaderboard</Button>
            </Link>
            <div class="w-full flex flex-col min-h-60 justify-center overflow-hidden">
                <LogoLoop
                    :logos="companiesList"
                    :speed="60"
                    direction="left"
                    :logoHeight="48"
                    :gap="60"
                    :pauseOnHover="true"
                    :scaleOnHover="true"
                    :fadeOut="true"
                    fadeOutColor="#00B8B1"
                    ariaLabel="Entreprises labellisées"
                    />
                </div>
            <!-- <Carousel class="w-full pt-8 pb-10 my-auto" :opts="{
                loop: true,
                // draggable: isLg
                }">
                <CarouselContent class="">
                    <CarouselItem v-for="company in props.companies" :key="company.id" class="basis-[328px] pb-6 pr-2">
                        <CompanyCard :company="company"></CompanyCard>
                    </CarouselItem>
                </CarouselContent>
            </Carousel> -->
        </section>

        <!-- FOURTH SCREEN : CONTACT -->

        <section id="contact" class="relative min-h-[calc(100vh-76px)] flex flex-col justify-start items-center pt-16 bg-brand-rose-400 lg:px-40 text-white">
            <h2 class="text-[38px]/[130%] font-semibold px-4 mb-4 lg:w-[40vw] lg:hidden">Organiser une collecte</h2>
            <img src="../../assets/cts-appel-don-du-sang.jpg" alt="" class="w-9/10 h-[50vh] rounded-lg object-cover lg:h-[70vh]">
            <Link href="/contact" class="absolute bottom-[10%] lg:bottom-[40%] lg:right-[8%]">
                <img src="../../assets/round_button_lance.svg" alt="Bouton noir rond avec le texte Organiser une collecte" class="w-40 h-40 rotate-3 lg:w-50 lg:h-50 hover:scale-110 hover:rotate-30 transition duration-150 ease-in-out"> <!-- figure out how to make pink -->
            </Link>
            <div class="hidden lg:block absolute px-4 py-2 bottom-[8%] w-[60vw] text-center bg-brand-rose-400 rounded-lg">
                <h2 class="text-[38px]/[130%] font-semibold px-4 mb-4">Organiser une collecte</h2>
                <p class="text-center font-medium uppercase tracking-[8%]">Vous avez un espace disponible et des employés motivés ? Le CTS s'occupe du reste. Matériel, personnel médical, créneaux, tout est pris en charge. Vous diffusez le lien, vos employés s'inscrivent.</p>
            </div>
        </section>

        <!-- FIFTH SCREEN : INFOS DON -->

        <section id="don" class="relative bg-brand-sage-400 py-16 flex flex-col items-center gap-8 lg:px-60">
            <img src="../../assets/mascottes/YeahPinkFlam.svg" alt="" class="md:relative right-[25vw] md:-mt-4 md:-mb-15 lg:absolute lg:h-[80%] lg:top-[15%] lg:-left-20">
            <img src="../../assets/mascottes/ScreamBlueNona.svg" alt="" class="scale-x-[-1] hidden lg:block lg:absolute lg:h-[80%] lg:top-[15%] lg:-right-15">
            <h2 class="text-[38px]/[130%] font-semibold px-4 ">Pourquoi donner ?</h2>
            <p class="text-center font-medium uppercase tracking-[8%] mx-12">Vous vous demandez quel est l'impact réel du don du sang, ou quelles sont les conditions pour pouvoir donner ? Découvrez plus d'informations sur le don du sang.</p>
            <Link href="/don-du-sang">
                <Button class="bg-white hover:bg-brand-neutral-100 active:bg-brand-neutral-200 text-brand-sage-500 font-semibold">En savoir plus</Button>
            </Link>
            <img src="../../assets/mascottes/ScreamBlueNona.svg" alt="" class="scale-x-[-1] mt-4 md:relative left-[25vw] md:-mb-6 md:-mt-15 lg:hidden">
        </section>
    </AppLayout>
</template>