import { QueryStore } from '../runtime/stores/query'
import artifact from '$houdini/artifacts/GetAllUsers'
import { initClient } from '$houdini/plugins/houdini-svelte/runtime/client'

export class GetAllUsersStore extends QueryStore {
	constructor() {
		super({
			artifact,
			storeName: "GetAllUsersStore",
			variables: false,
		})
	}
}

export async function load_GetAllUsers(params) {
	await initClient()

	const store = new GetAllUsersStore()

	await store.fetch(params)

	return {
		GetAllUsers: store,
	}
}
