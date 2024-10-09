import { GetAllUsersStore } from "../plugins/houdini-svelte/stores/GetAllUsers";
import type { Cache as InternalCache } from "./cache/cache";
import type { CacheTypeDef } from "./generated";
import { Cache } from "./public";
export * from "./client";
export * from "./lib";

export function graphql(
    str: "query GetAllUsers {\n  users {\n    uuid\n    email\n    created_at\n  }\n}"
): GetAllUsersStore;

export declare function graphql<_Payload, _Result = _Payload>(str: TemplateStringsArray): _Result;
export declare const cache: Cache<CacheTypeDef>;
export declare function getCache(): InternalCache;