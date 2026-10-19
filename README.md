Endpoints:

|Endpoint                       | Method     | Auth | Note                          |
| ------------------------------| ---------- | ---- | ----------------------------- |
|\login                         | POST       |      | add new user                  |     
|\counties                      | GET        |      | get all counties              |    
|\counties                      | POST       |  Y   | create new county             |     
|\counties\{id}                 | PUT        |  Y   | edit one county               |     
|\counties\{id}                 | DELETE     |  Y   | delete one county             |  
|\cities                        | GET        |      | get all cities                |     
|\cities                        | POST       |  Y   | create new city               |     
|\cities\{id}                   | PUT        |  Y   | edit one city                 |     
|\cities\{id}                   | DELETE     |  Y   | delete one city               |     
|\counties\{id}\cities          | GET        |      | get all cities in a county    |
|\cities\search?query={name}    | GET        |      | get all cities with the name  |
|\counties\search?query={name}  | GET        |      | get all counties with the name|
