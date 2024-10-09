<script>
  import NavBar from "$lib/components/NavBar.svelte";
  import "../app.css";
  import { page } from "$app/stores";
</script>

<div class="flex flex-col w-full">
  {#if $page.url.pathname !== "/signin" && $page.url.pathname !== "/register" && $page.url.pathname != "/login"}
    <NavBar />
  {/if}
  <slot />
</div>