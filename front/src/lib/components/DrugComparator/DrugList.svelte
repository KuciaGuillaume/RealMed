<script lang="ts">
  import DrugItem from "./DrugItem.svelte";

  export let drugItems : {
    name: string,
    description: string,
    imgLink: string,
    score: number,
    isSelected: boolean,
  }[] = [];
  
  const handleSelect = (index : number) => {
    drugItems = drugItems.map((drug, i) => {
      if (i === index) {
        return {
          ...drug,
          isSelected: true,
        };
      } else {
        return {
          ...drug,
          isSelected: false,
        };
      }
    });
  };

</script>

<div class="flex flex-col size-full p-4 gap-4">
  <p class="font-poppins text-xs text-black/70">Ce classement par défaut prend en compte l’intérêt potentiel pour l’utilisateur, l’efficacité des médicaments et la pertinence des informations médicales disponibles. Les options présentées ne sont pas exhaustives.</p>
  <p class="font-poppins text-sm text-black/70">Nous avons trouvé <strong>{drugItems.length}</strong> résultats</p>
  <div class="flex flex-col w-full overflow-y-scroll gap-4 scroll-container">
    {#each drugItems as drug, i}
      <DrugItem
        on:click={() => handleSelect(i)}
        {drug}
        isSelected={drug.isSelected}
      />
    {/each}
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