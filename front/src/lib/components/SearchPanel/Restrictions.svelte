<script lang="ts">
  import { tick } from 'svelte';
  import Fa from 'svelte-fa';
  import { faBug, faNotesMedical, faPerson, faSearch, faUser, faUserGroup, faX } from '@fortawesome/free-solid-svg-icons';
  import { fly } from 'svelte/transition';

  let isSelected = false;
  export let query = "";

  const allergies = [
    {
      name: "Pénicilline",
      description: "Allergie aux antibiotiques de la famille des pénicillines."
    },
    {
      name: "Céphalosporines",
      description: "Allergie aux antibiotiques apparentés à la pénicilline."
    },
    {
      name: "Sulfamides",
      description: "Allergie aux médicaments sulfonamides, utilisés dans divers traitements (infections, inflammations)."
    },
    {
      name: "Aspirine",
      description: "Allergie aux anti-inflammatoires non stéroïdiens (AINS) comme l'aspirine."
    },
    {
      name: "Ibuprofène",
      description: "Allergie aux anti-inflammatoires non stéroïdiens (AINS), autre que l'aspirine."
    },
    {
      name: "Morphine",
      description: "Allergie aux opioïdes, utilisés pour soulager la douleur intense."
    },
    {
      name: "Codéine",
      description: "Allergie aux opioïdes légers, présents dans certains médicaments contre la toux et la douleur."
    },
    {
      name: "Paracétamol",
      description: "Réaction allergique ou intolérance au paracétamol, utilisé comme analgésique et antipyrétique."
    },
    {
      name: "Anticonvulsivants",
      description: "Allergie aux médicaments utilisés pour traiter l'épilepsie, comme la carbamazépine ou la phénytoïne."
    },
    {
      name: "Antibiotiques macrolides",
      description: "Allergie aux antibiotiques tels que l'érythromycine, la clarithromycine ou l'azithromycine."
    },
    {
      name: "Antibiotiques quinolones",
      description: "Allergie aux antibiotiques comme la ciprofloxacine ou la lévofloxacine."
    },
    {
      name: "Anesthésiques locaux",
      description: "Allergie aux anesthésiques locaux comme la lidocaïne ou la procaïne."
    },
    {
      name: "Vaccins",
      description: "Allergie à certains composants des vaccins, comme l'œuf ou le latex dans les seringues."
    },
    {
      name: "Colorants ou conservateurs",
      description: "Allergie à certains additifs présents dans des médicaments, comme les colorants alimentaires ou les conservateurs."
    }
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
  class="relative flex flex-row h-full w-[15rem] rounded-lg duration-200 {isSelected ? 'border-cblue border-2' : 'hover:bg-gray-100 border-2 border-transparent'} cursor-default">
  <div class="flex items-center justify-center h-full aspect-square">
    <Fa icon={faBug} class="text-gray-500" size="lg" color="black" />
  </div>
  <div class="flex flex-col h-full justify-center items-start flex-grow">
    <span class="font-poppins text-xs text-gray-500 text-left">Allergie</span>
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
        {#each allergies as allergie}
        <button
          on:click={() => query=allergie.name} 
          class="flex flex-row w-full min-h-14 items-center justify-start p-2 px-4 hover:bg-gray-100 rounded-xl cursor-pointer gap-4">
          <div class="flex items-center justify-center h-full aspect-square">
            <Fa icon={faBug} class="text-gray-500" size="lg" color={"#0279C2"} />
          </div>
          <div class="flex flex-col h-full justify-center items-start flex-grow">
            <span class="font-poppins text-sm">{allergie.name}</span>
            <span class="font-poppins text-xs text-gray-500 text-left">{allergie.description}</span>
          </div>
        </button>
        {/each}
      </div>
    </div>
  {/if}
</button>