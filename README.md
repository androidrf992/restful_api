# RESTFUL API


### config

Параметры которые используются при работе приложения находятся в config/config.php

Потом они внедряются в контейнер приложения, и их можно получить по примеру:

```
$container->get('config')['auth.login'];
```
### application container binding

В config/container.php призводится наполнения контейнера зависимостями ядра приложения и бизнес логики.

Привязка осуществляется 2мя способами:

Просто по ключу связываем значение. В таком случае мы можем при необходимости получать один и тот же обьект при множественном вызове.
```
$container->set('config', $config);
```
Также в виде анонимной функции. В этом случае у нас есть ленивая загрузка, но при этом всегда получаем новый обьект, если он не синглтон. Также в анонимну функцию передается обект контейнера, через который рекурсивно можно получать зависимости.
```
$container->set(UserRepository::class, function ($c) {
    return new UserJsonFileRepository($c->get('config')['db.storage_path']);
});
```

В приложении есть метод App::container() который позволяет получить контейнер приложения на всех уровнях бизнес-логики
### routing

Роутинг приложения находится в config/routes.php. Он возращает экземпляр класса RouteCollection который используется приложением для матчинга реквеста с роутами.

Коллекция имеет несколько методов для создания роутов по методам запроса.

Пример добавления:

```
$collection->post('/login', [
    'controller' => \App\Controller\AuthController::class,
    'action' => 'loginAction'
]);
```
Методы коллекции возращают экземпляр  RouteInterface поэтому им можно добавить префикс или массив посредников:

```
$collection->post('/login', [
    'controller' => \App\Controller\AuthController::class,
    'action' => 'loginAction'
])->withPrefix('/api')->withMiddlewares([AuthMiddleware::class]);
```
Методы get, post, put, delete состоят со следующих частей:
```
string $pattern, $action, array $patternArgs = []
```
$pattern - строковое представление пути реквеста. Также в нем можно указывать биндинг части пути на переменную, для действия, с проверкой на регулярном выражении.

Например все что будет после /users/ будет мапится на переменную $userId с учетом того что оно этот результат соответсвует регулярному выражению указаному в patternArgs по этой переменной
```
$collection->put('/users/{userId}', [
        'controller' => UserController::class,
        'action' => 'updateAction'
    ], ['userId' => 'd+']);
```
Тоесть по этом примере по пути /users/100 в $userId будет значение 100, которое передатся в аргумент $userId функции action. Если путь будет /users/test - роут не сматчится т.к. test - не соотвeтсвует регулярному выражению d+

$action - может быть в виде колбек функции которая должна вернуть экземпляр ResponseInterface либо в виде массива. в которов указываются какой класс и метод вызвать
```
[
    'controller' => \App\Controller\AuthController::class,
    'action' => 'loginAction'
]
```
$patternArgs - используется, если в $pattern имеются переменные для матчинга.

Также RouteCollection имеет метод group, который можно использовать если есть необходимость для нескольких роутов указать общие посредники и префикс.
На вход он принимает колбек который должен вернуть новый экземпляр класса RouteCollection.
```
$collection->group(function (RouteCollection $collection) {
    $collection->get('/users', [
        'controller' => UserController::class,
        'action' => 'listAction'
    ]);
    $collection->get('/users/{userId}', [
        'controller' => UserController::class,
        'action' => 'getAction'
    ], ['userId' => 'd+']);

    return $collection;
})->withPrefix('/api')->withMiddlewares([AuthMiddleware::class]);
```

### middleware

Для использования своих посредников они должны быть экземплярами класса AbstractMiddleware и реализовать метод public function run(\Closure $next)
```
class AuthMiddleware extends AbstractMiddleware
{
    use JsonResponseTrait;

    public function run(\Closure $next)
    {
        /** @var AuthComponent $component */
        $component = App::container()->get(AuthComponent::class);
        if (!$component->isAuthenticated()) {
            return $this->errorJsonResponse('Need login to process request', ResponseCode::UNAUTHORIZED);
        }

        return $next();
    }
}
```
В рамках одного посредника можно обрабатывать запрос до и после выполнения метода action
```
    public function run(\Closure $next)
    {
		// before action

		$response = $next();
		
		// after action

        return $response;
    }
```

### request data validate

Для удобства валидации параметров от клиента реализован валидатор AbstractForm на уровне ядра приложения.


В контроллере достаточно создать экземпляр AbstractForm и вызвать метод $form->validate(RequestInterface $request) который вернет булевое значения
Если валидация неуспешна можно получить текст ошибки по $form->getError().
```
$form = new UserForm();
if (!$form->validate($request)) {
    return $this->errorJsonResponse($form->getError());
}
```
Экзепляры AbstractForm должны реализовать метод 
```
public function getValidatorCollection(): ValidatorCollection
```
ValidatorCollection - предоставляет коллекцию валидаторов которые проверяются в AbstractForm. ValidatorCollection имеет метод:
```
public function add($param, ValidatorInterface $validator)
```
В качестве ValidatorInterface можно использовать как доступны по умолчанию так и сообственные реализации.

Пример формы ресурса User
```
class UserForm extends AbstractForm
{
    public function getValidatorCollection(): ValidatorCollection
    {
        $collection = new ValidatorCollection();
        $collection->add('name', new TextValidator());
        $collection->add('age', new NumericValidator([0, 150]));
        $collection->add('address', new TextValidator());
        $collection->add('gender', new GenderValidator());

        return $collection;
    }
}