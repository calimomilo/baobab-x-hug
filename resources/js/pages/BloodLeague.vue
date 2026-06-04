<script setup lang="ts">
import LabelCard from '@/components/LabelCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';

</script>

<template>

    <AppLayout title="Blood League" desc="Découvrez comment fonctionne la Blood League, le label, et la cérémonie.">
        <section id="blood-league" class="relative min-h-[calc(100vh-76px)] flex flex-col px-8 py-10 gap-15 lg:px-40">
            <div class="flex flex-col justify-center gap-8 font-medium lg:text-xl">
                <h2 class="w-9/10 text-2xl font-bold md:text-[50px] md:w-full">Qu'est-ce que la Blood League ?</h2>
                <p>La Blood League est une ligue de don du sang en entreprise. Les entreprises organisent des collectes pour leurs employé.e.s et accumulent des points tout au long de l'année selon leur efficacité et leur mobilisation. Plus une entreprise prépare bien ses employé.e.s en amont, plus son score est élevé.</p>
            </div>
            <div class="flex flex-col justify-center gap-8 font-medium md:text-xl">
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
            <div class="flex flex-wrap gap-4">
                <LabelCard title="Blood League Label" label="classic" class="shrink-0 grow">Reconnaît l'engagement initial de l'entreprise dans la solidarité sanguine et valorise les premiers pas dans la démarche collective.</LabelCard>
                <LabelCard title="Label Gold" label="gold" class="shrink-0 grow">Célèbre un engagement régulier et une mobilisation confirmée des collaborateurs autour de la cause du don de sang.</LabelCard>
                <LabelCard title="Label Legend" label="legend" class="shrink-0 grow">Distingue les champions de la solidarité sanguine et reconnaît un engagement exemplaire au service de la santé publique.</LabelCard>
            </div>
        </section>
    </AppLayout>
</template>