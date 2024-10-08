<script>
  import NavBar from "$lib/components/NavBar.svelte";
  import "../app.css";
  import Footer from "$lib/components/Footer.svelte";
</script>

<div class="flex flex-col w-full">
  <NavBar />
  <slot />
  <Footer />
</div>
