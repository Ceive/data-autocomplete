Ceive.Data.Autocomplete
=======================

Component a helper autocomplete oriented system create

```
namespace Ceive\Data\Autocomplete;

$manager = new Manager();


$manager->register(new AutocompleteClass('User',[
    'username'      => 'string',
    'password'      => 'string',
    'login_counts'  => 'int',
    'profile'       => '<User\Profile>'
]));

$manager->register(new AutocompleteClass('User\Profile',[
    'first_name'        => 'string',
    'last_name'         => 'string',
    'second_name'       => 'string',
    'user'              => '<User>'
]));

$manager->register($autocomplete = new Autocomplete([
    'user' => '<User>',
    'value' => 'mixed',
]));


$user = $manager->getByClassname('User');

$entries = $autocomplete->entries();

$this->assertEquals([
    'user' => '<User>',
    'value' => 'mixed',
],$autocomplete->entries());


$this->assertEquals([
    'user' => '<User>',
],$autocomplete->entriesLink());

// Language Labeled
//$autocomplete->getTitle($entry);
//$autocomplete->getDescription($entry);
//$autocomplete->getType($entry);

// AbsolutePath
//$autocomplete->getAbsolutePath($entry_key);


$label = [
    'lang'          => null,
    'key'           => 'user',
    'description'   => null,

    'cases' => [[
        'lang'          => 'ru_RU',
        'title'         => 'пользователь',
        'description'   => 'описание'
    ]]
];

$label = [
    'lang'          => null,
    'key'           => 'current_user',
    'description'   => null,

    'cases' => [[
        'lang'          => 'ru_RU',
        'title'         => 'текущий пользователь',
        'description'   => 'пользователь, который в момент выполнения проводит авторизованное действие'
    ]]
];


```