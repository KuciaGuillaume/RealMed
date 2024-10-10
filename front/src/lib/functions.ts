export const conditionToCode = (conditionName: string) => {
  switch (conditionName) {
    case "Bébé":
      return "baby";
    case "Enfant":
      return "child";
    case "Adolescent":
      return "teenager";
    case "Homme adulte":
      return "man_adult";
    case "Femme adulte":
      return "woman_adult";
    case "Femme enceinte":
      return "pregnant_woman";
    case "Homme senior":
      return "senior_man";
    case "Femme senior":
      return "senior_woman";
    default:
      return "";
  }
}

export const codeToCondition = (conditionCode: string) => {
  switch (conditionCode) {
    case "baby":
      return "Bébé";
    case "child":
      return "Enfant";
    case "teenager":
      return "Adolescent";
    case "man_adult":
      return "Homme adulte";
    case "woman_adult":
      return "Femme adulte";
    case "pregnant_woman":
      return "Femme enceinte";
    case "senior_man":
      return "Homme senior";
    case "senior_woman":
      return "Femme senior";
    default:
      return "";
  }
}

export const getAllConditionsAsCode = () => {
  return [
    "baby",
    "child",
    "teenager",
    "man_adult",
    "woman_adult",
    "pregnant_woman",
    "senior_man",
    "senior_woman"
  ];
}

export const allergyToCode = (allergyName: string) => {
  switch (allergyName) {
    case "Pénicilline":
      return "penicilline";
    case "Céphalosporines":
      return "cephalosporines";
    case "Sulfamides":
      return "sulfamides";
    case "Aspirine":
      return "aspirine";
    case "Ibuprofène":
      return "ibuprofene";
    case "Morphine":
      return "morphine";
    case "Codéine":
      return "codeine";
    case "Paracétamol":
      return "paracetamol";
    case "Anticonvulsivants":
      return "anticonvulsivants";
    case "Antibiotiques macrolides":
      return "macrolides";
    case "Antibiotiques quinolones":
      return "quinolones";
    case "Anesthésiques locaux":
      return "anesthesiques_locaux";
    case "Vaccins":
      return "vaccins";
    case "Colorants ou conservateurs":
      return "colorants_conservateurs";
    default:
      return "";
  }
}

export const codeToAllergy = (allergyCode: string) => {
  switch (allergyCode) {
    case "penicilline":
      return "Pénicilline";
    case "cephalosporines":
      return "Céphalosporines";
    case "sulfamides":
      return "Sulfamides";
    case "aspirine":
      return "Aspirine";
    case "ibuprofene":
      return "Ibuprofène";
    case "morphine":
      return "Morphine";
    case "codeine":
      return "Codéine";
    case "paracetamol":
      return "Paracétamol";
    case "anticonvulsivants":
      return "Anticonvulsivants";
    case "macrolides":
      return "Antibiotiques macrolides";
    case "quinolones":
      return "Antibiotiques quinolones";
    case "anesthesiques_locaux":
      return "Anesthésiques locaux";
    case "vaccins":
      return "Vaccins";
    case "colorants_conservateurs":
      return "Colorants ou conservateurs";
    default:
      return "";
  }
}

export const getAllAllergiesAsCode = () => {
  return [
    "penicilline",
    "cephalosporines",
    "sulfamides",
    "aspirine",
    "ibuprofene",
    "morphine",
    "codeine",
    "paracetamol",
    "anticonvulsivants",
    "macrolides",
    "quinolones",
    "anesthesiques_locaux",
    "vaccins",
    "colorants_conservateurs"
  ];
}

export function parseTime(timeStr : string) {
  let timeInMinutes = 0;

  if (!timeStr) return timeInMinutes;

  if (timeStr.includes('-')) {
    // Plage de valeurs
    let parts = timeStr.split('-');
    let minPart = parseFloat(parts[0]);
    let maxPart = parseFloat(parts[1]);
    // Vérifier l'unité
    if (timeStr.includes('h')) {
      // Convertir en minutes
      timeInMinutes = ((minPart + maxPart) / 2) * 60;
    } else {
      timeInMinutes = (minPart + maxPart) / 2;
    }
  } else {
    // Valeur unique
    let value = parseFloat(timeStr);
    if (timeStr.includes('h')) {
      timeInMinutes = value * 60;
    } else {
      timeInMinutes = value;
    }
  }

  return timeInMinutes;
}

export const getScore = (drug : DrugResult) => {
  // 1. Score des effets secondaires
  const totalEffects = drug.secondaryEffectsDetails.length;
  const totalSeverity = drug.secondaryEffectsDetails.reduce(
    (sum, effect) => sum + effect.severity,
    0
  );
  const averageSeverity = totalSeverity / totalEffects;
  
  // Sévérité va de 1 à 3, on inverse pour que moins de sévérité donne un score plus élevé
  const sideEffectsScore = ((3 - averageSeverity) / (3 - 1)) * 100;
  
  // 2. Score du temps d'efficacité
  const efficiencyTimeInMinutes = parseTime(drug.efficiencyTime);
  const minEfficiencyTime = 15; // Basé sur les données fournies
  const maxEfficiencyTime = 60;
  const efficiencyTimeScore = ((maxEfficiencyTime - efficiencyTimeInMinutes) / (maxEfficiencyTime - minEfficiencyTime)) * 100;
  
  // 3. Score de la durée d'action
  const durationTimeInMinutes = parseTime(drug.durationTime);
  const minDurationTime = 180; // 3 heures en minutes
  const maxDurationTime = 480; // 8 heures en minutes
  const durationTimeScore = ((durationTimeInMinutes - minDurationTime) / (maxDurationTime - minDurationTime)) * 100;
  
  // 4. Score du mode d'administration
  let administrationScore = 0;
  if (drug.format === 'Oral') {
    administrationScore = 100;
  } else if (drug.format === 'Rectal') {
    administrationScore = 50;
  } else {
    administrationScore = 70; // Par défaut
  }
  
  // 5. Score de la taille
  let sizeScore = 0;
  if (drug.size === 'Small') {
    sizeScore = 100;
  } else if (drug.size === 'Medium') {
    sizeScore = 70;
  } else if (drug.size === 'Large') {
    sizeScore = 40;
  } else {
    sizeScore = 70; // 'N/A' ou autres
  }
  
  // Pondérations (doivent totaliser 1)
  const weights = {
    sideEffects: 0.4,
    efficiencyTime: 0.2,
    durationTime: 0.1,
    administration: 0.1,
    size: 0.2,
  };
  
  // Calcul du score total
  const totalScore =
    sideEffectsScore * weights.sideEffects +
    efficiencyTimeScore * weights.efficiencyTime +
    durationTimeScore * weights.durationTime +
    administrationScore * weights.administration +
    sizeScore * weights.size;
  
  return Number(totalScore.toFixed(0));
};