<script lang="ts">
  import { goto } from "$app/navigation";
  import { fly, slide } from "svelte/transition";
  import PersonSpecificity from "./PersonSpecificity.svelte";
  import Restrictions from "./Restrictions.svelte";
  import SeachButtonSection from "./SeachButtonSection.svelte";
  import SearchButton from "./SearchButton.svelte";
  import Separator from "./Separator.svelte";
  import Fa from "svelte-fa";
  import { faArrowLeft } from "@fortawesome/free-solid-svg-icons";
  import { onMount } from "svelte";

  let selectedDrug = "Doliprane";
  let selectedCondition = "";
  let selectedAllergie = "";

  export let drug : string | null;
  export let condition : string | null;
  export let allergie : string | null;
  export let largePanel = false;

  let isFetching = false;
  let isMounted = false;

  $: isSearched = (drug || condition || allergie) ? true : false;

  const handleSearch = () => {
    isFetching = true;
    setTimeout(() => {
      const params = new URLSearchParams();
  
      if (selectedDrug) {
        params.append('drug', selectedDrug);
      }
      if (selectedCondition) {
        params.append('condition', selectedCondition);
      }
      if (selectedAllergie) { 
        params.append('allergie', selectedAllergie);
      }
  
      if (params.toString() === '') {
        params.append('drug', 'Doliprane');
      }
  
      goto(`?${params.toString()}`);
      isFetching = false;
    }, 1500);
  }

  const handleLargePanel = () => {
    largePanel = !largePanel;
  }

  onMount(() => {
    isMounted = true;
  });

</script>

<div class="relative flex justify-center w-full duration-200  {isSearched ? largePanel ? 'h-0' : 'h-40 bg-white border-b' : 'h-96 bg-cgray'}">
  <div class="flex z-0 absolute right-0 bottom-0">
    <img src="/search_illustration.png" alt="search_illustration" class="{isSearched ? largePanel ? 'h-0' : 'h-40' : 'h-96'} duration-200 aspect-auto">
  </div>
  <div class="flex z-10 flex-col max-w-[60rem] w-full p-10">
    {#if !isSearched}
      <div out:slide={{ duration: 300 }} in:slide={{ duration: 300 }} class="flex flex-col gap-2">
        <h2 class="font-poppins text-3xl font-semibold"> Découvrez les médicaments que vous prenez au quotidien.  </h2>
        <h3 class="font-poppins text-black/70"> Analysez les compositions et prenez soin de votre bien-être. </h3>
      </div>
    {/if}
    {#if isMounted && (!largePanel || !isSearched)}
      <div 
        in:fly={{ duration: 300, y: -10 }} class="flex flex-row gap-4">
        {#if isSearched}
          <div class="flex flex-row min-w-[4rem] min-h-[4rem] bg-white rounded-xl shadow-md border relative gap-2 z-10 duration-200">
            <button 
              on:click={() => goto('/')}
              class="size-full flex items-center justify-center hover:bg-gray-50 rounded-xl duration-200">
              <Fa icon={faArrowLeft} />
            </button>
          </div>
        {/if}
        <div
          in:fly={{ duration: 300, y: -10 }}
          class="flex flex-row w-full h-[4rem] bg-white rounded-xl shadow-md p-1 border relative gap-2 z-10 {isSearched ? '': 'mt-6'} duration-200">
          <SeachButtonSection bind:query={selectedDrug} />
          <Separator />
          <PersonSpecificity bind:query={selectedCondition} />
          <Separator />
          <Restrictions bind:query={selectedAllergie} />
          <SearchButton on:click={handleSearch} bind:isFetching />
        </div>
      </div>
    {/if}
  </div>
  {#if isSearched}
    <button 
      on:click={handleLargePanel} 
      class="absolute w-20 flex z-30 items-center justify-center h-5 border rounded-lg  bg-white top-full -translate-y-1/2">
      <Fa icon={faArrowLeft} class="flex z-0 {largePanel ? '-rotate-90' : 'rotate-90'} cursor-pointer duration-200" size="xs" />
    </button>
  {/if}
</div>