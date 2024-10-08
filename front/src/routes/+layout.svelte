<script>
  import NavBar from "$lib/components/NavBar.svelte";
  import "../app.css";
</script>

<div class="flex flex-col w-screen">
  <NavBar />
  <slot />
</div>