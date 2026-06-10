<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import LogoLoop from '@/components/bits/LogoLoop.vue';
import type { LogoItemImage } from '@/components/bits/LogoLoop.vue';
import Card from '@/components/Card.vue';
import CharacterLoop from '@/components/CharacterLoop.vue';
import BrandedMascot from '@/components/svg/BrandedMascot.vue';
import Button from '@/components/ui/button/Button.vue';
import {
    Carousel,
    CarouselContent,
    CarouselItem,
} from '@/components/ui/carousel';
import AppLayout from '@/layouts/AppLayout.vue';

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
    companies: Array<company>,
    displayData: Object || null,
    collect: Object || null
});

const companiesList = <Array<LogoItemImage>>[];

props.companies?.forEach((company) => {
    companiesList.push({
        src: `${company.logo_url}`,
        alt: `${company.company_name}`,
        href: '',
    });
});
console.log(props.collect);

// onMounted(() => {
//     setInterval(() => {
//         router.reload({only: ['collect.date_of']});
//     },499)
// })
</script>

<template>
    <!-- FIRST SCREEN : HERO -->

    <AppLayout title="Accueil" desc="Bienvenue sur le site de la Blood League par les HUG" :displayData="displayData">
        <section v-if="props.displayData" id="hero" class="relative min-h-[calc(100vh-76px)] flex flex-col px-8 py-15 gap-x-8 gap-y-8 lg:px-40 font-medium lg:text-lg">
            <div class="flex flex-col gap-8 md:flex-row-reverse md:items-start">
                <div class="flex flex-col gap-6 md:mt-6">
                    <h1 class="text-2xl font-bold md:text-4xl">L'équipe <span :style="`color: ${props.displayData.primary_color};`">{{ props.displayData.name }}</span> entre sur le terrain !</h1>
                    <p>{{ props.displayData?.name }} s'engage dans la Blood League aux côtés des entreprises genevoises qui font la différence. Vérifiez votre éligibilité en 2 minutes et faites marquer des points à votre équipe. Chaque don compte dans le classement Blood League.</p>
                </div>
                <BrandedMascot type="flag" :primary="props.displayData.primary_color" :secondary="props.displayData.secondary_color" class="mx-auto md:scale-[2] md:mr-14 md:ml-16 md:mt-20 lg:relative lg:mr-0 lg:right-16"></BrandedMascot>
            </div>
            <div v-if="props.collect">
                <h3 class="text-2xl font-bold md:text-3xl md:mt-6 md:ml-30 lg:ml-16">Prochaine collecte :</h3>
                <div class="flex flex-col gap-6 my-6 md:my-10">
                    <div class="flex gap-10">
                        <div class="flex flex-col justify-center gap-2 bg-brand-teal-300 text-brand-teal-900 rounded-lg px-6 py-8 py-auto w-full min-w-38 text-center lg:gap-4 lg:py-12">
                            <p class="text-xl font-semibold lg:text-3xl">{{ props.collect.date_of }}</p>
                            <p class="lg:text-xl">{{ props.collect.countdown }}</p>
                        </div>
                        <Link href="/checker" class="hidden grow md:inline-block lg:shrink-0">
                            <img src="/assets/round_button_verify.svg" alt="Bouton noir rond avec le texte Vérifier mon éligibilité" class="relative h-full w-full scale-130 rotate-3 transition duration-150 ease-in-out hover:scale-140 hover:rotate-30 md:right-1 md:bottom-2 lg:bottom-4 lg:left-2">
                        </Link>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex flex-col justify-center bg-brand-rose-200 text-brand-rose-900 rounded-lg px-6 py-8 py-auto w-full min-w-38 text-center lg:py-12">
                            <p class="text-xl font-semibold lg:text-3xl">{{ props.collect.start_time }}–{{ props.collect.end_time }}</p>
                        </div>
                        <div class="flex flex-col justify-center bg-brand-sage-300 text-brand-sage-900 rounded-lg px-6 py-8 py-auto w-full min-w-38 text-center lg:py-12">
                            <p class="text-xl font-semibold lg:text-3xl">{{ props.collect.location }}</p>
                        </div>
                    </div>
                    <Link href="/checker" class="md:hidden self-center mt-10">
                        <img src="/assets/round_button_verify.svg" alt="Bouton noir rond avec le texte Vérifier mon éligibilité" class="h-40 w-40 rotate-3 transition duration-150 ease-in-out hover:scale-110"/>
                        <!-- figure out how to make pink -->
                    </Link>
                </div>
            </div>
            <div v-else>
                <h3 class="text-xl font-semibold md:text-2xl">Aucune collecte prévue !</h3>
                <p class="mt-2"><Link href="/contact" class="underline text-brand-indigo-600 hover:text-brand-indigo-400 mt-2">Contactez-nous</Link> pour organiser une collecte.</p>
            </div>
        </section>
        <section v-else id="hero" class="relative min-h-[calc(100vh-76px)] flex flex-col justify-center items-center gap-20 md:gap-6">
            <h1 class="flex flex-col text-center text-2xl font-bold gap-2 items-center md:text-4xl md:gap-3 lg:text-[64px] lg:gap-6">
                <span class="-rotate-6 -translate-x-[calc(10vw)] md:-translate-x-[calc(20vw-100px)] lg:-translate-x-[calc(20vw-150px)">Mobilisez votre équipe.</span>
                <span class="rotate-4 translate-x-[calc(10vw+15px)] lg:translate-x-[calc(25vw-80px)] lg:translate-y-2">Sauvez des vies.</span>
                <span>Rejoignez la Blood League.</span>
            </h1>
            <p class="hidden max-w-[40%] text-center font-medium tracking-[8%] uppercase md:block">
                Blood League transforme les collectes de sang en entreprise en une compétition positive.
            </p>
            <Link href="/contact" class="md:absolute md:right-[calc(20vw-80px)] md:bottom-[20%] lg:bottom-[15%]">
                <img src="/assets/round_button_organize.svg" alt="Bouton noir rond avec le texte Organiser une collecte" class="h-40 w-40 rotate-3 transition duration-150 ease-in-out hover:scale-110 hover:rotate-30 lg:h-50 lg:w-50"/>
                <!-- figure out how to make pink -->
            </Link>
            <div>
                <img src="/assets/mascottes/KneelBlueFlower.svg" alt="Mascotte célèbre" class="absolute top-[14vh] left-[6vw] h-[calc(8vw+30px)] md:top-[20vh] md:left-[6vw] lg:top-[15vh] lg:left-[6vw]"/>
                <img src="/assets/mascottes/PlantPinkTri.svg" alt="Mascotte jardine" class="absolute top-[8vh] left-[44vw] h-[calc(8vw+30px)] md:top-[12vh] md:left-[44vw] lg:top-[6vh] lg:left-[44vw]"/>
                <img src="/assets/mascottes/EgiptGreenTri.svg" alt="Mascotte dance" class="absolute top-[18vh] left-[80vw] h-[calc(8vw+30px)] md:top-[24vh] md:left-[78vw] lg:top-[12vh] lg:left-[80vw]"/>
                <img src="/assets/mascottes/PeacePinkTri.svg" alt="Mascotte signe V" class="absolute top-[38vh] left-[10vw] h-[calc(8vw+30px)] md:top-[50vh] md:left-[14vw] lg:top-[44vh] lg:left-[10vw]"/>
                <img src="/assets/mascottes/ClockBlueHexa.svg" alt="Mascotte en retard" class="absolute top-[42vh] left-[76vw] h-[calc(8vw+30px)] md:top-[44vh] md:left-[88vw] lg:top-[32vh] lg:left-[90vw]"/>
                <img src="/assets/mascottes/HiGreenStar.svg" alt="Macotte salue" class="absolute top-[34vh] left-[38vw] h-[calc(8vw+30px)] md:top-[33vh] md:left-[32vw] lg:top-[33vh] lg:left-[36vw]"/>
                <img src="/assets/mascottes/LoveBlueCerf.svg" alt="Mascotte aime" class="absolute top-[72vh] left-[48vw] h-[calc(8vw+30px)] md:top-[62vh] md:left-[35vw] lg:top-[64vh] lg:left-[35vw]"/>
                <img src="/assets/mascottes/NinjaPinkNona.svg" alt="Mascotte ninja" class="absolute top-[62vh] left-[80vw] h-[calc(8vw+30px)] md:top-[72vh] md:left-[60vw] lg:top-[72vh] lg:left-[62vw]"/>
                <img src="/assets/mascottes/RunGreenFlower.svg" alt="Mascotte court" class="absolute top-[64vh] left-[13vw] h-[calc(8vw+30px)] md:top-[68vh] md:left-[8vw] lg:top-[68vh] lg:left-[15vw]"/>
            </div>
        </section>

        <!-- SECOND SCREEN : INFOS BLOOD LEAGUE -->

        <section id="blood-league" class="relative flex min-h-[calc(100vh-76px)] flex-col items-start justify-start bg-brand-rose-300 pt-16 lg:px-40">
            <div class="flex flex-col gap-4 px-4 text-white lg:flex-row">
                <h2 class="text-[38px]/[130%] font-semibold lg:w-[40vw] lg:shrink">
                    La Blood League, c'est quoi ?
                </h2>
                <div class="lg:shrink-2">
                    <p class="mb-4 font-medium">
                        La Blood League, c'est à la fois un championnat entre entreprises, un label RSE reconnu et une cérémonie annuelle de remise de prix. En organisant une collecte de sang pour vos employés, vous entrez dans la ligue, accumulez des points et concourez pour des médailles tout en contribuant concrètement à la santé publique genevoise.
                    </p>
                    <Link href="/blood-league">
                        <Button class="bg-white font-semibold text-brand-rose-300 hover:bg-brand-neutral-100 active:bg-brand-neutral-200">En savoir plus</Button>
                    </Link>
                </div>
            </div>

            <img src="/assets/mascottes/LightGreenTri.svg" alt="Mascotte à une idée" class="absolute top-40 left-6 hidden h-[calc(15vw+150px)] lg:block"/>

            <Carousel class="my-auto w-full pt-8 pb-10 lg:mx-auto lg:w-auto" :opts="{
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
                                Chaque saison, les meilleures entreprises de la Blood League sont récompensées. Lors de la cérémonie annuelle des Blood League Awards, cinq médailles sont décernées pour saluer la progression, la  participation, la fidélité et le renouveau célébrant toutes les formes d'excellence, quelle que soit la  taille de l'entreprise.
                            </Card>
                        </Link>
                    </CarouselItem>
                </CarouselContent>
            </Carousel>
        </section>

        <!-- THIRD SCREEN : ENTREPRISES LABELLISEES -->

        <section id="companies" class="flex flex-col items-center bg-brand-teal-500 pt-16 pb-8 text-white">
            <h2 class="lg:textcenter mb-4 px-4 text-[38px]/[130%] font-semibold">Les entreprises labellisées</h2>
            <Link href="/leaderboard">
                <Button class="bg-white font-semibold text-brand-teal-500 hover:bg-brand-neutral-100 active:bg-brand-neutral-200">Voir le leaderboard</Button>
            </Link>
            <div class="flex min-h-60 w-full flex-col justify-center overflow-hidden">
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

        <section v-if="props.collect" id="contact" class="relative flex min-h-[calc(100vh-76px)] flex-col items-center justify-start bg-brand-rose-400 pt-16 text-white lg:px-40" >
            <h2 class="mb-4 px-4 text-[38px]/[130%] font-semibold lg:hidden lg:w-[40vw]">Vérifier mon éligibilité</h2>
            <img src="/assets/cts-appel-don-du-sang.jpg" alt="Prise de sang pour un don" class="h-[50vh] w-9/10 rounded-lg object-cover lg:h-[70vh]" />
            <Link href="/checker" class="absolute bottom-[10%] lg:right-[8%] lg:bottom-[40%]" >
                <img src="/assets/round_button_lance.svg" alt="Bouton noir rond avec le texte Je me lance" class="h-40 w-40 rotate-3 transition duration-150 ease-in-out hover:scale-110 hover:rotate-30 lg:h-50 lg:w-50" />
                <!-- figure out how to make pink -->
            </Link>
            
            <div class="absolute bottom-[8%] hidden w-[60vw] rounded-lg bg-brand-rose-400 px-4 py-2 text-center lg:block" >
                <h2 class="mb-4 px-4 text-[38px]/[130%] font-semibold">Vérifier mon éligibilité</h2>
                <p class="text-center font-medium tracking-[8%] uppercase">
                    Prêt.e à représenter {{ props.displayData?.name }} ? Avant de réserver, assurez-vous de pouvoir donner. Vérifiez votre éligibilité en 2 minutes grâce à notre checker et prenez rendez-vous.
                </p>
            </div>
        </section>

        <section v-else id="contact" class="relative flex min-h-[calc(100vh-76px)] flex-col items-center justify-start bg-brand-rose-400 pt-16 text-white lg:px-40" >
            <h2 class="mb-4 px-4 text-[38px]/[130%] font-semibold lg:hidden lg:w-[40vw]">Organiser une collecte</h2>
            <img src="/assets/cts-appel-don-du-sang.jpg" alt="Prise de sang pour un don" class="h-[50vh] w-9/10 rounded-lg object-cover lg:h-[70vh]" />
            <Link href="/contact" class="absolute bottom-[10%] lg:right-[8%] lg:bottom-[40%]" >
                <img src="/assets/round_button_lance.svg" alt="Bouton noir rond avec le texte Je me lance" class="h-40 w-40 rotate-3 transition duration-150 ease-in-out hover:scale-110 hover:rotate-30 lg:h-50 lg:w-50" />
                <!-- figure out how to make pink -->
            </Link>
            
            <div class="absolute bottom-[8%] hidden w-[60vw] rounded-lg bg-brand-rose-400 px-4 py-2 text-center lg:block" >
                <h2 class="mb-4 px-4 text-[38px]/[130%] font-semibold">Organiser une collecte</h2>
                <p class="text-center font-medium tracking-[8%] uppercase">
                    Vous avez un espace disponible et des employés motivés ? Le CTS s'occupe du reste. Matériel, personnel médical, créneaux, tout est pris en charge. Vous diffusez le lien, vos employés s'inscrivent.
                </p>
            </div>
        </section>

        <!-- FIFTH SCREEN : INFOS DON -->

        <section id="don" class="relative flex flex-col items-center gap-8 bg-brand-sage-400 py-16 overflow-hidden lg:px-60">
            <img src="/assets/mascottes/YeahPinkFlam.svg" alt="Mascotte supporte" class="right-[25vw] md:relative md:-mt-4 md:-mb-15 lg:absolute lg:top-[15%] lg:-left-20 lg:h-[80%]"/>
            <img src="/assets/mascottes/ScreamBlueNona.svg" alt="Mascotte crie" class="hidden scale-x-[-1] lg:absolute lg:top-[15%] lg:-right-15 lg:block lg:h-[80%]"/>
            <h2 class="px-4 text-[38px]/[130%] font-semibold">Pourquoi donner ?</h2>
            <p class="mx-12 text-center font-medium tracking-[8%] uppercase">
                Vous vous demandez quel est l'impact réel du don du sang, ou quelles sont les conditions pour pouvoir donner ? Découvrez plus d'informations sur le don du sang.
            </p>
            <Link href="/don-du-sang">
                <Button class="bg-white font-semibold text-brand-sage-500 hover:bg-brand-neutral-100 active:bg-brand-neutral-200">En savoir plus</Button>
            </Link>
            <img src="/assets/mascottes/ScreamBlueNona.svg" alt="Mascotte crie" class="left-[25vw] mt-4 scale-x-[-1] md:relative md:-mt-15 md:-mb-6 lg:hidden"/>
        </section>
        <CharacterLoop />
    </AppLayout>
</template>
