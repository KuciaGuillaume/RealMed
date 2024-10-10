<script lang="ts">
  import Fa from "svelte-fa";
  import Badge from "../Badge.svelte";
  import DonutChart from "./DonutChart.svelte";
  import { faExclamationCircle, faStar } from "@fortawesome/free-solid-svg-icons";
  import { page } from "$app/stores";
  import { codeToCondition, getAllConditionsAsCode } from "$lib/functions";

  export let isSelected: boolean = false;
  export let isTargeted: boolean = false;
  export let drug: {
    name: string,
    description: string,
    imgLink: string,
    score: number,
    data: DrugResult
  };
  export let handleFavorite : (drugName: string) => void = () => {};

  $: condition = $page.url.searchParams.get("condition");
  $: allergie = $page.url.searchParams.get("allergie");

  const handleAddFavorite = async (drugName: string) => {
    if (drug.data.isFavorite) {
      const res = await fetch(`/api/remove_favorite?drugName=${drugName}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        }
      });
      drug.data.isFavorite = !res.ok;
    } else {
      const res = await fetch(`/api/favorite?drugName=${drugName}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        }
      });
      drug.data.isFavorite = res.ok;
    }
    handleFavorite(drugName);
  }

</script>

<button on:click class="{isSelected ? "border-cblue" : "hover:bg-gray-50"} relative flex flex-col gap-4 w-full h-fit shadow-md border-2 rounded-lg bg-white p-4">
  <div class="flex flex-row gap-4">
    {#if isTargeted}
      <div class="w-fit min-h-8 rounded-md bg-cblue border border-cblue flex flex-row gap-2 items-center px-2">
        <span class="font-poppins text-xs text-white font-semibold"> Résultat de votre recherche </span>
      </div>
    {/if}
    {#if condition && condition != "" && !drug.data.specificCondition.includes(condition)}
      <div class="w-fit min-h-8 rounded-md bg-red-500/20 border border-red-500 flex flex-row gap-2 items-center px-2">
        <Fa icon={faExclamationCircle} class="text-red-500" size="sm" color="rgb(239 68 68)" />
        <span class="font-poppins text-xs"> Médicament non recommandé dans votre cas </span>
      </div>
    {/if}
    {#if allergie && allergie != "" && drug.data.conditioning.includes(allergie)}
      <div class="w-fit min-h-8 rounded-md bg-orange-500/20 border border-orange-500 flex flex-row gap-2 items-center px-2">
        <Fa icon={faExclamationCircle} class="text-orange-500" size="sm" color="rgb(249 115 22)" />
        <span class="font-poppins text-xs"> Risque d'allergie </span>
      </div>
    {/if}
  </div>
  <div class="flex flex-row w-full h-full min-h-[9rem] max-h-[9rem] gap-4">
    <div class="min-w-[8rem] min-h-[8rem] max-w-[8rem] max-h-[8rem] rounded-lg overflow-hidden rounded-r-none">
      <img src={drug.imgLink} alt="" class="size-full object-cover">
    </div>
    <div class="flex flex-col gap-2 h-full justify-center">
      <h2 class="font-poppins text-sm text-left">{drug.name}</h2>
      <p class="font-poppins text-xs text-gray-600 text-left">{drug.description}</p>
      <div class="flex flex-wrap gap-1">
        {#each getAllConditionsAsCode() as condition}
          <Badge color={drug.data.specificCondition.includes(condition) ? "green": "red"}>
            {codeToCondition(condition)}
          </Badge>
        {/each}
      </div>
    </div>
    <div class="flex flex-grow justify-end">
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
  </div>
  <button on:click|stopPropagation={() => handleAddFavorite(drug.name)} class="absolute size-10 right-0 top-0 mr-2 mt-2 flex items-center justify-center">
    <Fa icon={faStar} color={drug.data.isFavorite ? "rgb(2 121 194" : "rgb(229 231 235)"} />
  </button>
</button>