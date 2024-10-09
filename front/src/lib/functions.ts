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