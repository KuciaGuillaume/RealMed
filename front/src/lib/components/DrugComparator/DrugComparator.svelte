<script lang="ts">
  import { fly } from "svelte/transition";
  import DrugList from "./DrugList.svelte";
  import StatLabel from "./StatLabel.svelte";
  import ListItem from "./ListItem.svelte";
  import DonutChartSpec from "../DonutChartSpec.svelte";
  import { selectedDrugStore } from "$lib/store";
  import Fa from "svelte-fa";
  import { faArrowLeft } from "@fortawesome/free-solid-svg-icons";

  export let drugData: DrugResult[] | null = null;
  export let isLargePanel: boolean;
  export let isSearched: boolean;

  $: console.log(drugData);

  let innerHeight : number = 0;

  // Fonction pour parser les temps
  function parseTime(timeStr : string) {
    let timeInMinutes = 0;

    if (!timeStr) return timeInMinutes;

    if (timeStr.includes('-')) {
      // Plage de valeurs
      let parts = timeStr.split('-');
      let minPart = parseFloat(parts[0]);
      let maxPart = parseFloat(parts[1]);
      // Vérifier l'unité
      if (timeStr.includes('h')) {
        // Convertir en minutes
        timeInMinutes = ((minPart + maxPart) / 2) * 60;
      } else {
        timeInMinutes = (minPart + maxPart) / 2;
      }
    } else {
      // Valeur unique
      let value = parseFloat(timeStr);
      if (timeStr.includes('h')) {
        timeInMinutes = value * 60;
      } else {
        timeInMinutes = value;
      }
    }

    return timeInMinutes;
  }

  const getScore = (drug : DrugResult) => {
    // 1. Score des effets secondaires
    const totalEffects = drug.secondaryEffectsDetails.length;
    const totalSeverity = drug.secondaryEffectsDetails.reduce(
      (sum, effect) => sum + effect.severity,
      0
    );
    const averageSeverity = totalSeverity / totalEffects;
    
    // Sévérité va de 1 à 3, on inverse pour que moins de sévérité donne un score plus élevé
    const sideEffectsScore = ((3 - averageSeverity) / (3 - 1)) * 100;
    
    // 2. Score du temps d'efficacité
    const efficiencyTimeInMinutes = parseTime(drug.efficiencyTime);
    const minEfficiencyTime = 15; // Basé sur les données fournies
    const maxEfficiencyTime = 60;
    const efficiencyTimeScore = ((maxEfficiencyTime - efficiencyTimeInMinutes) / (maxEfficiencyTime - minEfficiencyTime)) * 100;
    
    // 3. Score de la durée d'action
    const durationTimeInMinutes = parseTime(drug.durationTime);
    const minDurationTime = 180; // 3 heures en minutes
    const maxDurationTime = 480; // 8 heures en minutes
    const durationTimeScore = ((durationTimeInMinutes - minDurationTime) / (maxDurationTime - minDurationTime)) * 100;
    
    // 4. Score du mode d'administration
    let administrationScore = 0;
    if (drug.format === 'Oral') {
      administrationScore = 100;
    } else if (drug.format === 'Rectal') {
      administrationScore = 50;
    } else {
      administrationScore = 70; // Par défaut
    }
    
    // 5. Score de la taille
    let sizeScore = 0;
    if (drug.size === 'Small') {
      sizeScore = 100;
    } else if (drug.size === 'Medium') {
      sizeScore = 70;
    } else if (drug.size === 'Large') {
      sizeScore = 40;
    } else {
      sizeScore = 70; // 'N/A' ou autres
    }
    
    // Pondérations (doivent totaliser 1)
    const weights = {
      sideEffects: 0.4,
      efficiencyTime: 0.2,
      durationTime: 0.1,
      administration: 0.1,
      size: 0.2,
    };
    
    // Calcul du score total
    const totalScore =
      sideEffectsScore * weights.sideEffects +
      efficiencyTimeScore * weights.efficiencyTime +
      durationTimeScore * weights.durationTime +
      administrationScore * weights.administration +
      sizeScore * weights.size;
    
    return Number(totalScore.toFixed(0));
  };

  $: drugItems = (() => {
    if (!drugData) return [];

    const firstDrug = drugData[0];

    const sortedDrugs = drugData.slice(1).map((med) => ({
      name: med.name || "Nom non disponible",
      description: med.shortDescription || "Pas de description disponible",
      imgLink: med.imageLink || "Pas d'image disponible",
      score: getScore(med),
      isSelected: false,
      data: med
    })).sort((a, b) => b.score - a.score);

    return [
      {
        name: firstDrug.name || "Nom non disponible",
        description: firstDrug.shortDescription || "Pas de description disponible",
        imgLink: firstDrug.imageLink || "Pas d'image disponible",
        score: getScore(firstDrug),
        isSelected: false,
        data: firstDrug
      },
      ...sortedDrugs
    ];
  })();

  $: drug = drugItems.find((item) => item.name === $selectedDrugStore)?.data ?? drugItems[0]?.data;
  $: percentOfLowSeverity = drug?.secondaryEffectsDetails.filter((effect) => effect.severity == 1).length / drug?.secondaryEffectsDetails.length * 100;
  $: percentOfMediumSeverity = drug?.secondaryEffectsDetails.filter((effect) => effect.severity == 2).length / drug?.secondaryEffectsDetails.length * 100;
  $: percentOfHighSeverity = drug?.secondaryEffectsDetails.filter((effect) => effect.severity == 3).length / drug?.secondaryEffectsDetails.length * 100;
