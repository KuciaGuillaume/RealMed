import type { Record } from "./public/record";
import { GetAllUsers$result, GetAllUsers$input } from "../artifacts/GetAllUsers";
import { GetAllUsersStore } from "../plugins/houdini-svelte/stores/GetAllUsers";
import type { order_by } from "$houdini/graphql/enums";
import type { ValueOf } from "$houdini/runtime/lib/types";
import type { users_select_column } from "$houdini/graphql/enums";

type users_order_by = {
    created_at?: ValueOf<typeof order_by> | null | undefined;
    email?: ValueOf<typeof order_by> | null | undefined;
    hashed_password?: ValueOf<typeof order_by> | null | undefined;
    uuid?: ValueOf<typeof order_by> | null | undefined;
};

type timestamptz_comparison_exp = {
    _eq?: any | null | undefined;
    _gt?: any | null | undefined;
    _gte?: any | null | undefined;
    _in?: (any)[] | null | undefined;
    _is_null?: boolean | null | undefined;
    _lt?: any | null | undefined;
    _lte?: any | null | undefined;
    _neq?: any | null | undefined;
    _nin?: (any)[] | null | undefined;
};

type String_comparison_exp = {
    _eq?: string | null | undefined;
    _gt?: string | null | undefined;
    _gte?: string | null | undefined;
    _ilike?: string | null | undefined;
    _in?: (string)[] | null | undefined;
    _iregex?: string | null | undefined;
    _is_null?: boolean | null | undefined;
    _like?: string | null | undefined;
    _lt?: string | null | undefined;
    _lte?: string | null | undefined;
    _neq?: string | null | undefined;
    _nilike?: string | null | undefined;
    _nin?: (string)[] | null | undefined;
    _niregex?: string | null | undefined;
    _nlike?: string | null | undefined;
    _nregex?: string | null | undefined;
    _nsimilar?: string | null | undefined;
    _regex?: string | null | undefined;
    _similar?: string | null | undefined;
};

type uuid_comparison_exp = {
    _eq?: any | null | undefined;
    _gt?: any | null | undefined;
    _gte?: any | null | undefined;
    _in?: (any)[] | null | undefined;
    _is_null?: boolean | null | undefined;
    _lt?: any | null | undefined;
    _lte?: any | null | undefined;
    _neq?: any | null | undefined;
    _nin?: (any)[] | null | undefined;
};

type users_bool_exp = {
    _and?: (users_bool_exp)[] | null | undefined;
    _not?: users_bool_exp | null | undefined;
    _or?: (users_bool_exp)[] | null | undefined;
    created_at?: timestamptz_comparison_exp | null | undefined;
    email?: String_comparison_exp | null | undefined;
    hashed_password?: String_comparison_exp | null | undefined;
    uuid?: uuid_comparison_exp | null | undefined;
};

export declare type CacheTypeDef = {
    types: {
        __ROOT__: {
            idFields: {};
            fields: {
                users: {
                    type: (Record<CacheTypeDef, "users">)[];
                    args: {
                        distinct_on?: (ValueOf<typeof users_select_column>)[] | null | undefined;
                        limit?: number | null | undefined;
                        offset?: number | null | undefined;
                        order_by?: (users_order_by)[] | null | undefined;
                        where?: users_bool_exp | null | undefined;
                    };
                };
                users_aggregate: {
                    type: Record<CacheTypeDef, "users_aggregate">;
                    args: {
                        distinct_on?: (ValueOf<typeof users_select_column>)[] | null | undefined;
                        limit?: number | null | undefined;
                        offset?: number | null | undefined;
                        order_by?: (users_order_by)[] | null | undefined;
                        where?: users_bool_exp | null | undefined;
                    };
                };
                users_by_pk: {
                    type: Record<CacheTypeDef, "users"> | null;
                    args: {
                        uuid: any;
                    };
                };
            };
            fragments: [];
        };
        users: {
            idFields: never;
            fields: {
                created_at: {
                    type: any;
                    args: never;
                };
                email: {
                    type: string | null;
                    args: never;
                };
                hashed_password: {
                    type: string | null;
                    args: never;
                };
                uuid: {
                    type: any;
                    args: never;
                };
            };
            fragments: [];
        };
        users_aggregate: {
            idFields: never;
            fields: {
                aggregate: {
                    type: Record<CacheTypeDef, "users_aggregate_fields"> | null;
                    args: never;
                };
                nodes: {
                    type: (Record<CacheTypeDef, "users">)[];
                    args: never;
                };
            };
            fragments: [];
        };
        users_aggregate_fields: {
            idFields: never;
            fields: {
                count: {
                    type: number;
                    args: {
                        columns?: (ValueOf<typeof users_select_column>)[] | null | undefined;
                        distinct?: boolean | null | undefined;
                    };
                };
                max: {
                    type: Record<CacheTypeDef, "users_max_fields"> | null;
                    args: never;
                };
                min: {
                    type: Record<CacheTypeDef, "users_min_fields"> | null;
                    args: never;
                };
            };
            fragments: [];
        };
        users_max_fields: {
            idFields: never;
            fields: {
                created_at: {
                    type: any | null;
                    args: never;
                };
                email: {
                    type: string | null;
                    args: never;
                };
                hashed_password: {
                    type: string | null;
                    args: never;
                };
                uuid: {
                    type: any | null;
                    args: never;
                };
            };
            fragments: [];
        };
        users_min_fields: {
            idFields: never;
            fields: {
                created_at: {
                    type: any | null;
                    args: never;
                };
                email: {
                    type: string | null;
                    args: never;
                };
                hashed_password: {
                    type: string | null;
                    args: never;
                };
                uuid: {
                    type: any | null;
                    args: never;
                };
            };
            fragments: [];
        };
        users_mutation_response: {
            idFields: never;
            fields: {
                affected_rows: {
                    type: number;
                    args: never;
                };
                returning: {
                    type: (Record<CacheTypeDef, "users">)[];
                    args: never;
                };
            };
            fragments: [];
        };
    };
    lists: {};
    queries: [[GetAllUsersStore, GetAllUsers$result, GetAllUsers$input]];
};