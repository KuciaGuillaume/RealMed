import { type Writable, writable } from "svelte/store"

export const registerEmailStore : Writable<string | null> = writable(null);
export const selectedDrugStore : Writable<string | null> = writable(null);
export const isLoggerStore : Writable<'fetching' | 'logged' | 'notlogged'> = writable('fetching');