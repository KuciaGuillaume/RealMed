<script lang="ts">
  import { page } from "$app/stores";
  import DrugComparator from "$lib/components/DrugComparator/DrugComparator.svelte";
  import NewsFeed from "$lib/components/NewsFeed/NewsFeed.svelte";
  import FaqContainer from "$lib/components/Faq/FaqContainer.svelte";
  import SearchPanel from "$lib/components/SearchPanel/SearchPanel.svelte";
  import Footer from "$lib/components/Footer.svelte";
  import { fly } from "svelte/transition";

  $: drug = $page.url.searchParams.get("drug");
  $: condition = $page.url.searchParams.get("condition");
  $: allergie = $page.url.searchParams.get("allergie");
  $: isSearched = drug || condition || allergie ? true : false;

  $: largePanel = false;
</script>

<div class="flex flex-col w-full" in:fly={{ duration: 1000, y: 100, delay: 200 }}>
  <SearchPanel {drug} {condition} {allergie} bind:largePanel />
  {#if !isSearched}
    <NewsFeed />
    <FaqContainer />
    <Footer />
  {:else}
    <DrugComparator bind:largePanel />
  {/if}
</div>