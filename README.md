<br />
<br />

<p align="center">
  <img src=".doc/challenges.png" alt="dataoffice code challenge" width="80" height="80">
</p>

<h1 align="center">
  <b>
    SEAT:CODE Data Office Challenge done by Martí Puig Martin
  </b>
</h1>

<br />

### Introduction

This is my solution to the SEAT:CODE Data Office Challenge. I have used PHP 8.2 and Symfony 6.3.5 to develop the
solution.
I have also used:

- [Docker](https://www.docker.com/) to run the application.
- [MinIO](https://min.io/) as an S3 compatible storage.
- [OpenSearch](https://opensearch.org/) as a search engine.
- [Bref](https://bref.sh/) to handle the AWS Lambdas.
- [FrankenPHP](https://github.com/dunglas/frankenphp) an application server for PHP built on top of the Caddy web
  server.
- [Git LFS](https://git-lfs.com/) to store the images in the repository.

As well as other libraries that you can find in the composer.json file like:

- [FOSElasticaBundle](https://github.com/FriendsOfSymfony/FOSElasticaBundle) to integrate OpenSearch with Symfony.
- [GraphQLBundle](https://github.com/overblog/GraphQLBundle) to integrate GraphQL with Symfony.
- [Flysystem](https://flysystem.thephpleague.com/v2/docs/) to integrate MinIO with Symfony.
- [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle) to generate the API documentation.

And many more.

### Requirements

You will need to have installed:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Git LFS](https://git-lfs.github.com/)

### Commands

The project comes with a Makefile to make it easier to run the application. You can run the following commands:

- `make build` to build the docker images.
- `make up` to start the docker containers.
- `make down` to remove the docker containers.
- `make stop` to stop the docker containers.
- `make restart` to restart the docker containers.
- `make card-fetch` to run the card fetcher lambda to fill the database with the cards.
- `make psalm-lint` to run the psalm linter to check the code.
- `make cs-fix` to run the php-cs-fixer to fix the code style.

### Installation

In order to be able to fetch the data via LFS ensure that you have installed Git LFS and run the following commands:

    git lfs fetch
    git lfs pull

To install the application you have to run the following commands:

    make build
    make up
    make card-fetch

And that's it. You have the application running.

### Usage

Once you have the docker containers running, you can access the application in the following urls:

- [http://localhost](https://localhost) to access the API documentation.
- [http://localhost:9001](http://localhost:9001) to access the MinIO dashboard.
- [http://localhost/graphiql](https://localhost/graphiql) to access the GraphQL playground.

**Note:** The OpenSearch dashboard container is not added. I prefer to access using the Elasticvue extension for web
browsers. You can find it [here](https://elasticvue.com/).
Just add the following url: `http://localhost:9200` clicking the **Add cluster** button.

### Architecture

The application follow
a [Hexagonal architecture](https://en.wikipedia.org/wiki/Hexagonal_architecture_(software)), [DDD](https://en.wikipedia.org/wiki/Domain-driven_design)
and [CQRS](https://en.wikipedia.org/wiki/Command%E2%80%93query_separation) approach. The application is divided in the
following layers:

- **Core**: This part is more related to individual entities and their business logic. It is divided in three parts:
    - **Domain**: This part contains:
        - **Entity**: The entity itself.
        - **Repository**: The repository interface.
    - **Application**: This part contains:
        - **Model**: The DTO acting as a message in the commands and queries.
        - **Service**: The DTO handler.
    - **Infrastructure**: This part contains:
        - **Controller**: Rest Endpoints controllers.
        - **Lambda**: Lambdas handlers.
        - **Model**: Doctrine mapping.
        - **Repository**: Repositories implementations.
        - **Service**: Services implementations.
- **Shared**: This part contains shared code between the different entities or the application in general, as
  Exceptions, Subscribers, etc. It is divided in two parts:
    - **Domain**: This part contains the shared domain code:
        - **Exception**: Exceptions.
        - **Entity**: Abstract entities.
        - **Repository**: Paginator and Base repository interface.
    - **Infrastructure**: This part contains the shared infrastructure code:
        - **Http**: Contains subscribers.
        - **Repository**: The implementation of the base repository and the paginator interfaces.

### Rest

The application has the following endpoints:

- **GET api/card**: Get all the cards.
- **GET api/card/{cardId}**: Get a card by id.
- **PUT api/card/{cardId}**: Update a card by id.

### GraphQL

The application has the following GraphQL queries and mutations:

- **getCardCollection**: Get all the cards.
- **getCard**: Get a card by id.
- **putCard**: Update a card by id.

#### GraphQL example

```graphql
query {
    getCardCollection(filter: "", page: 1, limit: 10) {
        id
        text
    }
}
```

```graphql
query {
    getCard(cardId: 1) {
        id
        text
    }
}
```

```graphql
mutation {
    putCard(cardId: 1, text: "New text") {
        id
        text
    }
}
```

### Entities and fetcher

#### Card

The Card entity is the main entity of the application. It has a lot of fields, but the most important ones are:

- **id**: The id of the card.
- **text**: The text of the card.
- **uuid**: The uuid of the card.

For the sake of simplicity in the PUT and in some responses, the card only returns the id and text fields. The rest of
the fields are not returned, but they are saved in the database and OpenSearch.

#### CardFetcher

The CardFetcher lambda is a lambda that fetches the cards from the MinIO storage and saves them in the database. For
memory reasons it fetch set by set. Every set fetched is saved in the database. FOSElasticaBundle has listeners that
listen to the events of Doctrine and update the OpenSearch index accordingly. This process is repeated until all the
sets are fetched. The lambda is can be triggered manually
using the corresponding make command or via the s3:ObjectCreated:* event in the MinIO bucket.

### Use case example

If we take the PUT api/card/{cardId} endpoint as an example, the use case would be:

1. The controller receives the request and calls the putCard action with the cardId and text params.
2. The putCard action validates the request and create a new UpdateCardModel only if the request has the text param.
   UpdateCardModel is a DTO that acts as a message for the command.
3. The message is handled by the CardUpdater service.
4. The CardUpdater search the card in the database using the CardRepository and if it doesn't find it, throws a
   ResourceNotFoundException.
5. The CardUpdater calls the update method of the Card entity with the data of the message.
6. The Card entity validates the data and if it's valid, updates the card.
7. The Card is updated in the database.
8. The Card is updated in OpenSearch.
9. Then the putAction calls the getCard action from the CardQuery.
10. The getCard action validates again and create a new FindCardQuery.
11. The message is handled by the CardFinder service and again, if the card is not found, throws a
    ResourceNotFoundException, else, returns the card.
12. If the request is via Rest, the controller serializes the card and returns it.
13. If the request is via GraphQL, the resolver directly returns the card.

### Design decisions

#### Why use Getters trait instead of getters in the entities?

I prefer to use traits instead of putting the getters in the entities because if we follow the DDD approach the entities
should have the business logic. Using the trait makes very clear when we have
an [Anemic Domain Model](https://en.wikipedia.org/wiki/Anemic_domain_model), because we can see that the entity has no
logic, only getters and setters, making it easier to spot the problem.

#### Why having an abstract entity (AggregateRoot) instead of a simple entity?

I prefer to have an abstract entity because it makes it easier to add common logic to all the entities. If I was needed
to make Entities capable of dispatching events, I could add the logic in the abstract entity and all the entities would
be able to dispatch events.

#### Why don't use the ORM annotations in the entities?

When having a hexagonal architecture, the entities should be agnostic of the infrastructure. If we use the ORM
annotations in the entities, we are coupling the entities to the ORM. If we want to change the ORM, we will have to
change the entities too. That's why I prefer to use the ORM annotations in the mapping files.

#### What are the CardQuery and CardCommand?

They are actions. Instead of having the validation and calling the corresponding message in the controller and in the
Resolver for GraphQL, I prefer to have the validation and calls in an action. This way, the
controller and the resolver are only responsible for handling the params of the request
and the response (for example serializing the response in the controller case). Also, we can reuse the same action for
both Rest and GraphQL.

#### Why the putCard action doesn't return the card, and instead calls the getCard action?

The putCard action is a command. By definition, commands don't return anything. They only change the state of the
application. That's why the putCard action does not return the card. Instead, it calls the getCard action to get the
card and return it.

#### Why in the CardCollectionFinder if I don't send the param filter the collection is returned via Doctrine?

It's only to test the withPagination method and repository paginator. If I don't send the filter param, the
collection is returned via Doctrine. If I send the filter param, the collection is returned via OpenSearch.

#### What is the ExceptionSubscriber?

It's a subscriber that listens to the kernel.exception event. The function of the subscriber is to catch the exceptions
and instead of returning the html error page, return a json error response.

#### Why the PropertyNotSetInConstructor and UndefinedInterfaceMethod rules are disabled in psalm for some files?

- PropertyNotSetInConstructor: Using Dependency Injection in Symfony, the container is being set by the DI system
  itself. That's why the properties are not set in the constructor.
- UndefinedInterfaceMethod: [Bug](https://github.com/vimeo/psalm/issues/1764) in psalm.
