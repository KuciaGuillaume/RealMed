<script lang="ts">
  import Fa from "svelte-fa";
import DrugItem from "./DrugItem.svelte";
  import { faArrowDown } from "@fortawesome/free-solid-svg-icons";

  export let drugItems : {
    name: string,
    description: string,
    imgLink: string,
    score: number,
    data: DrugResult
  }[] = [];
  export let selectedItem : string | null = "";
  
  const handleSelect = (index : number) => {
    const item = drugItems[index];
    selectedItem = item.name;
  };

</script>

<div class="flex flex-col size-full pl-4 gap-4">
  <p class="font-poppins text-xs text-black/70">Ce classement par défaut prend en compte l’intérêt potentiel pour l’utilisateur, l’efficacité des médicaments et la pertinence des informations médicales disponibles. Les options présentées ne sont pas exhaustives.</p>
  <p class="font-poppins text-sm text-black/70">Nous avons trouvé <strong>{drugItems.length}</strong> résultats</p>
  <div class="flex flex-col w-full overflow-y-scroll gap-4 scroll-container pb-4">
    {#key drugItems}
      <DrugItem
        on:click={() => handleSelect(0)}
        drug={drugItems[0]}
        isSelected={!selectedItem || selectedItem == "" ? true : drugItems[0].name === selectedItem}
        isTargeted={true}
      />
    {/key}
    <h3 class="text-xs font-poppins flex flex-row gap-2 items-center">
      Médicaments similaires
      <Fa icon={faArrowDown} class="text-cblue" size="xs" color="black" />
    </h3>
    {#key drugItems}
      {#each drugItems as drug, i}
        {#if i != 0}
          <DrugItem
            on:click={() => handleSelect(i)}
            {drug}
            isSelected={!selectedItem || selectedItem == "" ? false : drug.name === selectedItem}
          />
        {/if}
      {/each}
    {/key}
  </div>
</div>

<style>
  .scroll-container {
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  .scroll-container::-webkit-scrollbar {
    display: none;
  }
</style>