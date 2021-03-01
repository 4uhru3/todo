Todo project
----------------------------------------------------
- **POST create**
  
    endpoint: `{{base_url}}/api/task/create`

    Request:
    _Body_ raw (json)
    JSON
    `{"title": "test_title"}`
  
    [RESPONSE]
    ```
    {
        "success": bool,
        "errors": [],
        "data": {
            "id": "956615c3-02c3-43af-aafe-e501d4b90788",
                "user": {
                    "id": "0162939c-b4b4-4d5b-9350-b02c69080656",
                    "login": "admin",
                    "username": "admin",
                    "plainPassword": null,
                    "password": "$argon2id$v=19$m=65536,t=4,p=1$gfMmRGiKdvJ7GtZ6zwbE8A$waojhMSSO9U/ZLniEiGHsv57WHxjnf4t91j4V4RkTL4",
                    "salt": null,
                    "roles": [
                        "admin"
                    ],
                    "created": "2021-02-28T01:35:14+00:00",
                    "updated": "2021-02-28T01:35:15+00:00"
                },
            "title": "test newnewew",
            "created": "2021-03-01T08:54:31+00:00",
            "updated": null,
            "completed": false,
            "userId": null
        }
    }

 - **GET tasks**
   
    endpoint: `{{base_url}}/api/task/list?completed=0`
   
    _Request Params_  `completed (int, [1,0])`
   
    [RESPONSE]- see {create} response


 - **POST update**
`{{base_url}}/api/task/update/{id} (example id: 8c6240dc-6c62-4d53-9671-54a5a5e04321)`
    Request: _Body_ raw (json)
JSON
`{
    "title": "title"
}`
   
   [RESPONSE]- see {create} response


- **POST complete** `{{base_url}}/api/task/complete/{id}`

    [RESPONSE]- see {create} response
  

- **POST logout** `{{base_url}}/api/security/logout`


- **POST login** 
    `{{base_url}}/api/security/login`
    
    Request: _Body_ raw (json)
JSON
`{
"username": "admin",
"password": "password"
}`
  
    [RESPONSE]
```
{
"id": "0162939c-b4b4-4d5b-9350-b02c69080656",
"login": "admin",
"username": "admin",
"plainPassword": null,
"password": "",
"salt": null,
"roles": [
"admin"
],
"created": "2021-02-28T01:35:14+00:00",
"updated": "2021-02-28T01:35:15+00:00"
}
