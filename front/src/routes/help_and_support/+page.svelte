<script lang="ts">
  import { Fa } from "svelte-fa";
  import { faChevronLeft } from "@fortawesome/free-solid-svg-icons";
  import { fly } from "svelte/transition";

  let profile = {
    name: "Nom Prénom",
    email: "admail@mail.com",
    birthdate: "01/01/2000",
    phone: "06 12 34 56 78",
  };

  let favorites = [
    {
      name: "Nom du médicament",
      description: "Description du médicament",
      img: "https://via.placeholder.com/100",
    },
    {
      name: "Nom du médicament",
      description: "Description du médicament",
      img: "https://via.placeholder.com/100",
    },
    {
      name: "Nom du médicament",
      description: "Description du médicament",
      img: "https://via.placeholder.com/100",
    },
  ];
</script>

<div class="flex z-0 w-full justify-center">
  <div class="flex flex-row w-full px-10 py-4 overflow-y-auto max-w-[70rem] pt-10 gap-8">
    <div class="w-[25%] h-fit flex flex-col gap-2">
      <a href="/" class="font-poppins text-cblue flex items-center flex-row gap-2 text-sm mb-2">
        <Fa icon={faChevronLeft} color={"rgb(2 121 194)"} />
        Back
      </a>
      <a 
        class="w-full h-12 rounded-xl hover:bg-gray-200 duration-200 flex items-center p-4 text-sm text-black/40 hover:text-black"
        href="/favoris">
        Favoris
      </a>
      <a 
        class="w-full h-12 rounded-xl hover:bg-gray-200 duration-200 flex items-center p-4 text-sm flex-row gap-2"
        href="/help_and_support">
        <div class="w-1 h-full bg-gray-700">

        </div>
        Aide et support
      </a>
    </div>
    <div 
      in:fly={{ duration: 200, y: 10 }}
      class="w-[75%] flex flex-col gap-4">
      <h1 class="font-poppins text-3xl font-semibold">
        Aide et support
      </h1>
      <span class="font-poppins text-sm text-gray-400 flex flex-col gap-4">
        <p>
          Vous avez des questions sur un médicament ou besoin de plus d'informations ? Consultez notre <a href="#" class="text-blue-500 hover:underline">FAQ</a> ou contactez notre équipe via notre <a href="#" class="text-blue-500 hover:underline">formulaire de contact</a>. Nous sommes là pour vous fournir un soutien personnalisé.
        </p>
        <p>
          Nos <a href="#" class="text-blue-500 hover:underline">guides pratiques</a> vous expliquent en détail comment utiliser correctement les médicaments en respectant les recommandations médicales. Que ce soit pour les <a href="#" class="text-blue-500 hover:underline">posologies</a>, les <a href="#" class="text-blue-500 hover:underline">interactions</a> possibles ou les <a href="#" class="text-blue-500 hover:underline">précautions</a> à prendre, nous sommes là pour vous accompagner.
        </p>
        <p>
          Si vous rencontrez des problèmes techniques avec notre site (lenteur, difficultés de navigation, etc.), veuillez consulter notre <a href="#" class="text-blue-500 hover:underline">page d'assistance technique</a> ou nous envoyer un email à <a href="mailto:support@exemple.com" class="text-blue-500 hover:underline">support@exemple.com</a>. Nous vous aiderons à résoudre le problème le plus rapidement possible.
        </p>
        <p>
          Vous trouverez également des informations sur la <a href="#" class="text-blue-500 hover:underline">gestion des allergies</a>, les <a href="#" class="text-blue-500 hover:underline">contre-indications</a> et les meilleures pratiques pour minimiser les risques liés à la prise de médicaments. Notre objectif est de vous fournir toutes les informations nécessaires pour une utilisation en toute sécurité.
        </p>
        <p>
          En cas de doute ou de question concernant votre traitement, nous vous encourageons à toujours consulter votre <a href="#" class="text-blue-500 hover:underline">médecin</a> ou <a href="#" class="text-blue-500 hover:underline">pharmacien</a>. Nos informations sont mises à jour régulièrement pour refléter les dernières recommandations médicales.
        </p>
        <p>
          Si vous souhaitez en savoir plus sur un médicament particulier, explorez notre <a href="#" class="text-blue-500 hover:underline">moteur de recherche</a> ou parcourez les <a href="#" class="text-blue-500 hover:underline">catégories</a> pour trouver rapidement les informations dont vous avez besoin. Nous sommes engagés à rendre la santé accessible et compréhensible pour tous.
        </p>
        <p>
          Pour toute autre question ou assistance, n'hésitez pas à nous contacter directement via notre <a href="#" class="text-blue-500 hover:underline">service client</a> disponible du lundi au vendredi de 9h à 18h.
        </p>
      </span>
    </div>
  </div>
</div>
