<script lang="ts">
  import { page } from "$app/stores";
  import DrugComparator from "$lib/components/DrugComparator/DrugComparator.svelte";
  import NewsFeed from "$lib/components/NewsFeed/NewsFeed.svelte";
  import FaqContainer from "$lib/components/Faq/FaqContainer.svelte";
  import SearchPanel from "$lib/components/SearchPanel/SearchPanel.svelte";

  $: drug = $page.url.searchParams.get("drug");
  $: condition = $page.url.searchParams.get("condition");
  $: allergie = $page.url.searchParams.get("allergie");

  $: isSearched = drug || condition || allergie ? true : false;
</script>

<SearchPanel {drug} {condition} {allergie} />
{#if !isSearched}
  <NewsFeed />
  <FaqContainer />
{:else}
  <DrugComparator />
{/if}