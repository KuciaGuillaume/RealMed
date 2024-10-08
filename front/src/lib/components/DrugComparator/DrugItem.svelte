<script lang="ts">
  import Fa from "svelte-fa";
  import Badge from "../Badge.svelte";
  import DonutChart from "./DonutChart.svelte";
  import { faExclamationCircle } from "@fortawesome/free-solid-svg-icons";

  export let isSelected: boolean = false;

  export let drug: {
    name: string,
    description: string,
    imgLink: string,
    score: number,
  };

</script>

<button on:click class="{isSelected ? "border-cblue" : "hover:bg-gray-50"}  flex flex-col w-full h-fit shadow-md border-2 rounded-lg bg-white p-4">
  <div class="w-fit min-h-8 rounded-md bg-red-500/20 border border-red-500 flex flex-row gap-2 items-center px-2">
    <Fa icon={faExclamationCircle} class="text-red-500" size="sm" color="rgb(239 68 68)" />
    <span class="font-poppins text-xs"> Médicament non recommandé dans votre cas </span>
  </div>
  <div class="flex flex-row w-full h-full min-h-[9rem] max-h-[9rem] gap-4">
    <div class="min-h-full max-h-full aspect-square rounded-lg overflow-hidden rounded-r-none">
      <img src={drug.imgLink} alt="" class="size-full object-cover">
    </div>
    <div class="flex flex-col gap-2 h-full justify-center">
      <h2 class="font-poppins text-sm text-left">{drug.name}</h2>
      <p class="font-poppins text-xs text-gray-600 text-left">{drug.description}</p>
      <div class="flex flex-wrap gap-1">
        <Badge color={"red"}>
          Enfant/bébé
        </Badge>
        <Badge color={"green"}>
          Adulte
        </Badge>
        <Badge color={"orange"}>
          Femme enceinte
        </Badge>
      </div>
    </div>
    <div class="h-full aspect-square">
      <DonutChart data={[
          {
            name: drug.name,
            value: drug.score,
            color: drug.score >= 50 ? '#32de84' : drug.score > 25 ? '#f7b52b' : '#f54242'
          },
          {
            name: 'gray',
            value: 100 - drug.score,
            color: '#F5F3F3'
          }
        ]}
      />
    </div>
  </div>
</button>