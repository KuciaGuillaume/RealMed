<script lang="ts">
  import { page } from "$app/stores";
  import DrugComparator from "$lib/components/DrugComparator/DrugComparator.svelte";
  import NewsFeed from "$lib/components/NewsFeed/NewsFeed.svelte";
  import FaqContainer from "$lib/components/Faq/FaqContainer.svelte";
  import SearchPanel from "$lib/components/SearchPanel/SearchPanel.svelte";
  import Footer from "$lib/components/Footer.svelte";
  import { fly } from "svelte/transition";
  import Spinner from "$lib/components/Spinner.svelte";

  $: drug = $page.url.searchParams.get("drug");
  $: condition = $page.url.searchParams.get("condition");
  $: allergie = $page.url.searchParams.get("allergie");
  $: isSearched = drug || condition || allergie ? true : false;
  $: isLargePanel = false;
  
  let drugData : DrugResult[] | null = null;
  let innerHeight : number = 0;

</script>

<svelte:window bind:innerHeight />

{#if innerHeight != 0}
  <div class="flex flex-col w-full" in:fly={{ duration: 1000, y: 100, delay: 200 }}>
    <SearchPanel bind:isSearched bind:drugData bind:isLargePanel />
    {#if !isSearched}
      <NewsFeed />
      <FaqContainer />
      <Footer />
    {:else if drugData != null}
      <DrugComparator bind:isLargePanel bind:drugData {isSearched} />
    {:else}
      <div 
        style="{isLargePanel ? `height: calc(${innerHeight}px - 64px)` : `height: calc(${innerHeight}px - 224px)`}"
        class="flex flex-col items-center justify-center">
        <Spinner size="size-10" />
      </div>
    {/if}
  </div>
{/if}