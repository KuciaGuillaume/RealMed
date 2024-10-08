<script lang="ts">
  import { tick } from 'svelte';
  import Fa from 'svelte-fa';
  import { faNotesMedical, faPerson, faSearch, faUser, faUserGroup, faX } from '@fortawesome/free-solid-svg-icons';
  import { fly } from 'svelte/transition';

  let isSelected = false;
  export let query = '';

  const personTypes = [
    {
      name: "Bébé",
      description: "Enfant de moins de 2 ans",
      genderSpecific: false
    },
    {
      name: "Enfant",
      description: "Personne de 2 à 12 ans",
      genderSpecific: false
    },
    {
      name: "Adolescent",
      description: "Personne de 13 à 17 ans",
      genderSpecific: true,
      gender: ["Homme", "Femme"]
    },
    {
      name: "Adulte Homme",
      description: "Homme de 18 ans ou plus",
      genderSpecific: true,
      gender: "Homme"
    },
    {
      name: "Adulte Femme",
      description: "Femme de 18 ans ou plus",
      genderSpecific: true,
      gender: "Femme"
    },
    {
      name: "Femme enceinte",
      description: "Femme en période de grossesse",
      genderSpecific: true,
      gender: "Femme",
      specificCondition: "Grossesse"
    },
    {
      name: "Senior Homme",
      description: "Homme de plus de 65 ans",
      genderSpecific: true,
      gender: "Homme"
    },
    {
      name: "Senior Femme",
      description: "Femme de plus de 65 ans",
      genderSpecific: true,
      gender: "Femme"
    },
  ];

  const handleClick = async () => {
    isSelected = !isSelected;
  };

  function clickOutside(node: HTMLElement) {
    const handleOutsideClick = (event: MouseEvent) => {
      if (node && !node.contains(event.target as Node)) {
        isSelected = false;
      }
    };

    document.addEventListener('click', handleOutsideClick, true);

    return {
      destroy() {
        document.removeEventListener('click', handleOutsideClick, true);
      },
    };
  }

</script>

<button
  use:clickOutside
  on:click={handleClick}
  class="relative flex flex-row h-full w-[17rem] rounded-lg duration-200 {isSelected ? 'border-cblue border-2' : 'hover:bg-gray-100 border-2 border-transparent'} cursor-default">
  <div class="flex items-center justify-center h-full aspect-square">
    <Fa icon={faUserGroup} class="text-gray-500" size="lg" color="black" />
  </div>
  <div class="flex flex-col h-full justify-center items-start flex-grow">
    <span class="font-poppins text-xs text-gray-500 text-left">Condition spécifique</span>
    <span class="font-poppins text-sm">{query == "" ? "Aucune" : query}</span>
  </div>
  {#if !isSelected && query != ""}
    <div class="h-full aspect-square flex items-center justify-center">
      <button on:click={() => query=""} class="p-2">
        <Fa icon={faX} class="text-gray-500" size="xs" color="black" />
      </button>
    </div>
  {/if}
  {#if isSelected}
    <div in:fly={{ duration: 100, y: 10 }} out:fly={{ duration: 100, y: 10 }} class="absolute top-full left-0 pt-4 w-40">
      <div class="flex flex-col w-[450px] max-h-60 h-fit rounded-xl bg-white shadow-md border overflow-hidden p-2 overflow-y-scroll gap-2">
        {#each personTypes as personType}
        <button
          on:click={() => query=personType.name} 
          class="flex flex-row w-full min-h-14 items-center justify-start p-2 px-4 hover:bg-gray-100 rounded-xl cursor-pointer gap-4">
          <div class="flex items-center justify-center h-full aspect-square">
            <Fa icon={faNotesMedical} class="text-gray-500" size="lg" color={"#0279C2"} />
          </div>
          <div class="flex flex-col h-full justify-center items-start flex-grow">
            <span class="font-poppins text-sm">{personType.name}</span>
            <span class="font-poppins text-xs text-gray-500">{personType.description}</span>
          </div>
        </button>
        {/each}
      </div>
    </div>
  {/if}
</button>