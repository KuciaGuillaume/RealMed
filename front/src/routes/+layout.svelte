<script>
  import NavBar from "$lib/components/NavBar.svelte";
  import "../app.css";
  import { page } from "$app/stores";
  import { onMount } from "svelte";
  import { isLoggerStore } from "$lib/store";

  onMount(async () => {
    const res = await fetch("/api/check", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });
    if (res.ok) {
      isLoggerStore.set(true);
    } else {
      isLoggerStore.set(false);
    }
    console.log($isLoggerStore);
  });

</script>

<div class="flex flex-col w-full">
  {#if $page.url.pathname !== "/signin" && $page.url.pathname !== "/register" && $page.url.pathname != "/login"}
    <NavBar />
  {/if}
  <slot />
</div>