
type ValuesOf<T> = T[keyof T]
	
/** ordering argument of a cursor */
export declare const cursor_ordering: {
    /** ascending ordering of the cursor */
    readonly ASC: "ASC";
    /** descending ordering of the cursor */
    readonly DESC: "DESC";
}

/** ordering argument of a cursor */
export type cursor_ordering$options = ValuesOf<typeof cursor_ordering>
 
/** column ordering options */
export declare const order_by: {
    /** in ascending order, nulls last */
    readonly asc: "asc";
    /** in ascending order, nulls first */
    readonly asc_nulls_first: "asc_nulls_first";
    /** in ascending order, nulls last */
    readonly asc_nulls_last: "asc_nulls_last";
    /** in descending order, nulls first */
    readonly desc: "desc";
    /** in descending order, nulls first */
    readonly desc_nulls_first: "desc_nulls_first";
    /** in descending order, nulls last */
    readonly desc_nulls_last: "desc_nulls_last";
}

/** column ordering options */
export type order_by$options = ValuesOf<typeof order_by>
 
/** unique or primary key constraints on table "users" */
export declare const users_constraint: {
    /** unique or primary key constraint on columns "uuid" */
    readonly users_pkey: "users_pkey";
}

/** unique or primary key constraints on table "users" */
export type users_constraint$options = ValuesOf<typeof users_constraint>
 
/** select columns of table "users" */
export declare const users_select_column: {
    /** column name */
    readonly created_at: "created_at";
    /** column name */
    readonly email: "email";
    /** column name */
    readonly hashed_password: "hashed_password";
    /** column name */
    readonly uuid: "uuid";
}

/** select columns of table "users" */
export type users_select_column$options = ValuesOf<typeof users_select_column>
 
/** update columns of table "users" */
export declare const users_update_column: {
    /** column name */
    readonly created_at: "created_at";
    /** column name */
    readonly email: "email";
    /** column name */
    readonly hashed_password: "hashed_password";
    /** column name */
    readonly uuid: "uuid";
}

/** update columns of table "users" */
export type users_update_column$options = ValuesOf<typeof users_update_column>
 