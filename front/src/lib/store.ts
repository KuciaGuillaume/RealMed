import { type Writable, writable } from "svelte/store"

export const registerEmailStore : Writable<string | null> = writable(null);