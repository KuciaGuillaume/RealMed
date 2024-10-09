export type GetAllUsers = {
    readonly "input": GetAllUsers$input;
    readonly "result": GetAllUsers$result | undefined;
};

export type GetAllUsers$result = {
    /**
     * fetch data from the table: "users"
    */
    readonly users: ({
        readonly uuid: any;
        readonly email: string | null;
        readonly created_at: any;
    })[];
};

export type GetAllUsers$input = null;

export type GetAllUsers$artifact = {
    "name": "GetAllUsers";
    "kind": "HoudiniQuery";
    "hash": "858fe25de70484361806df79024a8b770026dd0b39c32041d54983a0025670a3";
    "raw": `query GetAllUsers {
  users {
    uuid
    email
    created_at
  }
}
`;
    "rootType": "query_root";
    "stripVariables": [];
    "selection": {
        "fields": {
            "users": {
                "type": "users";
                "keyRaw": "users";
                "selection": {
                    "fields": {
                        "uuid": {
                            "type": "uuid";
                            "keyRaw": "uuid";
                            "visible": true;
                        };
                        "email": {
                            "type": "String";
                            "keyRaw": "email";
                            "nullable": true;
                            "visible": true;
                        };
                        "created_at": {
                            "type": "timestamptz";
                            "keyRaw": "created_at";
                            "visible": true;
                        };
                    };
                };
                "visible": true;
            };
        };
    };
    "pluginData": {
        "houdini-svelte": {};
    };
    "policy": "CacheOrNetwork";
    "partial": false;
};