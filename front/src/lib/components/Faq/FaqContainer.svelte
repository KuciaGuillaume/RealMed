<script lang="ts">
  import { slide } from "svelte/transition";
  import Fa from "svelte-fa";
  import { faChevronDown } from "@fortawesome/free-solid-svg-icons";

  let openQuestion = 0;

  const faqs = [
    {
      question: "1. Comment fonctionne le score de recommandation des médicaments ?",
      answer:
        "Le score de recommandation est basé sur une combinaison de facteurs, y compris votre profil de santé, les interactions possibles avec d'autres médicaments, les effets secondaires, et les avis de professionnels de santé. Cela permet de vous indiquer si un médicament est potentiellement adapté à votre situation.",
    },
    {
      question: "2. Puis-je utiliser ce site pour remplacer un avis médical ?",
      answer:
        "Non, notre site fournit des informations à titre informatif seulement. Vous devez toujours consulter un professionnel de la santé avant de commencer ou d'arrêter tout médicament.",
    },
    {
      question: "3. Comment vérifier les interactions entre plusieurs médicaments ?",
      answer:
        'Vous pouvez utiliser notre outil "Interactions Médicamenteuses" en entrant les noms des médicaments que vous prenez. Cela vous aidera à identifier les interactions possibles entre vos traitements.',
    },
    {
      question: "4. Les informations sur les médicaments sont-elles mises à jour ?",
      answer:
        "Oui, nous nous assurons de mettre à jour les informations régulièrement en nous basant sur les dernières recherches scientifiques et les mises à jour des organismes de santé.",
    },
    {
      question: "5. Est-ce que ce service est disponible dans plusieurs langues ?",
      answer:
        "Actuellement, notre site est disponible en plusieurs langues. Vous pouvez changer la langue dans les paramètres du site pour vous faciliter l'accès aux informations.",
    },
  ];

  const toggleQuestion = (index: any) => {
    openQuestion = openQuestion === index ? null : index;
  };
</script>

<div class="flex z-0 w-full justify-center flex-col">
  <div class="flex z-10 max-w-[60rem] w-full p-10 gap-4 h-fit">
    <h2 class="font-poppins text-xl text-cblueHover font-semibold">Foire aux Questions (FAQ)</h2>
  </div>

  <div class="flex justify-spacebetween">
    <div class="w-full max-w-[50%] pb-10 px-10">
      {#each faqs as faq, index}
        <div class="py-4 border-b">
          <button
            class="font-poppins text-lg text-cblue font-semibold flex items-start justify-between w-full focus:outline-none"
            on:click={() => toggleQuestion(index)}
          >
            <p class="font-poppins text-base">{faq.question}</p>
            <Fa icon={faChevronDown} class={`ml-2 ${openQuestion === index ? "rotate-180" : ""}`} />
          </button>
          {#if openQuestion === index}
            <p transition:slide class="font-poppins text-sm text-gray-700 mt-2 pr-10">
              {faq.answer}
            </p>
          {/if}
        </div>
      {/each}
    </div>
    <div class="w-full max-w-[50%] pb-10 px-10">
      <img src="/faq_illustration.png" alt="faq_illustration" class="w-[600px] aspect-auto" />
    </div>
  </div>
</div>
