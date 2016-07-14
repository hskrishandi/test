## Intro
The Controller-Service-Repository-Pattern is an extension of MVC, we separate the Model part of MVC, and come up with these two pattern: service and repository. Using this pattern, the task of each layer would be more specific 

## Explenation
**Controllers:** Handle user input and pass data to front-end.
**Services:** The middleware between controller and repository. Gather data from controller, performs validation and business logic, and calling repositories for data manipulation.
**Repositories:** layer for interaction with models and performing DB operations.

