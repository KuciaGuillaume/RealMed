export default {
    "name": "GetAllUsers",
    "kind": "HoudiniQuery",
    "hash": "858fe25de70484361806df79024a8b770026dd0b39c32041d54983a0025670a3",

    "raw": `query GetAllUsers {
  users {
    uuid
    email
    created_at
  }
}
`,

    "rootType": "query_root",
    "stripVariables": [],

    "selection": {
        "fields": {
            "users": {
                "type": "users",
                "keyRaw": "users",

                "selection": {
                    "fields": {
                        "uuid": {
                            "type": "uuid",
                            "keyRaw": "uuid",
                            "visible": true
                        },

                        "email": {
                            "type": "String",
                            "keyRaw": "email",
                            "nullable": true,
                            "visible": true
                        },

                        "created_at": {
                            "type": "timestamptz",
                            "keyRaw": "created_at",
                            "visible": true
                        }
                    }
                },

                "visible": true
            }
        }
    },

    "pluginData": {
        "houdini-svelte": {}
    },

    "policy": "CacheOrNetwork",
    "partial": false
};

"HoudiniHash=ba8cf4881cbff0ffd45005b31999dbfbe9bef0fb5d4f611a328088e1bc4a079e";