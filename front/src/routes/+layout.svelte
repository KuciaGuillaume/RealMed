<script>
  import NavBar from "$lib/components/NavBar.svelte";
  import "../app.css";
</script>

<div class="flex flex-col w-full">
  <NavBar />
  <slot />
</div>
