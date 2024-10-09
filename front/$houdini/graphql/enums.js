/** ordering argument of a cursor */
export const cursor_ordering = {
    /**
     * ascending ordering of the cursor
    */
    "ASC": "ASC",

    /**
     * descending ordering of the cursor
    */
    "DESC": "DESC"
};

/** column ordering options */
export const order_by = {
    /**
     * in ascending order, nulls last
    */
    "asc": "asc",

    /**
     * in ascending order, nulls first
    */
    "asc_nulls_first": "asc_nulls_first",

    /**
     * in ascending order, nulls last
    */
    "asc_nulls_last": "asc_nulls_last",

    /**
     * in descending order, nulls first
    */
    "desc": "desc",

    /**
     * in descending order, nulls first
    */
    "desc_nulls_first": "desc_nulls_first",

    /**
     * in descending order, nulls last
    */
    "desc_nulls_last": "desc_nulls_last"
};

/** unique or primary key constraints on table "users" */
export const users_constraint = {
    /**
     * unique or primary key constraint on columns "uuid"
    */
    "users_pkey": "users_pkey"
};

/** select columns of table "users" */
export const users_select_column = {
    /**
     * column name
    */
    "created_at": "created_at",

    /**
     * column name
    */
    "email": "email",

    /**
     * column name
    */
    "hashed_password": "hashed_password",

    /**
     * column name
    */
    "uuid": "uuid"
};

/** update columns of table "users" */
export const users_update_column = {
    /**
     * column name
    */
    "created_at": "created_at",

    /**
     * column name
    */
    "email": "email",

    /**
     * column name
    */
    "hashed_password": "hashed_password",

    /**
     * column name
    */
    "uuid": "uuid"
};