</script>

<svelte:window bind:innerHeight />

<div 
  in:fly={{ duration: 300, y: 100, opacity: 0 }}
  style="{isLargePanel ? `height: calc(${innerHeight}px - 64px)` : `height: calc(${innerHeight}px - 224px)`}"
  class="w-screen bg-cgray flex flex-col">
  {#if isSearched}
    <div class="w-full flex justify-center min-h-10 items-center">
      <button 
        on:click={() => isLargePanel = !isLargePanel} 
        class="w-20 flex z-10 items-center justify-center h-5 border rounded-lg  bg-white">
        <Fa icon={faArrowLeft} class="flex z-0 {isLargePanel ? '-rotate-90' : 'rotate-90'} cursor-pointer duration-200" size="xs" />
      </button>
    </div>
  {/if}
  <div class="w-full flex flex-row h-[calc(100%-40px)]">
    <div class="w-1/2 h-full">
      <DrugList bind:drugItems bind:selectedItem={$selectedDrugStore} />
    </div>
    {#key drug}
      {#if drug}
        <div class="w-1/2 h-full pt-4 px-4">
          <div class="flex flex-col size-full bg-white rounded-xl rounded-b-none border shadow-mds p-4 overflow-y-auto">
            <div 
              in:fly|global={{ duration: 400, y: 100, opacity: 0 }}
              class="flex flex-col size-full gap-4">
              <div>
                <h2 class="font-poppins"> Spécificités du médicament </h2>
                <div class="grid grid-cols-2 gap-2 w-full rounded-lg p-2 px-0">
                  <StatLabel label={"Délai d'action"} value={drug?.durationTime ?? 'N/A'} />
                  <StatLabel label={"Taille du médicament"} value={drug?.size ?? 'N/A'} />
                  <StatLabel label={"Forme d'administration"} value={drug?.format ?? "N/A"} />
                  <StatLabel label={"Méthode d'administration"} value={drug?.administration ?? "N/A"} />
                  <StatLabel label={"Durée d'efficacité"} value={drug?.efficiencyTime ?? "N/A"} />
                  <StatLabel label={"Aspect"} value={drug?.aspect ?? "N/A"} />
                  <StatLabel label={"Couleur"} value={drug?.color ?? "N/A"} />
                  <StatLabel label={"Indications fréquentes"} value={drug?.commonAffliction ?? "N/A"} />
                </div>
              </div>
              <div class="w-full max-h-[15rem] flex-row flex">
                <div class="h-full w-1/2">
                  <h2 class="font-poppins"> Sévérité des effets secondaires </h2>
                  <div class="h-full aspect-square -mt-8 w-full">
                    <DonutChartSpec 
                      label={null}
                      data={[
                        {
                          category: "Sévérité faible",
                          value: percentOfLowSeverity,
                          color: '#32de84'
        
                        },
                        {
                          category: 'Sévérité moyenne',
                          value: percentOfMediumSeverity,
                          color: '#f7b52b'
                        },
                        {
                          category: 'Sévérité élevé',
                          value: percentOfHighSeverity,
                          color: '#f54242'
                        }
                      ]}
                      unit="%"
                    />
                  </div>
                </div>
                <div class="h-full w-1/2">
                  <h2 class="font-poppins">
                    Effets secondaires
                  </h2>
                  <ul class="font-poppins text-xs gap-1 flex flex-col pt-1 pb-4">
                    {#each drug?.secondaryEffectsDetails as secondaryEffect}
                      <ListItem color={
                        secondaryEffect.severity == 1
                        ? 'green' : secondaryEffect.severity == 2
                        ? 'orange' : 'red'} label={secondaryEffect.name} />
                    {/each}
                  </ul>
                </div>
              </div>
              <div class="w-full flex flex-col gap-2 -mt-10 pb-4">
                <h3 class="font-poppins"> Conseilles d'utilisation:  </h3>
                <p class="font-poppins text-xs">
                  {drug?.usage}
                </p>
              </div>
            </div>
          </div>
        </div>
      {/if}
    {/key}
  </div>
</div>