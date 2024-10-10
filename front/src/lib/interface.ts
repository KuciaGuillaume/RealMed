interface DrugResult {
  name: string;
  administration: string;
  aspect: string;
  color: string;
  commonAffliction: string;
  conditioning: string[];
  dosage: string;
  durationTime: string;
  efficiencyTime: string;
  format: string;
  molecule: string;
  secondaryEffects: string;
  secondaryEffectsDetails: {
    name: string;
    severity: number;
  }[];
  size: string;
  specificCondition: string[];
  imageLink: string;
  shortDescription: string;
  usage: string;
  isFavorite: boolean;
}