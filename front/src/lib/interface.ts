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
  size: string;
  specificCondition: string[];
  secondaryEffectsDetails: {
    name: string;
    severity: number;
  }[],
  imageLink: string;
  shortDescription: string;
  usage: string;
}