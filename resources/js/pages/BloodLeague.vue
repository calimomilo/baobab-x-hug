<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import CharacterLoop from '@/components/CharacterLoop.vue';
import LabelCard from '@/components/LabelCard.vue';
import AwardIcon from '@/components/svg/AwardIcon.vue';
import AppLayout from '@/layouts/AppLayout.vue';

</script>

<template>

    <AppLayout title="Blood League" desc="Découvrez comment fonctionne la Blood League, le label, et la cérémonie.">
        <section id="blood-league" class="relative min-h-[calc(100vh-76px)] flex flex-col px-8 py-15 gap-15 lg:px-40 font-medium">
            <div class="flex flex-col justify-center gap-8 lg:text-xl">
                <h2 class="w-9/10 text-2xl font-bold md:text-[50px] md:w-full">Qu'est-ce que la Blood League ?</h2>
                <div class="flex flex-col justify-center gap-8 md:flex-row md:justify-start">
                    <p>La Blood League est une ligue de don du sang en entreprise. Les entreprises organisent des collectes pour leurs employé.e.s et accumulent des points tout au long de l'année selon leur efficacité et leur mobilisation. Plus une entreprise prépare bien ses employé.e.s en amont, plus son score est élevé.</p>
                    <img src="/assets/mascottes/LightGreenTri.svg" alt="Mascotte à une idée" class="h-60 scale-x-[-1] -mb-6">
                </div>
            </div>
            <div id="label" class="flex flex-col justify-center gap-8 font-medium md:text-xl">
                <h2 class="w-9/10 text-2xl text-end self-end font-bold md:text-[50px] md:w-full md:text-start">Qu'est-ce qu'un Blood League Label ?</h2>
                <div>La ligue est divisée en trois divisions :
                    <div class="inline-block bg-brand-sage-300 text-brand-sage-900 px-[2px] -skew-x-8">
                        <span class="inline-block skew-x-8">Classic</span>
                    </div>,
                    <div class="inline-block bg-brand-warning-300 text-brand-warning-800 px-[2px] -skew-x-8">
                        <span class="inline-block skew-x-8">Gold</span>
                    </div> et
                    <div class="inline-block bg-brand-violet-300 text-brand-violet-900 px-[2px] -skew-x-8">
                        <span class="inline-block skew-x-8">Legend</span>
                    </div>, dans lesquelles les entreprises progressent au fil des saisons.
                </div>
                <p class="text-end md:text-start">En fin de saison, chaque entreprise reçoit automatiquement le label correspondant à sa division. Affichable sur le site web, dans les rapports RSE, sur LinkedIn ou dans les offres d'emploi c'est une reconnaissance concrète de l'engagement social de l'entreprise.</p>
            </div>
            <div class="flex flex-wrap gap-4 mb-4">
                <LabelCard title="Blood League Label" label="classic" class="shrink-0 grow">Le Blood League Label récompense toutes les entreprises qui jouent le jeu, quelle que soit leur performance sur la saison.</LabelCard>
                <LabelCard title="Label Gold" label="gold" class="shrink-0 grow">Le label Gold distingue les entreprises qui participent régulièrement, mobilisent bien leurs équipes et affichent un bon taux de participation.</LabelCard>
                <LabelCard title="Label Legend" label="legend" class="shrink-0 grow">Le label Legend est réservé aux entreprises au sommet de la ligue qui excellent sur tous les critères.</LabelCard>
            </div>
        </section>
        <section id="awards" class="relative min-h-[calc(100vh-76px)] flex flex-col px-8 py-15 gap-12 bg-brand-sage-400 font-medium lg:px-40 lg:text-xl">
            <h2 class="w-9/10 text-2xl font-bold md:text-[50px] md:w-full">Que sont les Blood League Awards ?</h2>
            <p>Chaque année, lors de la cérémonie des Blood League Awards, les HUG récompensent les entreprises qui se sont le plus distinguées dans leur engagement pour le don de sang. Quatre médailles sont décernées pour saluer la progression, la participation, la fidélité et le renouveau célébrant ainsi toutes les formes d'excellence, quelle que soit la taille de l'entreprise. Un prix du jury, décerné par les membres des HUG, vient couronner l'entreprise qui a marqué l'année par un engagement exceptionnel et une démarche humaine hors du commun.</p>
            <div class="flex flex-row flex-wrap gap-y-10 gap-x-6">
                <div class="flex flex-col items-center w-60 shrink-0 grow lg:w-80">
                    <AwardIcon award="flood" />
                    <p class="text-center font-medium uppercase tracking-[8%] w-60 pt-1 lg:w-80">Médaille de la meilleure participation</p>
                </div>
                <div class="flex flex-col items-center w-60 shrink-0 grow lg:w-80">
                    <AwardIcon award="pulse" />
                    <p class="text-center font-medium uppercase tracking-[8%] w-60 pt-1 lg:w-80">Médaille du meilleur soutien</p>
                </div>
                <div class="flex flex-col items-center w-60 shrink-0 grow lg:w-80">
                    <AwardIcon award="climber" />
                    <p class="text-center font-medium uppercase tracking-[8%] w-60 pt-1 lg:w-80">Médaille de la meilleure progression</p>
                </div>
                <div class="flex flex-col items-center w-60 shrink-0 grow lg:w-80">
                    <AwardIcon award="new_vein" />
                    <p class="text-center font-medium uppercase tracking-[8%] w-60 pt-1 lg:w-80">Médaille de la meilleure nouvelle entreprise</p>
                </div>
                <div class="flex flex-col items-center w-60 shrink-0 grow lg:w-80">
                    <AwardIcon award="golden_heart" />
                    <p class="text-center font-medium uppercase tracking-[8%] w-60 pt-1 lg:w-80">Prix du jury</p>
                </div>
            </div>
        </section>
        <section id="contact" class="relative flex flex-col px-8 py-10 gap-12 bg-brand-rose-400 font-medium items-center text-white lg:px-40 lg:text-lg">
            <h2 class="text-[38px]/[130%] font-semibold px-4 ">Votre entreprise n'est pas encore labellisée ?</h2>
            <p class="text-center font-medium uppercase tracking-[8%] mx-12">Rejoignez dès maintenant la Blood League et obtenez votre label en organisant vos premières collectes de sang. Ensemble, faisons la différence.</p>
            <Link href="/contact" class="lg:relative lg:right-90 lg:bottom-5">
                <img src="/assets/round_button_organize.svg" alt="Bouton noir rond avec le texte Organiser une collecte" class="w-40 h-40 -rotate-10 lg:w-50 lg:h-50 hover:scale-110 hover:rotate-20 transition duration-150 ease-in-out"> <!-- figure out how to make pink -->
            </Link>
            <img src="/assets/mascottes/WriteBlueStar.svg" alt="Mascotte écrit" class="hidden lg:block  absolute h-80 right-5 bottom-5">
        </section>
        <CharacterLoop/>
    </AppLayout>
</template>
