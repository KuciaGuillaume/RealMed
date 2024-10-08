<script lang="ts">
  import { fly } from "svelte/transition";
  import DrugList from "./DrugList.svelte";
  import DonutChart from "./DonutChart.svelte";
  import DrugItem from "./DrugItem.svelte";
  import StatLabel from "./StatLabel.svelte";
  import Pellet from "../Pellet.svelte";
  import ListItem from "./ListItem.svelte";
  import Layout from "../../../routes/+layout.svelte";
  import DonutChartSpec from "../DonutChartSpec.svelte";

  $: drugItems = [
    {
      name: "Doliprane 1000 mg",
      description: "Analgésique et antipyrétique indiqué pour le traitement symptomatique de la douleur et de la fièvre.",
      imgLink: "https://www.pharma-gdd.com/media/cache/resolve/product_show/333430303933353935353833382d646f6c697072616e652d313030306d672d382d636f6d7072696d657313e8670f.jpg",
      score: 80,
      isSelected: true,
    },
    {
      name: "Nurofen 200 mg",
      description: "Anti-inflammatoire non stéroïdien utilisé pour soulager les douleurs légères à modérées et la fièvre.",
      imgLink: "https://www.pharma-gdd.com/media/cache/resolve/product_show/6e75726f66656e2d3230302d6d672d636f6d7072696d6500a64a74.jpg",
      score: 70,
      isSelected: false
    },
    {
      name: "Spasfon",
      description: "Antispasmodique indiqué dans le traitement des douleurs liées aux troubles fonctionnels du tube digestif et des voies biliaires.",
      imgLink: "https://www.pharma-gdd.com/media/cache/resolve/product_show/746576612d73706173666f6e2d33302d636f6d7072696d65732d66616365e0be8e81.jpg",
      score: 60,
      isSelected: false,
    },
    {
      name: "Smecta",
      description: "Pansement digestif utilisé dans le traitement symptomatique des diarrhées aiguës chez l'enfant et l'adulte.",
      imgLink: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkQJhV1Cm3x1YC07KKkIqxmKfd3OVc1e2nvw&s",
      score: 50,
      isSelected: false,
    },
    {
      name: "Gaviscon",
      description: "Médicament indiqué pour soulager les symptômes du reflux gastro-œsophagien tels que les brûlures d'estomac.",
      imgLink: "https://www.illicopharma.com/75321/gaviscon-pro-10-sachets-dose.jpg",
      score: 40,
      isSelected: false,
    },
    {
      name: "Imodiumcaps 2 mg",
      description: "Antidiarrhéique utilisé pour traiter les symptômes des diarrhées aiguës passagères chez l'adulte et l'enfant de plus de 15 ans.",
      imgLink: "https://www.pharma-coquillages.com/5907-large_default/imodiumcaps-2-mg-12-gelules.jpg",
      score: 30,
      isSelected: false,
    },
    {
      name: "Efferalgan 500 mg",
      description: "Analgésique et antipyrétique pour le traitement symptomatique des douleurs et/ou de la fièvre.",
      imgLink: "https://www.pharma-gdd.com/media/cache/resolve/product_show/757073612d6566666572616c67616e2d6d65642d3530306d672d32342d636f6d7072696d65732d66616365c84c5a2b.jpg",
      score: 20,
      isSelected: false,
    },
    {
      name: "Voltarène 1% Gel",
      description: "Anti-inflammatoire non stéroïdien pour application cutanée, utilisé dans le traitement local des douleurs articulaires et musculaires.",
      imgLink: "https://www.pharma-gdd.com/media/cache/resolve/product_show/67736b2d766f6c746172656e652d656d756c67656c2d312d313030672d66616365285f5df9.jpg",
      score: 10,
      isSelected: false,
    },
  ];

  $: drug = drugItems.find((drug) => drug.isSelected) || drugItems[0];

  let innerHeight : number = 0;
</script>

<svelte:window bind:innerHeight />

<div 
  in:fly={{ duration: 200, y: 100, opacity: 0 }}
  style="height: calc({innerHeight}px - 224px);"
  class="w-screen bg-cgray flex flex-row">
  <div class="w-1/2 h-full">
    <DrugList bind:drugItems />
  </div>
  {#key drugItems}
    <div class="w-1/2 h-full pt-4 px-4">
      <div class="flex flex-col size-full bg-white rounded-xl rounded-b-none border shadow-mds p-4 gap-4">
        <div>
          <h2 class="font-poppins"> Spécificités du médicament </h2>
          <div class="grid grid-cols-2 gap-2 w-full rounded-lg p-2 px-0">
            <StatLabel label={"Délai d'action"} value={"15 min"} />
            <StatLabel label={"Taille du médicament"} value={"10 mm"} />
            <StatLabel label={"Forme d'administration"} value={"Gélule"} />
            <StatLabel label={"Méthode d'administration"} value={"Oral"} />
            <StatLabel label={"Durée d'efficacité"} value={"4-6 heures"} />
            <StatLabel label={"Conditionnement"} value={"Blister"} />
            <StatLabel label={"Aspect"} value={"Comprimé rond, sécable"} />
            <StatLabel label={"Couleur"} value={"Blanc"} />
            <StatLabel label={"Indications fréquentes"} value={"Douleur, inflammation"} />
            <StatLabel label={"Effets secondaires possibles"} value={"Nausées, maux de tête"} />
          </div>
        </div>
        <div class="w-full max-h-60 flex-row flex">
          <div class="h-full w-1/2">
            <h2 class="font-poppins"> Sévérité des effets secondaires </h2>
            <div class="h-full aspect-square">
              <DonutChartSpec 
                label={null}
                data={[
                  {
                    category: "low risk",
                    value: 20,
                    color: '#32de84'
  
                  },
                  {
                    category: 'medium risk',
                    value: 40,
                    color: '#f7b52b'
                  },
                  {
                    category: 'high risk',
                    value: 40,
                    color: '#f54242'
                  }
                ]}
              />
            </div>
          </div>
          <div class="h-full w-1/2">
            <h2 class="font-poppins">
              Effets secondaires
            </h2>
            <ul class="font-poppins text-xs gap-1 flex flex-col pt-1">
              <ListItem color={"green"} label={"Nausées"} />
              <ListItem color={"green"} label={"Vomissements"} />
              <ListItem color={"orange"} label={"Douleurs abdominales"} />
              <ListItem color={"orange"} label={"Somnolence"} />
              <ListItem color={"orange"} label={"Éruption cutanée"} />
              <ListItem color={"orange"} label={"Démangeaisons"} />
              <ListItem color={"red"} label={"Réactions allergiques sévères (œdème de Quincke, choc anaphylactique)"} />
              <ListItem color={"red"} label={"Troubles hépatiques (toxicité hépatique en cas de surdosage)"} />
              <ListItem color={"red"} label={"Thrombopénie (diminution des plaquettes)"} />
              <ListItem color={"red"} label={"Leucopénie (diminution des globules blancs)"} />
            </ul>
          </div>
        </div>
      </div>
    </div>
  {/key}
</div>

<!-- drug.score >= 50 ? '#32de84' : drug.score > 25 ? '#f7b52b' : '#f54242' -->