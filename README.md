PHP version used: 7.3.33

Thoght process:

1. Implemented Uncle Bob's Clean Architecture
2. Strict type checking where applicable (need >=v 8.0 to utilise covariance and contravariance)
3. When failing fail fast by throwing exceptions
4. Utilize Null Object Pattern to eliminate null checking in code (classes with prefix Empty)
5. Constructor, Presenter and UseCaseInteractor classes are instantiated dynamically using reflection in dependency injection container. Dependencies are listed in their constructors.
6. For every service (except logger and session services) there exist 2 implementations. Implementations with prefix Dummy just perform logging. Change KP\SOLID\Infra\App\DefaultServiceContainerBuilder class to change what implementation is used.
7. To show code reuse, created one page webapp. To call JSON web service, add "Content-Type: application/json" header to HTTP request. Endpoint is /sign-up.
