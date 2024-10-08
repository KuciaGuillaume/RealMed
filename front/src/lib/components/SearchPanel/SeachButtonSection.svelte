<script lang="ts">
  import { tick } from 'svelte';
  import Fa from 'svelte-fa';
  import { faNotesMedical, faSearch, faX } from '@fortawesome/free-solid-svg-icons';
  import { fly } from 'svelte/transition';

  let isSelected = false;
  let inputEl: HTMLInputElement | null = null;
  let query = '';

  const medics = [
    {
      name: "Doliprane",
      description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
    },
    {
      name: "Ibuprofène",
      description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
    },
    {
      name: "Paracétamol",
      description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
    },
    {
      name: "Aspirine",
      description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
    },
    {
      name: "Efferalgan",
      description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
    },
    {
      name: "Spasfon",
      description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
    },
    {
      name: "Dafalgan",
      description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
    },
    {
      name: "Advil",
      description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
    }
  ]

  const handleClick = async () => {
    isSelected = !isSelected;

    if (isSelected) {
      await tick();
      inputEl?.focus();
    }
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
  class="flex flex-row h-full w-[15rem] rounded-lg duration-200 {isSelected ? 'border-cblue border-2' : 'hover:bg-gray-100 border-2 border-transparent'} cursor-text">
  <div class="flex items-center justify-center h-full aspect-square">
    <Fa icon={faSearch} class="text-gray-500" size="lg" color="black" />
  </div>
  <div class="flex flex-col h-full justify-center items-start flex-grow">
    <span class="font-poppins text-xs text-gray-500">Médicament</span>
    {#if !isSelected}
      <span class="font-poppins text-sm">{query == "" ? "Doliprane" : query}</span>
    {:else}
      <input
        bind:this={inputEl}
        bind:value={query}
        placeholder="Que cherchez-vous ?"
        class="font-poppins text-sm w-full outline-none bg-transparent"
      />
    {/if}
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
        {#each medics as medic}
          {#if query == "" || medic.name.toLowerCase().includes(query.toLowerCase())}
          <button
            on:click={() => query=medic.name} 
            class="flex flex-row w-full min-h-14 items-center justify-start p-2 px-4 hover:bg-gray-100 rounded-xl cursor-pointer gap-4">
            <div class="flex items-center justify-center h-full aspect-square">
              <Fa icon={faNotesMedical} class="text-gray-500" size="lg" color={"#0279C2"} />
            </div>
            <div class="flex flex-col h-full justify-center items-start flex-grow">
              <span class="font-poppins text-sm">{medic.name}</span>
              <span class="font-poppins text-xs text-gray-500">{medic.description}</span>
            </div>
          </button>
          {/if}
        {/each}
      </div>
    </div>
  {/if}
</button>